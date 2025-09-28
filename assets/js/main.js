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
    // Эта часть остается без изменений
    const phoneLinks = document.querySelectorAll('.header__contact-link[data-copy-text]');
    phoneLinks.forEach(phoneLink => {
        phoneLink.addEventListener('click', function (e) {
            // Разрешаем переход по ссылке для мобильных контактов
            if (this.closest('.mobile-menu__footer')) {
                 if (this.href.startsWith('tel:')) return;
            }
            e.preventDefault();
            const numberToCopy = this.dataset.copyText;
            navigator.clipboard.writeText(numberToCopy).then(() => {
                const originalText = this.querySelector('.header__contact-text').textContent;
                this.querySelector('.header__contact-text').textContent = 'Скопійовано!';
                setTimeout(() => {
                    this.querySelector('.header__contact-text').textContent = originalText;
                }, 1500);
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        });
    });
    

    // --- Mobile Menu Toggle ---
    const burgerButton = document.querySelector('.header__burger-button');
    const mobilePanel = document.querySelector('.mobile-menu-panel'); // ИСПРАВЛЕНО

    if (burgerButton && mobilePanel) { // ИСПРАВЛЕНО
        burgerButton.addEventListener('click', function() {
            burgerButton.classList.toggle('is-open');
            mobilePanel.classList.toggle('is-open'); // ИСПРАВЛЕНО

            const isExpanded = burgerButton.getAttribute('aria-expanded') === 'true';
            burgerButton.setAttribute('aria-expanded', !isExpanded);
        });
    }

    // --- Accordion Menu for Mobile ---
    const parentLinks = document.querySelectorAll('.mobile-menu-panel .menu-item-has-children > a'); // ИСПРАВЛЕНО

    parentLinks.forEach(link => {
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
            if (window.scrollY > 300) {
                backToTopButton.classList.add('is-visible');
            } else {
                backToTopButton.classList.remove('is-visible');
            }
        });

        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // --- Hero Slider ---
    const heroSlider = new Swiper('.hero-slider', {
        loop: true,
        effect: 'fade',
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});