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
    document.querySelectorAll('.header__contact-link[data-copy-text]').forEach(phoneLink => {
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
    
    // --- Mobile Menu Toggle & Accordion ---
    const burgerButton = document.querySelector('.header__burger-button');
    const mobilePanel = document.querySelector('.mobile-menu-panel');
    if (burgerButton && mobilePanel) {
        burgerButton.addEventListener('click', function() {
            this.classList.toggle('is-open');
            mobilePanel.classList.toggle('is-open');
            this.setAttribute('aria-expanded', this.classList.contains('is-open'));
        });
    }

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
        new Swiper('.hero-slider', {
            loop: true,
            effect: 'fade',
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });
    }

    // --- Lightbox Gallery ---
    if (document.querySelector('.our-clients__gallery')) {
        baguetteBox.run('.our-clients__gallery');
    }

    // --- Tabs for Our Services ---
    const servicesSection = document.querySelector('.our-services');
    if (servicesSection) {
        const tabButtons = servicesSection.querySelectorAll('.our-services__tab-item');
        const tabPanels = servicesSection.querySelectorAll('.our-services__panel');
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                tabButtons.forEach(btn => btn.classList.remove('is-active'));
                tabPanels.forEach(panel => panel.classList.remove('is-active'));
                this.classList.add('is-active');
                document.getElementById(this.dataset.tab).classList.add('is-active');
            });
        });
    }
    
    // --- Parallax for Page Hero ---
    const heroWithImage = document.querySelector('.page-hero[style*="background-image"]');
    if (heroWithImage) {
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            heroWithImage.style.backgroundPosition = `center calc(50% + ${scrollTop * 0.3}px)`;
        });
    }

    // --- CAR CATALOG LOGIC ---
    const carFiltersForm = document.getElementById('car-filters-form');
    if (carFiltersForm) {
        const listingsContainer = document.getElementById('car-listings-container');
        const paginationContainer = document.querySelector('.catalog-pagination');
        const viewSwitcherBtns = document.querySelectorAll('.view-btn');
        let currentPage = 1;

        // --- AJAX Function ---
        const fetchCars = () => {
            const formData = new FormData(carFiltersForm);
            formData.append('action', 'filter_cars');
            formData.append('page', currentPage);

            // Special handling for checkboxes
            const statusCheckboxes = carFiltersForm.querySelectorAll('input[name="status"]:checked');
            const statusValues = Array.from(statusCheckboxes).map(cb => cb.value);
            formData.set('status', statusValues.join(','));
            
            listingsContainer.classList.add('loading');

            fetch(autobiography_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                
                const newContent = tempDiv.querySelectorAll('.car-card');
                const newPagination = tempDiv.querySelector('.page-numbers');
                const noResults = tempDiv.querySelector('.no-cars-found');
                
                listingsContainer.innerHTML = '';
                if(newContent.length) {
                    newContent.forEach(item => listingsContainer.appendChild(item));
                } else if (noResults) {
                     listingsContainer.appendChild(noResults);
                }

                paginationContainer.innerHTML = newPagination ? newPagination.outerHTML : '';
                listingsContainer.classList.remove('loading');
            })
            .catch(error => {
                console.error('Error:', error);
                listingsContainer.classList.remove('loading');
            });
        };

        // --- Event Listeners ---
        carFiltersForm.addEventListener('change', () => {
            currentPage = 1;
            fetchCars();
        });
        carFiltersForm.addEventListener('reset', (e) => {
            setTimeout(() => { // Allow form to reset fully
                priceSlider.noUiSlider.set([priceSlider.dataset.min, priceSlider.dataset.max]);
                yearSlider.noUiSlider.set([yearSlider.dataset.min, yearSlider.dataset.max]);
                 carFiltersForm.querySelectorAll('input[name="status"]').forEach(cb => cb.checked = true);
                fetchCars();
            }, 50);
        });

        document.querySelector('.catalog-pagination').addEventListener('click', (e) => {
            if (e.target.matches('a.page-numbers')) {
                e.preventDefault();
                const url = new URL(e.target.href);
                currentPage = url.searchParams.get('paged') || 1;
                fetchCars();
                document.querySelector('.catalog-main').scrollIntoView({ behavior: 'smooth' });
            }
        });

        // --- View Switcher ---
        viewSwitcherBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                viewSwitcherBtns.forEach(b => b.classList.remove('is-active'));
                btn.classList.add('is-active');
                const view = btn.dataset.view;
                listingsContainer.className = `car-listings-grid view-${view}`;
            });
        });

        // --- Range Sliders ---
        const priceSlider = document.getElementById('price-slider');
        const yearSlider = document.getElementById('year-slider');
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');
        const minYearInput = document.getElementById('min_year');
        const maxYearInput = document.getElementById('max_year');

        const createSlider = (sliderEl, minInput, maxInput) => {
             const minVal = parseInt(minInput.min);
             const maxVal = parseInt(maxInput.max);
             sliderEl.dataset.min = minVal;
             sliderEl.dataset.max = maxVal;

            noUiSlider.create(sliderEl, {
                start: [minVal, maxVal],
                connect: true,
                step: sliderEl.id === 'price-slider' ? 100 : 1,
                range: { 'min': minVal, 'max': maxVal },
                format: {
                    to: value => Math.round(value),
                    from: value => Number(value)
                }
            });

            sliderEl.noUiSlider.on('update', (values) => {
                minInput.value = values[0];
                maxInput.value = values[1];
            });
            
             sliderEl.noUiSlider.on('change', () => fetchCars()); // Trigger AJAX on slider change

            minInput.addEventListener('change', () => sliderEl.noUiSlider.set([minInput.value, null]));
            maxInput.addEventListener('change', () => sliderEl.noUiSlider.set([null, maxInput.value]));
        };

        if (priceSlider) createSlider(priceSlider, minPriceInput, maxPriceInput);
        if (yearSlider) createSlider(yearSlider, minYearInput, maxYearInput);

        const sortBySelect = document.getElementById('sort-by');
        if (sortBySelect) {
            sortBySelect.addEventListener('change', () => {
                currentPage = 1; // Сбрасываем на первую страницу при новой сортировке
                fetchCars();     // Вызываем уже существующую функцию для AJAX-запроса
            });
        }
    }

    // --- SINGLE CAR PAGE GALLERY ---
    if (document.querySelector('.single-car__gallery')) {
        const swiperThumbs = new Swiper(".swiper-thumb-gallery", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                768: {
                    slidesPerView: 5,
                }
            }
        });
        const swiperMain = new Swiper(".swiper-main-gallery", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiperThumbs,
            },
        });
    }

    // --- FAQ Accordion ---
    const faqItems = document.querySelectorAll('.faq-item');
    if (faqItems.length > 0) {
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');

            question.addEventListener('click', () => {
                if (item.classList.contains('is-active')) {
                    item.classList.remove('is-active');
                    answer.style.maxHeight = null;
                } else {
                    // Закрыть все остальные открытые элементы
                    faqItems.forEach(otherItem => {
                        if (otherItem.classList.contains('is-active')) {
                            otherItem.classList.remove('is-active');
                            otherItem.querySelector('.faq-answer').style.maxHeight = null;
                        }
                    });
                    item.classList.add('is-active');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                }
            });
        });
    }

    // --- Phone Number Input Mask (using Inputmask library) ---
    jQuery(document).ready(function($) {
        if ($('.custom-phone').length > 0) {
            $('.custom-phone').inputmask({
                "mask": "+380 (99) 999-99-99",
                "clearIncomplete": true
            });
        }
    });
});