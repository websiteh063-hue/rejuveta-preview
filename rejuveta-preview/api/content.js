const CONTENT_API_URL = 'http://rejuveta-content-api.rejuveta-content-api.workers.dev/content';

export default async function handler(request, response) {
  if (request.method !== 'GET' && request.method !== 'POST') {
    response.setHeader('Allow', 'GET, POST');
    return response.status(405).json({ ok: false, message: 'Only GET and POST are allowed.' });
  }

  try {
    const upstream = await fetch(CONTENT_API_URL, {
      method: request.method,
      headers: {
        'Content-Type': 'application/json',
        'X-Admin-Password': String(request.headers['x-admin-password'] || ''),
      },
      body: request.method === 'POST' ? JSON.stringify(request.body || {}) : undefined,
    });

    const data = await upstream.json();
    return response.status(upstream.status).json(data);
  } catch (error) {
    return response.status(502).json({
      ok: false,
      message: 'The content backend is not reachable right now. Please try again.',
    });
  }
}
