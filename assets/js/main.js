document.addEventListener('DOMContentLoaded', function () {
    // --- Theme Toggler ---
    const themeToggleButton = document.getElementById('theme-toggle');
    const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;

    if (currentTheme) {
        document.body.classList.add(currentTheme);
        if(currentTheme === 'light-theme') {
            document.body.classList.remove('dark-theme');
        }
    }

    themeToggleButton.addEventListener('click', function() {
        if (document.body.classList.contains('dark-theme')) {
            document.body.classList.remove('dark-theme');
            document.body.classList.add('light-theme');
            localStorage.setItem('theme', 'light-theme');
        } else {
            document.body.classList.remove('light-theme');
            document.body.classList.add('dark-theme');
            localStorage.setItem('theme', 'dark-theme');
        }
    });

    // --- Phone Number Copy ---
    const phoneLink = document.querySelector('.header__phone');
    if (phoneLink) {
        phoneLink.addEventListener('click', function (e) {
            e.preventDefault();
            const numberToCopy = this.dataset.copyText;
            navigator.clipboard.writeText(numberToCopy).then(() => {
                // Optional: Show a temporary message
                const originalText = this.textContent;
                this.textContent = 'Скопійовано!';
                setTimeout(() => {
                    this.textContent = originalText;
                }, 1500);
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        });
    }

    // --- Mobile Menu Toggle ---
    const burgerButton = document.querySelector('.header__burger-button');
    const navMenu = document.querySelector('.header__nav');

    if (burgerButton && navMenu) {
        burgerButton.addEventListener('click', function() {
            burgerButton.classList.toggle('is-open');
            navMenu.classList.toggle('is-open');

            const isExpanded = burgerButton.getAttribute('aria-expanded') === 'true';
            burgerButton.setAttribute('aria-expanded', !isExpanded);
        });
    }

    // --- Accordion Menu for Mobile ---
    const parentLinks = document.querySelectorAll('.header__nav .menu-item-has-children > a');

    parentLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const burgerButton = document.querySelector('.header__burger-button');
            // Проверяем, виден ли бургер, чтобы понять, мобильная ли версия
            const isMobileView = window.getComputedStyle(burgerButton).display === 'flex';

            // Если это не мобильное меню (т.е. десктоп), ничего не делаем и позволяем ссылке работать как обычно
            if (!isMobileView) {
                return;
            }

            // На мобильной версии всегда отменяем стандартное действие ссылки (переход по URL)
            e.preventDefault();

            const parentLi = this.parentElement;
            const submenu = parentLi.querySelector('.sub-menu');

            // Проверяем, открыт ли уже этот пункт
            if (parentLi.classList.contains('is-open')) {
                // Если да, то закрываем его
                parentLi.classList.remove('is-open');
                submenu.style.maxHeight = null;
            } else {
                // Если нет, то сначала закрываем все другие открытые пункты
                parentLi.closest('.header__menu-list').querySelectorAll('.menu-item-has-children.is-open').forEach(openItem => {
                    openItem.classList.remove('is-open');
                    openItem.querySelector('.sub-menu').style.maxHeight = null;
                });

                // А затем открываем текущий
                parentLi.classList.add('is-open');
                submenu.style.maxHeight = submenu.scrollHeight + "px";
            }
        });
    });
});