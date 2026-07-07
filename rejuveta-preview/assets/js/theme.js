(function () {
    const body = document.body;
    const navToggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('.primary-nav');

    function finishLoading() {
        body.classList.add('loaded');
    }

    window.addEventListener('load', finishLoading);
    window.setTimeout(finishLoading, 1800);

    if (navToggle && nav) {
        navToggle.addEventListener('click', function () {
            const isOpen = nav.classList.toggle('is-open');
            navToggle.setAttribute('aria-expanded', String(isOpen));
        });
    }

    const revealItems = document.querySelectorAll('.reveal');
    const typingItems = document.querySelectorAll('.typing-text[data-type-text]');

    function typeText(element) {
        if (element.dataset.typed === 'true') {
            return;
        }

        const text = element.dataset.typeText || element.textContent;
        let index = 0;
        element.dataset.typed = 'true';
        element.textContent = '';
        element.classList.add('is-typing');

        const timer = window.setInterval(function () {
            element.textContent = text.slice(0, index + 1);
            index += 1;

            if (index >= text.length) {
                window.clearInterval(timer);
                window.setTimeout(function () {
                    element.classList.remove('is-typing');
                }, 900);
            }
        }, 38);
    }

    if (!('IntersectionObserver' in window)) {
        revealItems.forEach(function (item) {
            item.classList.add('is-visible');
        });
        typingItems.forEach(typeText);
        return;
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.14 });

    revealItems.forEach(function (item) {
        observer.observe(item);
    });

    const typingObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                typeText(entry.target);
                typingObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.45 });

    typingItems.forEach(function (item) {
        typingObserver.observe(item);
    });

    const filterButtons = document.querySelectorAll('.filter-button[data-filter]');
    const galleryCards = Array.from(document.querySelectorAll('.gallery-card[data-category]'));
    const lightbox = document.querySelector('.gallery-lightbox');
    const lightboxImage = lightbox ? lightbox.querySelector('img') : null;
    const lightboxTitle = lightbox ? lightbox.querySelector('figcaption strong') : null;
    const lightboxCaption = lightbox ? lightbox.querySelector('figcaption span') : null;
    let activeGalleryItems = galleryCards;
    let activeGalleryIndex = 0;

    function updateGalleryFilter(filter) {
        activeGalleryItems = [];
        galleryCards.forEach(function (card) {
            const shouldShow = filter === 'all' || card.dataset.category === filter;
            card.classList.toggle('is-hidden', !shouldShow);
            if (shouldShow) {
                activeGalleryItems.push(card);
            }
        });
    }

    filterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            filterButtons.forEach(function (item) {
                item.classList.remove('is-active');
            });
            button.classList.add('is-active');
            updateGalleryFilter(button.dataset.filter);
        });
    });

    function openLightbox(card) {
        if (!lightbox || !lightboxImage || !lightboxTitle || !lightboxCaption) {
            return;
        }

        activeGalleryIndex = Math.max(0, activeGalleryItems.indexOf(card));
        lightboxImage.src = card.dataset.src;
        lightboxImage.alt = card.dataset.title;
        lightboxTitle.textContent = card.dataset.title;
        lightboxCaption.textContent = card.dataset.caption;
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        if (!lightbox) {
            return;
        }

        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    function moveLightbox(direction) {
        if (!activeGalleryItems.length) {
            return;
        }

        activeGalleryIndex = (activeGalleryIndex + direction + activeGalleryItems.length) % activeGalleryItems.length;
        openLightbox(activeGalleryItems[activeGalleryIndex]);
    }

    galleryCards.forEach(function (card) {
        card.addEventListener('click', function () {
            openLightbox(card);
        });
    });

    if (lightbox) {
        const closeButton = lightbox.querySelector('.lightbox-close');
        const previousButton = lightbox.querySelector('.lightbox-prev');
        const nextButton = lightbox.querySelector('.lightbox-next');

        if (closeButton) {
            closeButton.addEventListener('click', closeLightbox);
        }
        if (previousButton) {
            previousButton.addEventListener('click', function () {
                moveLightbox(-1);
            });
        }
        if (nextButton) {
            nextButton.addEventListener('click', function () {
                moveLightbox(1);
            });
        }

        lightbox.addEventListener('click', function (event) {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (!lightbox.classList.contains('is-open')) {
                return;
            }
            if (event.key === 'Escape') {
                closeLightbox();
            }
            if (event.key === 'ArrowLeft') {
                moveLightbox(-1);
            }
            if (event.key === 'ArrowRight') {
                moveLightbox(1);
            }
        });
    }

    const newsFilterButtons = document.querySelectorAll('.filter-button[data-news-filter]');
    const newsCards = Array.from(document.querySelectorAll('.news-card[data-news-category]'));

    newsFilterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const filter = button.dataset.newsFilter;
            newsFilterButtons.forEach(function (item) {
                item.classList.remove('is-active');
            });
            button.classList.add('is-active');
            newsCards.forEach(function (card) {
                card.classList.toggle('is-hidden', filter !== 'all' && card.dataset.newsCategory !== filter);
            });
        });
    });

    const contactForm = document.querySelector('[data-contact-form]');

    function setFormMessage(form, type, text) {
        const message = form.querySelector('[data-form-message]');
        if (!message) {
            return;
        }

        message.hidden = false;
        message.classList.remove('success', 'error');
        message.classList.add(type);
        message.textContent = text;
    }

    function validateContactForm(form) {
        const fields = Array.from(form.querySelectorAll('input[required], textarea[required]'));
        let isValid = true;

        fields.forEach(function (field) {
            const valid = field.checkValidity();
            field.classList.toggle('is-invalid', !valid);
            if (!valid) {
                isValid = false;
            }
        });

        return isValid;
    }

    if (contactForm) {
        contactForm.addEventListener('input', function (event) {
            if (event.target.matches('input, textarea')) {
                event.target.classList.remove('is-invalid');
            }
        });

        contactForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            if (!validateContactForm(contactForm)) {
                setFormMessage(contactForm, 'error', 'Please fill name, valid email, subject, and a message of at least 10 characters.');
                return;
            }

            const submitButton = contactForm.querySelector('button[type="submit"]');
            const submitText = contactForm.querySelector('[data-submit-text]');
            const formData = new FormData(contactForm);
            const payload = Object.fromEntries(formData.entries());

            contactForm.classList.add('is-submitting');
            if (submitButton) {
                submitButton.disabled = true;
            }
            if (submitText) {
                submitText.textContent = 'Sending...';
            }

            try {
                const result = await fetch('/api/contact', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                });
                const data = await result.json();

                if (!result.ok || !data.ok) {
                    throw new Error(data.message || 'Unable to send message.');
                }

                const submissions = JSON.parse(window.localStorage.getItem('rejuvetaContactSubmissions') || '[]');
                submissions.unshift({
                    reference: data.reference || '',
                    name: payload.name,
                    email: payload.email,
                    subject: payload.subject,
                    message: payload.message,
                    date: new Date().toISOString(),
                });
                window.localStorage.setItem('rejuvetaContactSubmissions', JSON.stringify(submissions.slice(0, 10)));

                contactForm.reset();
                setFormMessage(contactForm, 'success', data.message || 'Thank you. Your message has been received.');
            } catch (error) {
                const mailto = 'mailto:doonvalleyhighschool80@gmail.com?subject=' + encodeURIComponent(payload.subject || 'Website enquiry') + '&body=' + encodeURIComponent('Name: ' + payload.name + '\nEmail: ' + payload.email + '\n\n' + payload.message);
                setFormMessage(contactForm, 'error', 'The server could not send this right now. You can email us directly: doonvalleyhighschool80@gmail.com');
                window.setTimeout(function () {
                    window.location.href = mailto;
                }, 700);
            } finally {
                contactForm.classList.remove('is-submitting');
                if (submitButton) {
                    submitButton.disabled = false;
                }
                if (submitText) {
                    submitText.textContent = 'Send Message';
                }
            }
        });
    }

    async function hydrateManagedContent() {
        try {
            const response = await fetch('/api/content', { cache: 'no-store' });
            if (!response.ok) {
                return;
            }
            const data = await response.json();
            const content = data.content || {};

            document.querySelectorAll('[data-content]').forEach(function (element) {
                const key = element.dataset.content;
                if (key === 'address' && content[key] === 'Add your office address here') {
                    return;
                }
                if (content[key]) {
                    element.textContent = content[key];
                    if (element.classList.contains('typing-text')) {
                        element.dataset.typeText = content[key];
                    }
                }
            });

            document.querySelectorAll('[data-link]').forEach(function (element) {
                const key = element.dataset.link;
                if (content[key]) {
                    element.href = content[key];
                }
            });
        } catch (error) {
            // Keep static fallback content if the backend is unavailable.
        }
    }

    hydrateManagedContent();
})();
