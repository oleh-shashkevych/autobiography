document.addEventListener('DOMContentLoaded', function () {
    // --- Theme Toggler ---
    const themeSwitches = document.querySelectorAll('.theme-switcher__input'); // Находим ОБА переключателя по классу

    function applyTheme(theme) {
        const isLightTheme = theme === 'light-theme';
        
        document.body.classList.toggle('light-theme', isLightTheme);
        document.body.classList.toggle('dark-theme', !isLightTheme);

        // Синхронизируем состояние всех переключателей
        themeSwitches.forEach(sw => {
            sw.checked = isLightTheme;
        });
    }

    function toggleTheme() {
        const newTheme = document.body.classList.contains('dark-theme') ? 'light-theme' : 'dark-theme';
        localStorage.setItem('theme', newTheme);
        applyTheme(newTheme);
    }

    const savedTheme = localStorage.getItem('theme') || 'dark-theme';
    applyTheme(savedTheme);

    // Применяем обработчик к каждому найденному переключателю
    themeSwitches.forEach(sw => {
        sw.addEventListener('change', toggleTheme);
    });

    // --- Phone Number Copy ---
    document.querySelectorAll('.header__contact-link[data-copy-text]').forEach(phoneLink => {
        phoneLink.addEventListener('click', function (e) {
            if (this.closest('.mobile-menu__footer') && this.href.startsWith('tel:')) return;
            e.preventDefault();
            navigator.clipboard.writeText(this.dataset.copyText).then(() => {
                const originalText = this.querySelector('.header__contact-text').textContent;
                this.querySelector('.header__contact-text').textContent = 'Скопійовано!';
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
        baguetteBox.run('.lightbox-gallery');
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

    // --- ✅ ИСПРАВЛЕННАЯ ЛОГИКА ДЛЯ ФИЛЬТРОВ ---
    const filtersContainer = document.querySelector('.catalog-filters');
    if (filtersContainer) { // Теперь вся логика ВНУТРИ этого if
        // 1. Accordion functionality
        const filterHeaders = filtersContainer.querySelectorAll('.filter-group__header');
        filterHeaders.forEach(header => {
            header.addEventListener('click', () => {
                header.parentElement.classList.toggle('is-collapsed');
            });
        });

        // 2. Initialize custom selects with Choices.js
        const selectElements = document.querySelectorAll('.catalog-filters select, .catalog-sort select'); 
        selectElements.forEach(select => {
            new Choices(select, {
                searchEnabled: false, 
                itemSelectText: '', 
                shouldSort: false, 
            });
        });

        // 3. Mobile Filters Toggle
        const filtersToggleButton = document.querySelector('.filters-toggle-button');
        const closeFiltersButton = document.querySelector('.close-filters-button');
        const filtersPanel = document.querySelector('.catalog-filters');
        const filtersOverlay = document.querySelector('.filters-overlay');

        if (filtersToggleButton && filtersPanel && closeFiltersButton && filtersOverlay) {
            const openFilters = () => {
                filtersPanel.classList.add('is-open');
                document.body.classList.add('filters-open');
            };

            const closeFilters = () => {
                filtersPanel.classList.remove('is-open');
                document.body.classList.remove('filters-open');
            };

            filtersToggleButton.addEventListener('click', openFilters);
            closeFiltersButton.addEventListener('click', closeFilters);
            filtersOverlay.addEventListener('click', closeFilters);
        }
    }

    // --- Universal Fluent Form Popup Handler ---
    const popupWrapper = document.getElementById('fluent-form-popup');
    if (popupWrapper) {
        const formContainer = popupWrapper.querySelector('.popup-form-container');
        const closeButton = popupWrapper.querySelector('.popup-close-button');
        const overlay = popupWrapper.querySelector('.popup-overlay');

        const openPopup = () => {
            popupWrapper.setAttribute('aria-hidden', 'false');
            popupWrapper.classList.add('is-open');
            document.body.classList.add('popup-open');
        };

        const closePopup = () => {
            popupWrapper.setAttribute('aria-hidden', 'true');
            popupWrapper.classList.remove('is-open');
            document.body.classList.remove('popup-open');
            // Очищаем контейнер после закрытия
            setTimeout(() => { formContainer.innerHTML = ''; }, 300);
        };

        // Слушаем клики по всему документу
        document.addEventListener('click', function(e) {
            // Ищем ближайшую ссылку-триггер
            const trigger = e.target.closest('a[href^="#form-"]');
            
            if (trigger) {
                e.preventDefault();
                const formId = trigger.getAttribute('href').replace('#form-', '');

                if (!formId || !/^\d+$/.test(formId)) {
                    console.error('Invalid Form ID.');
                    return;
                }

                // ✅ Зберігаємо назву авто з data-атрибута кнопки
                const carTitle = trigger.dataset.carTitle || 'Не вказано'; // 'Не вказано' як запасний варіант
                
                // Показываем состояние загрузки
                formContainer.innerHTML = '<h4>Завантаження...</h4>';
                openPopup();

                // Готовим и отправляем AJAX запрос
                const formData = new FormData();
                formData.append('action', 'load_fluent_form');
                formData.append('form_id', formId);

                fetch(autobiography_ajax.ajax_url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(html => {
                    // Вставляем полученный HTML в контейнер
                    formContainer.innerHTML = html;

                    // ✨ МАГИЯ ЗДЕСЬ: Находим все скрипты... (цей код залишається)
                    const scripts = formContainer.querySelectorAll('script');
                    scripts.forEach(script => {
                        const newScript = document.createElement('script');
                        newScript.textContent = script.textContent; 
                        document.body.appendChild(newScript).remove();
                    });

                    // ✅ НОВИЙ КОД: Знаходимо приховане поле і встановлюємо його значення
                    const hiddenInput = formContainer.querySelector('input[name="car_identifier"]');
                    if (hiddenInput) {
                        hiddenInput.value = carTitle;
                    } else {
                        console.warn('Hidden field "car_identifier" not found in the loaded form.');
                    }

                    // Також потрібно вручну применити маску... (цей код залишається)
                    jQuery('.popup-form-container .custom-phone').inputmask({
                        "mask": "+380 (99) 999-99-99",
                        "clearIncomplete": true
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    formContainer.innerHTML = '<p>Помилка завантаження форми.</p>';
                });
            }
        });

        // Назначаем события закрытия
        closeButton.addEventListener('click', closePopup);
        overlay.addEventListener('click', closePopup);

        // ✅ START: НОВЫЙ КОД ДЛЯ УПРАВЛЕНИЯ ЗАКРЫТИЕМ ПОПАПА
        // Используем jQuery, так как Fluent Forms работает на нем
        jQuery(document).on('fluentform_submission_success', function(event, data) {
            // data.formId содержит ID отправленной формы
            // data.response.message содержит текст успешного сообщения
            
            // Ждем 3 секунды, чтобы пользователь успел прочитать сообщение,
            // а затем плавно закрываем попап.
            setTimeout(function() {
                closePopup();
            }, 3000); // 3000 миллисекунд = 3 секунды
        });
    }

    // --- FAQ Page Anchor Link Generator ---
    const faqAccordion = document.querySelector('.faq-accordion');
    // Запускаємо скрипт, тільки якщо ми на сторінці FAQ
    if (faqAccordion) {
        const categoryTitles = faqAccordion.querySelectorAll('.faq-category-title');

        // Якщо є хоча б одна категорія
        if (categoryTitles.length > 0) {
            
            // Функція для перетворення кирилиці в URL-дружній рядок (slug)
            function slugify(text) {
                const a = {"Ё":"YO","Й":"I","Ц":"TS","У":"U","К":"K","Е":"E","Н":"N","Г":"G","Ш":"SH","Щ":"SCH","З":"Z","Х":"H","Ъ":"","Ф":"F","Ы":"Y","В":"V","А":"a","П":"P","Р":"R","О":"O","Л":"L","Д":"D","Ж":"ZH","Э":"E","Я":"Ya","Ч":"CH","С":"S","М":"M","И":"I","Т":"T","Ь":"","Б":"B","Ю":"YU","ё":"yo","й":"i","ц":"ts","у":"u","к":"k","е":"e","н":"n","г":"g","ш":"sh","щ":"sch","з":"z","х":"h","ъ":"","ф":"f","ы":"y","в":"v","а":"a","п":"p","р":"r","о":"o","л":"l","д":"d","ж":"zh","э":"e","я":"ya","ч":"ch","с":"s","м":"m","и":"i","т":"t","ь":"","б":"b","ю":"yu", "і":"i", "ї":"yi", "є":"ye"};

                return text.split('').map(function (char) {
                    return a[char] || char;
                }).join("").toLowerCase()
                  .replace(/\s+/g, '-')       // Замінити пробіли на -
                  .replace(/[^\w\-]+/g, '')   // Видалити всі не-словесні символи
                  .replace(/\-\-+/g, '-')     // Замінити кілька - на один -
                  .replace(/^-+/, '')          // Обрізати - з початку
                  .replace(/-+$/, '');         // Обрізати - з кінця
            }

            // Створюємо контейнер для нашого меню
            const anchorContainer = document.createElement('div');
            anchorContainer.className = 'faq-anchors';
            
            const anchorList = document.createElement('div');
            anchorList.className = 'faq-anchors__list';
            
            // Проходимо по кожному знайденому заголовку
            categoryTitles.forEach(title => {
                const titleText = title.textContent;
                const anchorId = slugify(titleText);

                // 1. Присвоюємо ID самому заголовку H2
                title.id = anchorId;

                // 2. Створюємо посилання для меню
                const link = document.createElement('a');
                link.href = `#${anchorId}`;
                link.textContent = titleText;
                
                // 3. Додаємо посилання до списку
                anchorList.appendChild(link);
            });

            // Додаємо список у головний контейнер
            anchorContainer.appendChild(anchorList);

            // Вставляємо наше меню перед акордеоном
            faqAccordion.parentNode.insertBefore(anchorContainer, faqAccordion);
        }
    }
});