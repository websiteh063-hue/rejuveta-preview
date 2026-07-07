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
})();
