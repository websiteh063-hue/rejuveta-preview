export default async function handler(request, response) {
  const recipientEmail = process.env.CONTACT_TO_EMAIL || 'doonvalleyhighschool80@gmail.com';

  if (request.method !== 'POST') {
    response.setHeader('Allow', 'POST');
    return response.status(405).json({ ok: false, message: 'Only POST requests are allowed.' });
  }

  let payload;
  try {
    payload = typeof request.body === 'string' ? JSON.parse(request.body) : request.body;
  } catch (error) {
    return response.status(400).json({ ok: false, message: 'Invalid form payload.' });
  }

  const name = String(payload?.name || '').trim();
  const email = String(payload?.email || '').trim();
  const subject = String(payload?.subject || '').trim();
  const message = String(payload?.message || '').trim();
  const website = String(payload?.website || '').trim();

  if (website) {
    return response.status(200).json({ ok: true, message: 'Thank you. Your message has been received.' });
  }

  if (name.length < 2 || subject.length < 3 || message.length < 10 || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    return response.status(422).json({ ok: false, message: 'Please complete all fields with valid details.' });
  }

  const reference = `RHC-${Date.now().toString(36).toUpperCase()}`;

  if (process.env.RESEND_API_KEY) {
    try {
      const emailResponse = await fetch('https://api.resend.com/emails', {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${process.env.RESEND_API_KEY}`,
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          from: process.env.CONTACT_FROM_EMAIL || 'Rejuveta Website <onboarding@resend.dev>',
          to: recipientEmail,
          reply_to: email,
          subject: `Rejuveta enquiry: ${subject}`,
          text: `Reference: ${reference}\nName: ${name}\nEmail: ${email}\nSubject: ${subject}\n\n${message}`,
        }),
      });

      if (!emailResponse.ok) {
        throw new Error('Email provider rejected the request.');
      }
    } catch (error) {
      return response.status(502).json({ ok: false, message: 'The message could not be emailed right now. Please try again.' });
    }
  } else {
    try {
      const relayResponse = await fetch(`https://formsubmit.co/ajax/${recipientEmail}`, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          _subject: `Rejuveta enquiry: ${subject}`,
          _template: 'table',
          _captcha: 'false',
          reference,
          name,
          email,
          subject,
          message,
        }),
      });

      if (!relayResponse.ok) {
        throw new Error('Email relay rejected the request.');
      }
    } catch (error) {
      return response.status(502).json({
        ok: false,
        message: `The message could not be emailed automatically. Please email ${recipientEmail} directly.`,
      });
    }
  }

  return response.status(200).json({
    ok: true,
    reference,
    message: `Thank you, ${name}. Your message has been received. Reference: ${reference}`,
  });
}
