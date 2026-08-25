import './bootstrap';

window.Umera = {
    modals: new Set(),

    openModal(id) {
        const modal = document.getElementById(`modal-${id}`);
        const backdrop = document.getElementById(`backdrop-${id}`);
        if (modal && backdrop) {
            modal.classList.remove('hidden');
            backdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            this.modals.add(id);
        }
    },

    closeModal(id) {
        const modal = document.getElementById(`modal-${id}`);
        const backdrop = document.getElementById(`backdrop-${id}`);
        if (modal && backdrop) {
            modal.classList.add('hidden');
            backdrop.classList.add('hidden');
            this.modals.delete(id);
            if (this.modals.size === 0) {
                document.body.style.overflow = '';
            }
        }
    },

    closeAllModals() {
        this.modals.forEach(id => this.closeModal(id));
    },

    toggleSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if (sidebar && overlay) {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0');
            overlay.classList.toggle('hidden');
            document.body.style.overflow = sidebar.classList.contains('-translate-x-full') ? '' : 'hidden';
        }
    },

    closeSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if (sidebar && overlay) {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }
    },

    copyToClipboard(text, successMessage = 'Copied successfully!') {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                this.showToast(successMessage, 'success');
            }).catch(() => {
                this.fallbackCopy(text);
                this.showToast(successMessage, 'success');
            });
        } else {
            this.fallbackCopy(text);
            this.showToast(successMessage, 'success');
        }
    },

    fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
        } catch (err) {
            console.error('Copy failed:', err);
        }
        document.body.removeChild(textarea);
    },

    toasts: new Set(),

    showToast(message, type = 'info', duration = 3500) {
        const id = 'toast-' + Date.now();
        const colors = {
            success: { border: 'var(--color-success-500)', icon: '✓', iconBg: 'var(--color-success-50)', iconColor: 'var(--color-success-600)' },
            error: { border: 'var(--color-error-500)', icon: '✕', iconBg: 'var(--color-error-50)', iconColor: 'var(--color-error-600)' },
            warning: { border: 'var(--color-warning-500)', icon: '!', iconBg: 'var(--color-warning-50)', iconColor: 'var(--color-warning-600)' },
            info: { border: 'var(--color-info-500)', icon: 'ⓘ', iconBg: 'var(--color-info-50)', iconColor: 'var(--color-info-600)' },
        };
        const c = colors[type] || colors.info;

        const toast = document.createElement('div');
        toast.id = id;
        toast.className = 'toast';
        toast.style.borderLeftWidth = '4px';
        toast.style.borderLeftColor = c.border;
        toast.innerHTML = `
            <div style="display:flex;align-items:center;justify-content:center;width:2rem;height:2rem;border-radius:9999px;background-color:${c.iconBg};color:${c.iconColor};font-weight:700;">${c.icon}</div>
            <div style="flex:1;">
                <div style="font-size:0.875rem;font-weight:500;color:var(--color-neutral-800);">${message}</div>
            </div>
            <button onclick="Umera.removeToast('${id}')" style="color:var(--color-neutral-400);background:none;border:none;cursor:pointer;padding:0.25rem;font-size:1.125rem;">&times;</button>
        `;
        document.body.appendChild(toast);
        this.toasts.add(id);

        if (duration > 0) {
            setTimeout(() => this.removeToast(id), duration);
        }
        return id;
    },

    removeToast(id) {
        const toast = document.getElementById(id);
        if (toast) {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-12px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => {
                if (toast.parentNode) toast.remove();
                this.toasts.delete(id);
            }, 300);
        }
    },

    simulateLookup(formId) {
        const form = document.getElementById(formId);
        if (!form) return false;
        form.classList.add('hidden');
        const loading = document.getElementById('lookup-loading');
        const result = document.getElementById('lookup-result');
        if (loading) loading.classList.remove('hidden');
        if (result) result.classList.add('hidden');

        setTimeout(() => {
            if (loading) loading.classList.add('hidden');
            const email = form.querySelector('input[type="email"]').value.toLowerCase();
            let state = 'found';
            if (email.includes('notfound') || email.includes('unknown')) state = 'notfound';
            else if (email.includes('ineligible') || email.includes('pending')) state = 'ineligible';
            this.showLookupState(state);
        }, 1800);
        return false;
    },

    showLookupState(state) {
        const found = document.getElementById('lookup-found');
        const notFound = document.getElementById('lookup-notfound');
        const ineligible = document.getElementById('lookup-ineligible');
        const tryAgainBtns = document.querySelectorAll('[data-lookup-reset]');
        const loading = document.getElementById('lookup-loading');
        const form = document.getElementById('lookup-form');

        [found, notFound, ineligible].forEach(el => el && el.classList.add('hidden'));

        if (state === 'found' && found) found.classList.remove('hidden');
        if (state === 'notfound' && notFound) notFound.classList.remove('hidden');
        if (state === 'ineligible' && ineligible) ineligible.classList.remove('hidden');

        tryAgainBtns.forEach(btn => {
            btn.onclick = () => {
                [found, notFound, ineligible].forEach(el => el && el.classList.add('hidden'));
                if (form) form.classList.remove('hidden');
                if (loading) loading.classList.add('hidden');
                const input = form ? form.querySelector('input[type="email"]') : null;
                if (input) input.value = '';
            };
        });
    },

    handleDrop(zoneId, inputId) {
        const zone = document.getElementById(zoneId);
        const input = document.getElementById(inputId);
        if (!zone || !input) return;

        ['dragenter', 'dragover'].forEach(evt => {
            zone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                zone.style.borderColor = 'var(--color-umbera-500)';
                zone.style.backgroundColor = 'var(--color-umbera-50)';
            });
        });

        ['dragleave', 'drop'].forEach(evt => {
            zone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                zone.style.borderColor = 'var(--color-neutral-300)';
                zone.style.backgroundColor = 'var(--color-neutral-50)';
            });
        });

        zone.addEventListener('drop', (e) => {
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                const name = e.dataTransfer.files[0]?.name || '';
                const info = document.getElementById('dropzone-info');
                if (info) info.textContent = name;
            }
        });

        zone.addEventListener('click', () => input.click());
    }
};

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        Umera.closeAllModals();
        Umera.closeSidebar();
    }
});
