const navToggle = document.getElementById('nav-toggle');
const mobileMenu = document.getElementById('mobile-menu');
const iconOpen = document.getElementById('nav-icon-open');
const iconClose = document.getElementById('nav-icon-close');

if (navToggle && mobileMenu) {
    navToggle.addEventListener('click', () => {
        const isOpen = !mobileMenu.classList.contains('hidden');

        mobileMenu.classList.toggle('hidden', isOpen);
        iconOpen.classList.toggle('hidden', !isOpen);
        iconClose.classList.toggle('hidden', isOpen);
        navToggle.setAttribute('aria-expanded', String(!isOpen));
    });
}


function submitFormAjax(form, { onSuccess, onError }) {
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        form.querySelectorAll('[data-error-for]').forEach((el) => (el.textContent = ''));

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn && (submitBtn.disabled = true);

        try {
            const response = await fetch(form.action, {
                method: form.method || 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: new FormData(form),
            });

            if (response.status === 422) {
                const { errors } = await response.json();
                Object.entries(errors).forEach(([field, messages]) => {
                    const el = form.querySelector(`[data-error-for="${field}"]`);
                    el && (el.textContent = messages[0]);
                });
                return;
            }

            if (!response.ok) {
                onError ? onError(response) : alert('Something went wrong. Please try again.');
                return;
            }

            await onSuccess(response);
        } catch (e) {
            onError ? onError(e) : alert('Network error. Please try again.');
        } finally {
            submitBtn && (submitBtn.disabled = false);
        }
    });
}


const ticketForm = document.getElementById('ticket-form');
if (ticketForm) {
    submitFormAjax(ticketForm, {
        onSuccess: async (response) => {
            const data = await response.json();
            document.getElementById('ticket-reference').textContent = data.reference;
            document.getElementById('ticket-success').classList.remove('hidden');
            ticketForm.reset();
        },
    });
}


const statusForm = document.getElementById('status-form');
if (statusForm) {
    const statusResult = document.getElementById('status-result');
    submitFormAjax(statusForm, {
        onSuccess: async (response) => {
            statusResult.innerHTML = await response.text();
        },
        onError: async (response) => {
            if (response instanceof Response && response.status === 404) {
                const data = await response.json();
                statusResult.innerHTML = `<div class="alert alert--error">${data.message}</div>`;
                return;
            }
            alert('Something went wrong. Please try again.');
        },
    });
}


const ticketsTable = document.getElementById('tickets-table');
const ticketSearch = document.getElementById('ticket-search');

if (ticketsTable && ticketSearch) {
    const baseUrl = ticketsTable.dataset.url;

    async function loadTickets(url) {
        const response = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });
        ticketsTable.innerHTML = await response.text();
        history.replaceState(null, '', url);
    }

    let debounceTimer;
    ticketSearch.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const url = new URL(baseUrl, window.location.origin);
            if (ticketSearch.value.trim()) {
                url.searchParams.set('search', ticketSearch.value.trim());
            }
            loadTickets(url.toString());
        }, 300);
    });

    // pagination links bind to url
    ticketsTable.addEventListener('click', (event) => {
        const link = event.target.closest('.pagination a[href]');
        if (!link) return;

        event.preventDefault();
        loadTickets(link.href);
    });
}


const replyForm = document.getElementById('reply-form');
if (replyForm) {
    const thread = document.getElementById('thread');
    const replyFlash = document.getElementById('reply-flash');
    submitFormAjax(replyForm, {
        onSuccess: async (response) => {
            thread.innerHTML = await response.text();
            replyForm.reset();
            replyFlash.classList.remove('hidden');
            setTimeout(() => replyFlash.classList.add('hidden'), 2000);
        },
    });
}
