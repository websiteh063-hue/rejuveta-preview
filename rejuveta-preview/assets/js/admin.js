(function () {
    const form = document.querySelector('#admin-form');
    const message = document.querySelector('#admin-message');
    const reloadButton = document.querySelector('#reload-content');

    function showMessage(type, text) {
        message.hidden = false;
        message.className = 'admin-message ' + type;
        message.textContent = text;
    }

    function fillForm(content) {
        Object.keys(content).forEach(function (key) {
            if (form.elements[key]) {
                form.elements[key].value = content[key];
            }
        });
    }

    async function loadContent() {
        const response = await fetch('/api/content', { cache: 'no-store' });
        const data = await response.json();
        fillForm(data.content);
        if (!data.storageReady) {
            showMessage('error', 'Admin panel is ready, but permanent storage is not connected. Add Vercel Blob to save updates globally.');
        }
    }

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        const payload = Object.fromEntries(new FormData(form).entries());
        const password = payload.password;
        delete payload.password;

        try {
            const response = await fetch('/api/content', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Admin-Password': password,
                },
                body: JSON.stringify(payload),
            });
            const data = await response.json();
            if (!response.ok || !data.ok) {
                throw new Error(data.message || 'Could not save updates.');
            }
            showMessage('success', data.message || 'Website updated.');
        } catch (error) {
            showMessage('error', error.message);
        }
    });

    reloadButton.addEventListener('click', loadContent);
    loadContent().catch(function () {
        showMessage('error', 'Could not load content from the backend.');
    });
})();
