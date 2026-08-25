document.documentElement.classList.add('has-js');

const menuToggle = document.querySelector('[data-menu-toggle]');
const mobileMenu = document.querySelector('[data-mobile-menu]');

if (menuToggle && mobileMenu) {
    const closeMenu = () => {
        menuToggle.setAttribute('aria-expanded', 'false');
        mobileMenu.classList.remove('is-open');
    };

    menuToggle.addEventListener('click', () => {
        const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';

        menuToggle.setAttribute('aria-expanded', String(!isOpen));
        mobileMenu.classList.toggle('is-open', !isOpen);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMenu();
            menuToggle.focus();
        }
    });

    mobileMenu.addEventListener('click', (event) => {
        if (event.target.closest('a')) {
            closeMenu();
        }
    });

    window.matchMedia('(min-width: 48rem)').addEventListener('change', (event) => {
        if (event.matches) {
            closeMenu();
        }
    });
}

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const revealTargets = document.querySelectorAll('[data-reveal]');

if (!reduceMotion && 'IntersectionObserver' in window && revealTargets.length) {
    document.querySelectorAll('[data-accord-meter]').forEach((meter) => {
        meter.classList.add('is-pending');
    });

    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-revealed');

            if (entry.target.matches('[data-accords]')) {
                entry.target.querySelectorAll('[data-accord-meter]').forEach((meter) => {
                    meter.classList.remove('is-pending');
                    meter.classList.add('is-revealed');
                });
            }

            observer.unobserve(entry.target);
        });
    }, { threshold: 0.14, rootMargin: '0px 0px -5% 0px' });

    revealTargets.forEach((target) => revealObserver.observe(target));
} else {
    revealTargets.forEach((target) => target.classList.add('is-revealed'));
}

const backToTop = document.querySelector('[data-back-to-top]');

if (backToTop) {
    const updateBackToTop = () => {
        const shouldShow = window.scrollY > 560;

        backToTop.hidden = false;
        backToTop.classList.toggle('is-visible', shouldShow);
        backToTop.tabIndex = shouldShow ? 0 : -1;
    };

    updateBackToTop();
    window.addEventListener('scroll', updateBackToTop, { passive: true });

    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
    });
}

const aromaWizard = document.querySelector('[data-aroma-wizard]');

if (aromaWizard) {
    const steps = [...aromaWizard.querySelectorAll('[data-aroma-step]')];
    const progress = aromaWizard.querySelector('[data-aroma-progress]');
    const stepLabel = aromaWizard.querySelector('[data-aroma-step-label]');
    const status = aromaWizard.querySelector('[data-aroma-status]');
    const error = aromaWizard.querySelector('[data-aroma-error]');
    const back = aromaWizard.querySelector('[data-aroma-back]');
    const next = aromaWizard.querySelector('[data-aroma-next]');
    const submit = aromaWizard.querySelector('[data-aroma-submit]');
    let currentStep = 0;

    const selectedOptions = (step) => step.querySelectorAll('input:checked');

    const showError = (message) => {
        error.textContent = message;
        error.hidden = false;
    };

    const clearError = () => {
        error.textContent = '';
        error.hidden = true;
    };

    const hasSelection = (step) => selectedOptions(step).length > 0;

    const showStep = (index, shouldFocus = true) => {
        currentStep = index;
        steps.forEach((step, stepIndex) => {
            const isCurrent = stepIndex === currentStep;

            step.hidden = !isCurrent;
            step.classList.toggle('is-current', isCurrent);
        });

        const progressValue = ((currentStep + 1) / steps.length) * 100;
        progress.style.setProperty('--aroma-progress', `${progressValue}%`);
        stepLabel.textContent = `Pregunta ${currentStep + 1} de ${steps.length}`;
        status.textContent = `Mostrando pregunta ${currentStep + 1} de ${steps.length}.`;
        back.disabled = currentStep === 0;
        next.hidden = currentStep === steps.length - 1;
        submit.hidden = currentStep !== steps.length - 1;
        clearError();

        if (shouldFocus) {
            steps[currentStep].querySelector('legend').focus();
        }
    };

    const moveForward = () => {
        if (!hasSelection(steps[currentStep])) {
            showError('Selecciona al menos una opcion para continuar.');
            steps[currentStep].querySelector('input').focus();
            return;
        }

        showStep(Math.min(currentStep + 1, steps.length - 1));
    };

    next.addEventListener('click', moveForward);
    back.addEventListener('click', () => showStep(Math.max(currentStep - 1, 0)));
    aromaWizard.addEventListener('change', clearError);

    aromaWizard.addEventListener('submit', (event) => {
        const incompleteStep = steps.findIndex((step) => !hasSelection(step));

        if (incompleteStep !== -1) {
            event.preventDefault();
            showStep(incompleteStep);
            showError('Completa esta pregunta antes de revelar tu seleccion.');
            return;
        }

        if (aromaWizard.dataset.submitting === 'true') {
            return;
        }

        event.preventDefault();
        aromaWizard.dataset.submitting = 'true';
        aromaWizard.classList.add('is-loading');
        status.textContent = 'Estamos analizando tus preferencias...';
        back.disabled = true;
        next.disabled = true;
        submit.disabled = true;

        window.setTimeout(() => aromaWizard.submit(), reduceMotion ? 0 : 1000);
    });

    showStep(0, false);
}

const adminShell = document.querySelector('[data-admin-shell]');
const adminSidebarToggle = document.querySelector('[data-admin-sidebar-toggle]');
const adminSidebar = document.querySelector('#admin-sidebar');

if (adminShell && adminSidebarToggle && adminSidebar) {
    const mobileAdminNavigation = window.matchMedia('(max-width: 47.99rem)');
    const collapsePreference = 'parfum-admin-sidebar-collapsed';

    const readPreference = () => {
        try {
            return window.localStorage.getItem(collapsePreference) === 'true';
        } catch {
            return false;
        }
    };

    const writePreference = (collapsed) => {
        try {
            window.localStorage.setItem(collapsePreference, String(collapsed));
        } catch {
            // Navigation remains functional when storage is unavailable.
        }
    };

    const syncAdminNavigation = () => {
        const isMobile = mobileAdminNavigation.matches;
        const isCollapsed = !isMobile && readPreference();

        adminShell.classList.toggle('is-sidebar-open', false);
        adminShell.classList.toggle('is-sidebar-collapsed', isCollapsed);
        adminSidebar.inert = isMobile;
        adminSidebarToggle.setAttribute('aria-expanded', String(!isCollapsed && !isMobile));
    };

    adminSidebarToggle.addEventListener('click', () => {
        if (mobileAdminNavigation.matches) {
            const isOpen = adminShell.classList.toggle('is-sidebar-open');

            adminSidebar.inert = !isOpen;
            adminSidebarToggle.setAttribute('aria-expanded', String(isOpen));
            return;
        }

        const isCollapsed = !adminShell.classList.contains('is-sidebar-collapsed');

        adminShell.classList.toggle('is-sidebar-collapsed', isCollapsed);
        adminSidebarToggle.setAttribute('aria-expanded', String(!isCollapsed));
        writePreference(isCollapsed);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && mobileAdminNavigation.matches && adminShell.classList.contains('is-sidebar-open')) {
            adminShell.classList.remove('is-sidebar-open');
            adminSidebar.inert = true;
            adminSidebarToggle.setAttribute('aria-expanded', 'false');
            adminSidebarToggle.focus();
        }
    });

    mobileAdminNavigation.addEventListener('change', syncAdminNavigation);
    syncAdminNavigation();
}
