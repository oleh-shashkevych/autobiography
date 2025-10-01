document.addEventListener('DOMContentLoaded', function () {
    // --- Theme Toggler ---
    const themeSwitch = document.getElementById('theme-switcher-toggle');
    function applyTheme(theme) {
        if (theme === 'light-theme') {
            document.body.classList.remove('dark-theme');
            document.body.classList.add('light-theme');
            if(themeSwitch) themeSwitch.checked = true;
        } else {
            document.body.classList.remove('light-theme');
            document.body.classList.add('dark-theme');
            if(themeSwitch) themeSwitch.checked = false;
        }
    }
    function toggleTheme() {
        if (document.body.classList.contains('dark-theme')) {
            localStorage.setItem('theme', 'light-theme');
            applyTheme('light-theme');
        } else {
            localStorage.setItem('theme', 'dark-theme');
            applyTheme('dark-theme');
        }
    }
    const savedTheme = localStorage.getItem('theme') || 'dark-theme';
    applyTheme(savedTheme);
    if (themeSwitch) {
        themeSwitch.addEventListener('change', toggleTheme);
    }

    // --- Phone Number Copy ---
    const phoneLinks = document.querySelectorAll('.header__contact-link[data-copy-text]');
    phoneLinks.forEach(phoneLink => {
        phoneLink.addEventListener('click', function (e) {
            if (this.closest('.mobile-menu__footer') && this.href.startsWith('tel:')) return;
            e.preventDefault();
            navigator.clipboard.writeText(this.dataset.copyText).then(() => {
                const originalText = this.querySelector('.header__contact-text').textContent;
                this.querySelector('.header__contact-text').textContent = 'Скопійовано!';
                setTimeout(() => { this.querySelector('.header__contact-text').textContent = originalText; }, 1500);
            }).catch(err => console.error('Could not copy text: ', err));
        });
    });
    
    // --- Mobile Menu Toggle ---
    const burgerButton = document.querySelector('.header__burger-button');
    const mobilePanel = document.querySelector('.mobile-menu-panel');
    if (burgerButton && mobilePanel) {
        burgerButton.addEventListener('click', function() {
            this.classList.toggle('is-open');
            mobilePanel.classList.toggle('is-open');
            this.setAttribute('aria-expanded', this.classList.contains('is-open'));
        });
    }

    // --- Accordion Menu for Mobile ---
    document.querySelectorAll('.mobile-menu-panel .menu-item-has-children > a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const parentLi = this.parentElement;
            const submenu = parentLi.querySelector('.sub-menu');
            if (parentLi.classList.contains('is-open')) {
                parentLi.classList.remove('is-open');
                submenu.style.maxHeight = null;
            } else {
                parentLi.closest('.header__menu-list').querySelectorAll('.menu-item-has-children.is-open').forEach(openItem => {
                    openItem.classList.remove('is-open');
                    openItem.querySelector('.sub-menu').style.maxHeight = null;
                });
                parentLi.classList.add('is-open');
                submenu.style.maxHeight = submenu.scrollHeight + "px";
            }
        });
    });

    // --- Back to Top Button ---
    const backToTopButton = document.querySelector('.back-to-top');
    if (backToTopButton) {
        window.addEventListener('scroll', () => {
            backToTopButton.classList.toggle('is-visible', window.scrollY > 300);
        });
        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // --- Hero Slider ---
    if (document.querySelector('.hero-slider')) {
        const heroSlider = new Swiper('.hero-slider', {
            loop: true,
            effect: 'fade',
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });
    }

    // --- НОВОЕ: Lightbox Gallery for Clients ---
    if (document.querySelector('.our-clients__gallery')) {
        baguetteBox.run('.our-clients__gallery');
    }

    // --- НОВОЕ: Tabs for Our Services Section ---
    const servicesSection = document.querySelector('.our-services');
    if (servicesSection) {
        const tabButtons = servicesSection.querySelectorAll('.our-services__tab-item');
        const tabPanels = servicesSection.querySelectorAll('.our-services__panel');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active classes from all
                tabButtons.forEach(btn => btn.classList.remove('is-active'));
                tabPanels.forEach(panel => panel.classList.remove('is-active'));

                // Add active class to clicked button and corresponding panel
                this.classList.add('is-active');
                const targetPanelId = this.dataset.tab;
                document.getElementById(targetPanelId).classList.add('is-active');
            });
        });
    }

    // --- НОВОЕ: Parallax for Page Hero ---
    const heroWithImage = document.querySelector('.page-hero[style*="background-image"]');
    if (heroWithImage) {
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Заменили строку ниже, чтобы фон начинался с центра (50%)
            heroWithImage.style.backgroundPosition = `center calc(50% + ${scrollTop * 0.3}px)`;
        });
    }
});