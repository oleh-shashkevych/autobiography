<?php
/**
 * Autobiography functions and definitions
*/

// --- 1. ENQUEUE SCRIPTS AND STYLES ---
function autobiography_scripts() {
    // CSS
    wp_enqueue_style( 'autobiography-style', get_stylesheet_uri(), array(), '1.0.5' );
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0' );
    wp_enqueue_style( 'baguettebox-css', 'https://cdn.jsdelivr.net/npm/baguettebox.js@1.11.1/dist/baguetteBox.min.css', array(), '1.11.1' );
    // noUiSlider for price range filter
    wp_enqueue_style( 'nouislider-css', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css', array(), '15.7.1' );
    wp_enqueue_style( 'choices-css', 'https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css', array(), '10.2.0' );

    // JS
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0', true );
    wp_enqueue_script( 'baguettebox-js', 'https://cdn.jsdelivr.net/npm/baguettebox.js@1.11.1/dist/baguetteBox.min.js', array(), '1.11.1', true );
    // noUiSlider JS
    wp_enqueue_script( 'nouislider-js', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js', array(), '15.7.1', true );
    wp_enqueue_script( 'inputmask-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js', array('jquery'), '5.0.8', true );
    wp_enqueue_script( 'choices-js', 'https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js', array(), '10.2.0', true );
    
    // Main JS file
    wp_enqueue_script( 'autobiography-main-js', get_template_directory_uri() . '/assets/js/main.js', array('swiper-js', 'baguettebox-js', 'nouislider-js', 'choices-js'), '1.0.6', true );

    // Localize script for AJAX
    wp_localize_script( 'autobiography-main-js', 'autobiography_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ));
}
add_action( 'wp_enqueue_scripts', 'autobiography_scripts' );


// --- 2. THEME SETUP ---
function autobiography_setup() {
    load_theme_textdomain( 'autobiography', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'autobiography_setup' );


// --- 3. REGISTER MENUS ---
function autobiography_menus() {
    register_nav_menus( array(
        'header_menu'          => 'Головне меню в шапці',
        'footer_services_menu' => 'Меню послуг в футері',
        'footer_sitemap_menu'  => 'Карта сайту в футері'
    ) );
}
add_action( 'init', 'autobiography_menus' );


// --- 4. CPT & TAXONOMIES ---
function autobiography_register_car_post_type() {
    $labels = array('name' => 'Автомобілі', 'singular_name' => 'Автомобіль', 'menu_name' => 'Каталог Авто', 'add_new' => 'Додати авто', 'all_items' => 'Всі автомобілі');
    $args = array('labels' => $labels, 'public' => true, 'has_archive' => true, 'rewrite' => array( 'slug' => 'cars' ), 'supports' => array( 'title', 'editor', 'thumbnail' ), 'menu_icon' => 'dashicons-car');
    register_post_type( 'car', $args );
}
add_action( 'init', 'autobiography_register_car_post_type' );

function autobiography_register_car_taxonomies() {
    register_taxonomy('brand', 'car', array('label' => 'Марка', 'rewrite' => array('slug' => 'brand'), 'hierarchical' => true));
    register_taxonomy('body_type', 'car', array('label' => 'Тип кузова', 'rewrite' => array('slug' => 'body-type'), 'hierarchical' => true));
    register_taxonomy('fuel_type', 'car', array('label' => 'Тип палива', 'rewrite' => array('slug' => 'fuel-type'), 'hierarchical' => true));
    register_taxonomy('transmission', 'car', array('label' => 'Коробка передач', 'rewrite' => array('slug' => 'transmission'), 'hierarchical' => true));
    register_taxonomy('drivetrain', 'car', array('label' => 'Привід', 'rewrite' => array('slug' => 'drivetrain'), 'hierarchical' => true));
}
add_action( 'init', 'autobiography_register_car_taxonomies' );


// --- 5. ACF CONFIGURATION ---
if ( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array('page_title' => 'Загальні налаштування теми', 'menu_title' => 'Налаштування теми', 'menu_slug' => 'theme-general-settings'));
}

function autobiography_acf_add_local_field_groups() {
    if( !function_exists('acf_add_local_field_group') ) return;
    
    // Group: Theme Settings
    acf_add_local_field_group(array(
        'key' => 'group_header_settings', 'title' => 'Налаштування теми',
        'fields' => array(
            array('key' => 'field_tab_general_settings', 'label' => 'Загальні', 'type' => 'tab'),
            array('key' => 'field_uah_to_usd_rate', 'label' => 'Курс UAH до USD', 'name' => 'uah_to_usd_rate', 'type' => 'number', 'instructions' => 'Вкажіть поточний курс гривні до долара для конвертації цін. Використовуйте крапку як роздільник.', 'prepend' => '1 USD =', 'append' => 'UAH'),
            array('key' => 'field_tab_header_settings', 'label' => 'Хедер', 'type' => 'tab'),
            array(
                'key' => 'field_light_theme_logo',
                'label' => 'Логотип для світлої теми',
                'name' => 'light_theme_logo',
                'type' => 'image',
                'instructions' => 'Завантажте логотип, який буде відображатись на білому фоні. Якщо поле пусте, буде використовуватись стандартний логотип.',
                'return_format' => 'url', // Будем получать сразу ссылку на изображение
            ),
            array('key' => 'field_phone_number', 'label' => 'Номер телефону', 'name' => 'phone_number', 'type' => 'text', 'instructions' => 'Основний номер, відображається в хедері та футері.'),
            array('key' => 'field_address', 'label' => 'Адреса', 'name' => 'address', 'type' => 'text'),
            array('key' => 'field_google_maps_link', 'label' => 'Посилання на Google Maps', 'name' => 'google_maps_link', 'type' => 'url'),
            array('key' => 'field_email', 'label' => 'Email', 'name' => 'email', 'type' => 'email', 'instructions' => 'Основний email, відображається в хедері та футері.'),
            array('key' => 'field_header_button_text', 'label' => 'Текст кнопки в хедері', 'name' => 'header_button_text', 'type' => 'text', 'default_value' => 'Потрібна консультація'),
            array('key' => 'field_theme_switcher_text', 'label' => 'Текст біля перемикача теми', 'name' => 'theme_switcher_text', 'type' => 'text', 'default_value' => 'ТЕМА'),
            array('key' => 'field_tab_contact_section', 'label' => 'Секція з формою', 'type' => 'tab'),
            array('key' => 'field_contact_section_title', 'label' => 'Заголовок', 'name' => 'contact_section_title', 'type' => 'text'),
            array('key' => 'field_contact_section_subtitle', 'label' => 'Підзаголовок', 'name' => 'contact_section_subtitle', 'type' => 'text'),
            array('key' => 'field_contact_section_image', 'label' => 'Зображення', 'name' => 'contact_section_image', 'type' => 'image', 'return_format' => 'url'),
            array('key' => 'field_contact_section_form_shortcode', 'label' => 'Шорткод форми', 'name' => 'contact_section_form_shortcode', 'type' => 'text'),
            array('key' => 'field_tab_footer_settings', 'label' => 'Футер', 'type' => 'tab'),
            array('key' => 'field_footer_about_text', 'label' => 'Текст "Про нас" у футері', 'name' => 'footer_about_text', 'type' => 'textarea'),
            array('key' => 'field_footer_services_title', 'label' => 'Заголовок колонки "Наші Послуги"', 'name' => 'footer_services_title', 'type' => 'text'),
            array('key' => 'field_footer_sitemap_title', 'label' => 'Заголовок колонки "Карта Сайту"', 'name' => 'footer_sitemap_title', 'type' => 'text'),
            array('key' => 'field_footer_contacts_title', 'label' => 'Заголовок колонки "Контакти"', 'name' => 'footer_contacts_title', 'type' => 'text'),
            array('key' => 'field_footer_address_label', 'label' => 'Мітка "Адреса"', 'name' => 'footer_address_label', 'type' => 'text'),
            array('key' => 'field_footer_phone_label', 'label' => 'Мітка "Телефон"', 'name' => 'footer_phone_label', 'type' => 'text'),
            array('key' => 'field_footer_email_label', 'label' => 'Мітка "E-mail"', 'name' => 'footer_email_label', 'type' => 'text'),
            array('key' => 'field_footer_copyright_text', 'label' => 'Текст копірайту', 'name' => 'footer_copyright_text', 'type' => 'text'),
            array(
                'key' => 'field_tab_socials',
                'label' => 'Соцмережі та Графік',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_working_hours',
                'label' => 'Графік роботи',
                'name' => 'working_hours',
                'type' => 'repeater',
                'button_label' => 'Додати рядок',
                'sub_fields' => array(
                    array('key' => 'field_wh_days', 'label' => 'Дні тижня', 'name' => 'days', 'type' => 'text', 'wrapper' => array('width' => '50')),
                    array('key' => 'field_wh_hours', 'label' => 'Години роботи', 'name' => 'hours', 'type' => 'text', 'wrapper' => array('width' => '50')),
                ),
            ),
            array(
                'key' => 'field_social_media',
                'label' => 'Соціальні мережі',
                'name' => 'social_media',
                'type' => 'repeater',
                'instructions' => 'Іконки, що відображаються у блоці "Ми в соцмережах" на сторінці контактів.',
                'button_label' => 'Додати соцмережу',
                'sub_fields' => array(
                    array('key' => 'field_sm_icon', 'label' => 'Іконка (SVG)', 'name' => 'icon', 'type' => 'textarea'),
                    array('key' => 'field_sm_link', 'label' => 'Посилання', 'name' => 'link', 'type' => 'url'),
                ),
            ),
            // START: НОВІ ПОЛЯ
            array(
                'key' => 'field_contact_phones',
                'label' => 'Телефони для сторінки контактів',
                'name' => 'contact_phones',
                'type' => 'repeater',
                'instructions' => 'Ці номери будуть відображені в окремому блоці на сторінці "Контакти".',
                'button_label' => 'Додати телефон',
                'sub_fields' => array(
                    array('key' => 'field_contact_phone_number', 'label' => 'Номер телефону', 'name' => 'phone_number', 'type' => 'text'),
                ),
            ),
            array(
                'key' => 'field_contact_messengers',
                'label' => 'Месенджери для сторінки контактів',
                'name' => 'contact_messengers',
                'type' => 'repeater',
                'instructions' => 'Іконки месенджерів, що відображаються під телефонами на сторінці контактів.',
                'button_label' => 'Додати месенджер',
                'sub_fields' => array(
                    array('key' => 'field_contact_messenger_icon', 'label' => 'Іконка (SVG)', 'name' => 'icon', 'type' => 'textarea'),
                    array('key' => 'field_contact_messenger_link', 'label' => 'Посилання на чат', 'name' => 'link', 'type' => 'url'),
                ),
            ),
            array(
                'key' => 'field_contact_emails',
                'label' => 'E-mail адреси для сторінки контактів',
                'name' => 'contact_emails',
                'type' => 'repeater',
                'instructions' => 'Ці email будуть відображені в окремому блоці на сторінці "Контакти".',
                'button_label' => 'Додати e-mail',
                'sub_fields' => array(
                    array('key' => 'field_contact_email_address', 'label' => 'E-mail адреса', 'name' => 'email', 'type' => 'email'),
                ),
            ),
            // END: НОВІ ПОЛЯ
            array('key' => 'field_tab_catalog_settings', 'label' => 'Сторінка каталогу', 'type' => 'tab'),
            array('key' => 'field_catalog_title', 'label' => 'Заголовок сторінки каталогу', 'name' => 'catalog_title', 'type' => 'text'),
            array('key' => 'field_catalog_seo_text', 'label' => 'SEO-текст під каталогом', 'name' => 'catalog_seo_text', 'type' => 'wysiwyg'),
            array('key' => 'field_sold_cars_title', 'label' => 'Заголовок блоку проданих авто', 'name' => 'sold_cars_title', 'type' => 'text'),
            array('key' => 'field_catalog_hero_image', 'label' => 'Фонове зображення заголовка', 'name' => 'catalog_hero_image', 'type' => 'image', 'instructions' => 'Це зображення буде фоном для заголовка на сторінці каталогу.', 'return_format' => 'url'),
            array('key' => 'field_catalog_hero_overlay', 'label' => 'Увімкнути оверлей', 'name' => 'catalog_hero_overlay', 'type' => 'true_false', 'instructions' => 'Додає темний шар поверх зображення для кращої читабельності тексту.', 'ui' => 1, 'default_value' => 1),
        ),
        'location' => array(array(array('param' => 'options_page', 'operator' => '==', 'value' => 'theme-general-settings'))),
    ));
    
    // ... (РЕШТА ВАШИХ ACF ГРУП БЕЗ ЗМІН)
    // Group: Front Page Settings
    acf_add_local_field_group(array(
        'key' => 'group_front_page_settings', 'title' => 'Налаштування Головної Сторінки',
        'fields' => array(
            array('key' => 'field_hero_slider', 'label' => 'Слайдер в шапці', 'name' => 'hero_slider', 'type' => 'repeater', 'sub_fields' => array(
                array('key' => 'field_slide_background_type', 'label' => 'Тип фону', 'name' => 'background_type', 'type' => 'button_group', 'choices' => array('image' => 'Зображення', 'video' => 'Відео')),
                array('key' => 'field_slide_image', 'label' => 'Фонове зображення', 'name' => 'image', 'type' => 'image', 'return_format' => 'url', 'conditional_logic' => array(array(array('field' => 'field_slide_background_type', 'operator' => '==', 'value' => 'image')))),
                array('key' => 'field_slide_video', 'label' => 'Фонове відео', 'name' => 'video', 'type' => 'file', 'return_format' => 'url', 'conditional_logic' => array(array(array('field' => 'field_slide_background_type', 'operator' => '==', 'value' => 'video')))),
            )),
            array(
                'key' => 'field_hero_form_title',
                'label' => 'Заголовок форми в шапці',
                'name' => 'hero_form_title',
                'type' => 'text',
                'instructions' => 'Цей заголовок буде відображатись над формою зворотнього зв\'язку на головній.',
            ),
            array('key' => 'field_hero_form_shortcode', 'label' => 'Шорткод форми в шапці', 'name' => 'hero_form_shortcode', 'type' => 'text'),
            array(
                'key' => 'field_hero_content_title',
                'label' => 'Головний заголовок Hero',
                'name' => 'hero_content_title',
                'type' => 'text',
                'instructions' => 'Буде відображатись зліва від форми.',
            ),
            array(
                'key' => 'field_hero_content_subtitle',
                'label' => 'Підзаголовок Hero',
                'name' => 'hero_content_subtitle',
                'type' => 'textarea',
                'instructions' => 'Буде відображатись під головним заголовком.',
            ),
            array('key' => 'field_tab_how_we_work', 'label' => 'Секція "Як ми працюємо"', 'type' => 'tab'),
            array('key' => 'field_how_we_work_title', 'label' => 'Заголовок секції', 'name' => 'how_we_work_title', 'type' => 'text'),
            array('key' => 'field_how_we_work_steps', 'label' => 'Етапи роботи', 'name' => 'how_we_work_steps', 'type' => 'repeater', 'sub_fields' => array(
                array('key' => 'field_step_icon', 'label' => 'Іконка етапу (SVG)', 'name' => 'step_icon', 'type' => 'textarea'),
                array('key' => 'field_step_title', 'label' => 'Назва етапу', 'name' => 'step_title', 'type' => 'text'),
                array('key' => 'field_step_description', 'label' => 'Опис етапу', 'name' => 'step_description', 'type' => 'textarea'),
            )),
            array(
                'key' => 'field_how_we_work_button',
                'label' => 'Кнопка під секцією',
                'name' => 'how_we_work_button',
                'type' => 'link',
                'instructions' => 'Додає кнопку по центру під блоком з етапами.',
                'return_format' => 'array', // Важно, чтобы возвращался массив (url, title, target)
            ),
            array('key' => 'field_tab_fp_available_cars', 'label' => 'Секція "Авто в наявності"', 'type' => 'tab'),
            array('key' => 'field_fp_available_cars_title', 'label' => 'Заголовок секції', 'name' => 'fp_available_cars_title', 'type' => 'text'),
            array('key' => 'field_fp_available_cars_button', 'label' => 'Текст кнопки "Показати більше"', 'name' => 'fp_available_cars_button_text', 'type' => 'text'),
            array('key' => 'field_tab_our_values', 'label' => 'Секція "Наші цінності"', 'type' => 'tab'),
            array('key' => 'field_our_values_title', 'label' => 'Заголовок секції', 'name' => 'our_values_title', 'type' => 'text'),
            array('key' => 'field_our_values_subtitle', 'label' => 'Підзаголовок', 'name' => 'our_values_subtitle', 'type' => 'text'),
            array('key' => 'field_our_values_list', 'label' => 'Список цінностей', 'name' => 'our_values_list', 'type' => 'repeater', 'sub_fields' => array(
                array('key' => 'field_value_icon', 'label' => 'Іконка (SVG)', 'name' => 'value_icon', 'type' => 'textarea'),
                array('key' => 'field_value_title', 'label' => 'Назва цінності', 'name' => 'value_title', 'type' => 'text'),
                array('key' => 'field_value_description', 'label' => 'Короткий опис', 'name' => 'value_description', 'type' => 'textarea'),
            )),
            array('key' => 'field_our_values_seo_content', 'label' => 'SEO-текст', 'name' => 'our_values_seo_content', 'type' => 'wysiwyg'),
            array('key' => 'field_tab_our_clients', 'label' => 'Секція "Наші клієнти"', 'type' => 'tab'),
            array('key' => 'field_our_clients_title', 'label' => 'Заголовок секції', 'name' => 'our_clients_title', 'type' => 'text'),
            array('key' => 'field_our_clients_gallery', 'label' => 'Фото клієнтів', 'name' => 'our_clients_gallery', 'type' => 'gallery'),
            array('key' => 'field_tab_our_services', 'label' => 'Секція "Наші Послуги"', 'type' => 'tab'),
            array('key' => 'field_services_section_title', 'label' => 'Заголовок секції послуг', 'name' => 'services_section_title', 'type' => 'text'),
            array('key' => 'field_our_services_list', 'label' => 'Список послуг', 'name' => 'our_services_list', 'type' => 'repeater', 'sub_fields' => array(
                array('key' => 'field_service_title', 'label' => 'Назва послуги', 'name' => 'service_title', 'type' => 'text'),
                array('key' => 'field_service_description', 'label' => 'Опис послуги', 'name' => 'service_description', 'type' => 'wysiwyg'),
                array('key' => 'field_service_link', 'label' => 'Посилання', 'name' => 'service_link', 'type' => 'link'),
            )),
        ),
        'location' => array(array(array('param' => 'page_type', 'operator' => '==', 'value' => 'front_page'))),
    ));

    // Group: Car Details
    acf_add_local_field_group(array('key' => 'group_car_details', 'title' => 'Інформація про автомобіль', 'fields' => array(
        array('key' => 'field_tab_main_info', 'label' => 'Основна інформація', 'type' => 'tab'),
        array('key' => 'field_car_model', 'label' => 'Модель', 'name' => 'car_model', 'type' => 'text', 'required' => 1),
        array('key' => 'field_car_year', 'label' => 'Рік випуску', 'name' => 'car_year', 'type' => 'number', 'required' => 1),
        array('key' => 'field_car_price_usd', 'label' => 'Ціна ($)', 'name' => 'price_usd', 'type' => 'number', 'required' => 1),
        array('key' => 'field_car_old_price_usd', 'label' => 'Стара ціна ($)', 'name' => 'old_price_usd', 'type' => 'number'),
        array('key' => 'field_car_status', 'label' => 'Статус', 'name' => 'car_status', 'type' => 'select', 'choices' => array('available' => 'В наявності', 'preparing' => 'В підготовці', 'reserved' => 'Заброньовано', 'sold' => 'Продано'), 'required' => 1),
        array(
            'key' => 'field_car_category',
            'label' => 'Категорія авто',
            'name' => 'car_category',
            'type' => 'select',
            'instructions' => 'Вкажіть категорію для внутрішнього обліку та відображення на сайті.',
            'choices' => array(
                'our_car' => 'Наше авто',
                'verified_car' => 'Перевірене авто',
            ),
            'allow_null' => 1, // Разрешить пустое значение
            'ui' => 1, // Улучшенный интерфейс
        ),
        array('key' => 'field_tab_specifications', 'label' => 'Характеристики', 'type' => 'tab'),
        array('key' => 'field_car_mileage', 'label' => 'Пробіг (тис. км)', 'name' => 'mileage', 'type' => 'number'),
        array('key' => 'field_car_engine_volume', 'label' => 'Об\'єм двигуна (л)', 'name' => 'engine_volume', 'type' => 'number', 'step' => '0.1', 'instructions' => 'Для бензинових/дизельних/гібридних авто'),
        array('key' => 'field_engine_power_hp', 'label' => 'Потужність двигуна (к.с.)', 'name' => 'engine_power_hp', 'type' => 'number', 'instructions' => 'Для бензинових/дизельних/гібридних авто'),
        array('key' => 'field_engine_power_kw', 'label' => 'Потужність електродвигуна (кВт)', 'name' => 'engine_power_kw', 'type' => 'number', 'instructions' => 'Для електромобілів та гібридів'),
        array('key' => 'field_car_vin', 'label' => 'VIN-код', 'name' => 'vin_code', 'type' => 'text'),
        array('key' => 'field_car_origin', 'label' => 'Походження авто', 'name' => 'car_origin', 'type' => 'select', 'choices' => array('usa' => 'з США', 'europe' => 'з Європи', 'korea' => 'з Кореї', 'official' => 'Офіційне авто')),
        array('key' => 'field_tab_photos', 'label' => 'Фотографії', 'type' => 'tab'),
        array('key' => 'field_car_gallery', 'label' => 'Галерея', 'name' => 'car_gallery', 'type' => 'gallery', 'instructions' => 'Перше фото буде головним.'),
        array('key' => 'field_tab_other', 'label' => 'Комплектація та кнопки', 'type' => 'tab'),
        array('key' => 'field_car_complectation', 'label' => 'Комплектація', 'name' => 'complectation', 'type' => 'wysiwyg'),
        array('key' => 'field_action_buttons', 'label' => 'Кнопки дій', 'name' => 'action_buttons', 'type' => 'repeater', 'button_label' => 'Додати кнопку', 'sub_fields' => array(
            array('key' => 'field_button_text', 'label' => 'Текст кнопки', 'name' => 'button_text', 'type' => 'text'),
            array('key' => 'field_button_link', 'label' => 'Посилання або ID модального вікна', 'name' => 'button_link', 'type' => 'text'),
        )),
    ), 'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'car')))));
    
    // Group: Car Buyback Page
    acf_add_local_field_group(array(
        'key' => 'group_car_buyback_page', 'title' => 'Налаштування сторінки "Викуп Авто"',
        'fields' => array(
            array('key' => 'field_buyback_hero_tab', 'label' => 'Налаштування заголовка', 'type' => 'tab'),
            array('key' => 'field_buyback_hero_image', 'label' => 'Фонове зображення заголовка', 'name' => 'buyback_hero_image', 'type' => 'image', 'return_format' => 'url'),
            array('key' => 'field_buyback_hero_overlay', 'label' => 'Увімкнути оверлей', 'name' => 'buyback_hero_overlay', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_buyback_content_tab', 'label' => 'Контент сторінки', 'type' => 'tab'),
            array('key' => 'field_buyback_seo_content', 'label' => 'SEO-опис послуги', 'name' => 'buyback_seo_content', 'type' => 'wysiwyg'),
            array('key' => 'field_buyback_criteria_tab', 'label' => 'Критерії викупу', 'type' => 'tab'),
            array('key' => 'field_buyback_criteria_title', 'label' => 'Заголовок секції критеріїв', 'name' => 'buyback_criteria_title', 'type' => 'text'),
            array('key' => 'field_buyback_criteria_list', 'label' => 'Список критеріїв', 'name' => 'buyback_criteria_list', 'type' => 'repeater', 'sub_fields' => array(
                array('key' => 'field_criteria_icon', 'label' => 'Іконка (SVG)', 'name' => 'icon', 'type' => 'textarea'),
                array('key' => 'field_criteria_title', 'label' => 'Назва критерію', 'name' => 'title', 'type' => 'text'),
                array('key' => 'field_criteria_description', 'label' => 'Опис критерію', 'name' => 'description', 'type' => 'textarea'),
            )),
            array('key' => 'field_buyback_steps_tab', 'label' => 'Етапи викупу', 'type' => 'tab'),
            array('key' => 'field_buyback_steps_title', 'label' => 'Заголовок секції етапів', 'name' => 'buyback_steps_title', 'type' => 'text'),
            array('key' => 'field_buyback_steps_list', 'label' => 'Список етапів', 'name' => 'buyback_steps_list', 'type' => 'repeater', 'sub_fields' => array(
                array('key' => 'field_step_title_new', 'label' => 'Назва етапу', 'name' => 'title', 'type' => 'text'),
                array('key' => 'field_step_description_new', 'label' => 'Опис етапу', 'name' => 'description', 'type' => 'textarea'),
            )),
        ),
        'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'template-car-buyback.php'))),
    ));

    // Group: Trade-in Page
    acf_add_local_field_group(array(
        'key' => 'group_trade_in_page',
        'title' => 'Налаштування сторінки "Трейд-ін"',
        'fields' => array(
            array(
                'key' => 'field_tradein_hero_tab',
                'label' => 'Налаштування заголовка',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_tradein_hero_image',
                'label' => 'Фонове зображення заголовка',
                'name' => 'tradein_hero_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_tradein_hero_overlay',
                'label' => 'Увімкнути оверлей',
                'name' => 'tradein_hero_overlay',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),
            array(
                'key' => 'field_tradein_content_tab',
                'label' => 'Контент сторінки',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_tradein_main_content',
                'label' => 'Основний опис (процедура, переваги)',
                'name' => 'tradein_main_content',
                'type' => 'wysiwyg',
            ),
            array(
                'key' => 'field_tradein_steps_title',
                'label' => 'Заголовок секції з етапами',
                'name' => 'tradein_steps_title',
                'type' => 'text',
                'default_value' => 'Як відбувається обмін авто?',
            ),
            array(
                'key' => 'field_tradein_steps_list',
                'label' => 'Список етапів / ілюстрацій',
                'name' => 'tradein_steps_list',
                'type' => 'repeater',
                'button_label' => 'Додати етап',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tradein_step_icon',
                        'label' => 'Іконка (SVG)',
                        'name' => 'step_icon',
                        'type' => 'textarea',
                    ),
                    array(
                        'key' => 'field_tradein_step_title',
                        'label' => 'Назва етапу',
                        'name' => 'step_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_tradein_step_description',
                        'label' => 'Опис етапу',
                        'name' => 'step_description',
                        'type' => 'textarea',
                    ),
                ),
            ),
            array(
                'key' => 'field_tradein_gallery_tab',
                'label' => 'Ілюстрації',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_tradein_gallery_title',
                'label' => 'Заголовок секції з ілюстраціями',
                'name' => 'tradein_gallery_title',
                'type' => 'text',
                'default_value' => 'Схема роботи Trade-in',
            ),
            array(
                'key' => 'field_tradein_gallery',
                'label' => 'Галерея зображень',
                'name' => 'tradein_gallery',
                'type' => 'gallery',
                'instructions' => 'Завантажте фотографії або схеми, що ілюструють процес.',
                'return_format' => 'array',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-trade-in.php',
                ),
            ),
        ),
    ));

    // Group: Leasing Page
    acf_add_local_field_group(array(
        'key' => 'group_leasing_page',
        'title' => 'Налаштування сторінки "Лізинг"',
        'fields' => array(
            array(
                'key' => 'field_leasing_hero_tab',
                'label' => 'Налаштування заголовка',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_leasing_hero_image',
                'label' => 'Фонове зображення заголовка',
                'name' => 'leasing_hero_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_leasing_hero_overlay',
                'label' => 'Увімкнути оверлей',
                'name' => 'leasing_hero_overlay',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),
            array(
                'key' => 'field_leasing_content_tab',
                'label' => 'Контент сторінки',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_leasing_main_content',
                'label' => 'Основний опис (послуга, як працює, переваги)',
                'name' => 'leasing_main_content',
                'type' => 'wysiwyg',
            ),
            array(
                'key' => 'field_leasing_benefits_tab',
                'label' => 'Переваги',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_leasing_benefits_title',
                'label' => 'Заголовок секції з перевагами',
                'name' => 'leasing_benefits_title',
                'type' => 'text',
                'default_value' => 'Чому лізинг — це вигідно?',
            ),
            array(
                'key' => 'field_leasing_benefits_list',
                'label' => 'Список переваг',
                'name' => 'leasing_benefits_list',
                'type' => 'repeater',
                'button_label' => 'Додати перевагу',
                'sub_fields' => array(
                    array(
                        'key' => 'field_leasing_benefit_icon',
                        'label' => 'Іконка (SVG)',
                        'name' => 'benefit_icon',
                        'type' => 'textarea',
                    ),
                    array(
                        'key' => 'field_leasing_benefit_title',
                        'label' => 'Назва переваги',
                        'name' => 'benefit_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_leasing_benefit_description',
                        'label' => 'Короткий опис',
                        'name' => 'benefit_description',
                        'type' => 'textarea',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-leasing.php',
                ),
            ),
        ),
    ));

    // Group: About Us Page
    acf_add_local_field_group(array(
        'key' => 'group_about_us_page',
        'title' => 'Налаштування сторінки "Про нас"',
        'fields' => array(
            array(
                'key' => 'field_about_hero_tab',
                'label' => 'Налаштування заголовка',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_about_hero_image',
                'label' => 'Фото команди / власників',
                'name' => 'about_hero_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_about_hero_title',
                'label' => 'Головний заголовок',
                'name' => 'about_hero_title',
                'type' => 'text',
                'default_value' => 'Ваш надійний партнер у світі авто',
            ),
            array(
                'key' => 'field_about_hero_subtitle',
                'label' => 'Підзаголовок',
                'name' => 'about_hero_subtitle',
                'type' => 'textarea',
                'default_value' => 'Ми не просто продаємо автомобілі. Ми будуємо довгострокові стосунки, засновані на довірі, прозорості та любові до нашої справи.',
            ),
            array(
                'key' => 'field_about_content_tab',
                'label' => 'Основний контент',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_about_main_content',
                'label' => 'Текст про історію, цінності, методи роботи',
                'name' => 'about_main_content',
                'type' => 'wysiwyg',
            ),
            array(
                'key' => 'field_about_services_tab',
                'label' => 'Секція "Наші Послуги"',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_about_services_title',
                'label' => 'Заголовок секції послуг',
                'name' => 'about_services_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_about_services_list',
                'label' => 'Список послуг',
                'name' => 'about_services_list',
                'type' => 'repeater',
                'instructions' => 'Цей список буде показаний тільки на сторінці "Про нас".',
                'button_label' => 'Додати послугу',
                'sub_fields' => array(
                    array(
                        'key' => 'field_about_service_title',
                        'label' => 'Назва послуги',
                        'name' => 'service_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_about_service_description',
                        'label' => 'Опис послуги',
                        'name' => 'service_description',
                        'type' => 'wysiwyg',
                    ),
                    array(
                        'key' => 'field_about_service_link',
                        'label' => 'Посилання',
                        'name' => 'service_link',
                        'type' => 'link',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-about.php',
                ),
            ),
        ),
    ));

    // Group: Contacts Page
    acf_add_local_field_group(array(
        'key' => 'group_contacts_page',
        'title' => 'Налаштування сторінки "Контакти"',
        'fields' => array(
            array(
                'key' => 'field_contacts_hero_image',
                'label' => 'Фонове зображення заголовка',
                'name' => 'contacts_hero_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_contacts_hero_overlay',
                'label' => 'Увімкнути оверлей',
                'name' => 'contacts_hero_overlay',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),
            array(
                'key' => 'field_google_map_embed',
                'label' => 'Код для вставки Google Карти',
                'name' => 'google_map_embed',
                'type' => 'textarea',
                'instructions' => 'Перейдіть на Google Maps, знайдіть потрібну адресу, натисніть "Поділитись" -> "Вбудовування карт" та скопіюйте HTML-код сюди.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-contacts.php',
                ),
            ),
        ),
    ));

    // Group: FAQ Page
    acf_add_local_field_group(array(
        'key' => 'group_faq_page',
        'title' => 'Налаштування сторінки "FAQ"',
        'fields' => array(
            array(
                'key' => 'field_faq_hero_tab',
                'label' => 'Заголовок',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_faq_hero_image',
                'label' => 'Фонове зображення заголовка',
                'name' => 'faq_hero_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_faq_hero_overlay',
                'label' => 'Увімкнути оверлей',
                'name' => 'faq_hero_overlay',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 1,
            ),
            array(
                'key' => 'field_faq_list_tab',
                'label' => 'Питання та відповіді',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_faq_list',
                'label' => 'Список "Питання/Відповідь"',
                'name' => 'faq_list',
                'type' => 'repeater',
                'button_label' => 'Додати питання',
                'sub_fields' => array(
                    array(
                        'key' => 'field_faq_question',
                        'label' => 'Питання',
                        'name' => 'question',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_faq_answer',
                        'label' => 'Відповідь',
                        'name' => 'answer',
                        'type' => 'wysiwyg',
                    ),
                ),
            ),
            array(
                'key' => 'field_faq_seo_tab',
                'label' => 'SEO-текст',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_faq_seo_content',
                'label' => 'SEO-текст',
                'name' => 'faq_seo_content',
                'type' => 'wysiwyg',
                'instructions' => 'Цей текст буде відображатись під списком питань.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-faq.php',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'autobiography_acf_add_local_field_groups');


// --- 6. HELPERS & UTILITIES ---
function autobiography_add_chevron_to_menu_items($title, $item, $args, $depth) {
    if ( 'header_menu' === $args->theme_location && in_array('menu-item-has-children', $item->classes) ) {
        $title .= '<svg class="header__menu-chevron" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
    }
    return $title;
}
add_filter('nav_menu_item_title', 'autobiography_add_chevron_to_menu_items', 10, 4);

function get_car_status_info($status_slug) {
    $statuses = array(
        'available' => array('label' => autobiography_translate_string('В наявності', 'Available'), 'class' => 'available'),
        'preparing' => array('label' => autobiography_translate_string('В підготовці', 'Preparing'), 'class' => 'preparing'),
        'reserved'  => array('label' => autobiography_translate_string('Заброньовано', 'Reserved'), 'class' => 'reserved'),
        'sold'      => array('label' => autobiography_translate_string('Продано', 'Sold'), 'class' => 'sold'),
    );
    return isset($statuses[$status_slug]) ? $statuses[$status_slug] : null;
}

function get_car_category_info($category_slug) {
    $categories = array(
        'our_car' => array(
            'label' => autobiography_translate_string('Наше авто', 'Our Car'), 
            'class' => 'our-car'
        ),
        'verified_car' => array(
            'label' => autobiography_translate_string('Перевірене авто', 'Verified Car'), 
            'class' => 'verified-car'
        ),
    );
    return isset($categories[$category_slug]) ? $categories[$category_slug] : null;
}

// --- 🏆 ОБНОВЛЕННАЯ ФУНКЦИЯ: Устанавливает кол-во постов, ИСКЛЮЧАЕТ "ПРОДАННЫЕ" и "ЗАБРОНИРОВАННЫЕ", и ЗАДАЕТ ПРИОРИТЕТНУЮ СОРТИРОВКУ ---
function autobiography_set_cars_per_page( $query ) {
    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'car' ) ) {
        
        // Устанавливаем количество постов на странице
        $query->set( 'posts_per_page', 20 );
        
        // 1. Исключаем проданные и забронированные авто
        $meta_query = $query->get( 'meta_query' );
        if ( ! is_array( $meta_query ) ) {
            $meta_query = [];
        }
        
        $meta_query[] = array(
            'key'     => 'car_status',
            'value'   => array('sold', 'reserved'), // --- ИЗМЕНЕНО ---
            'compare' => 'NOT IN',
        );
        
        $query->set( 'meta_query', $meta_query );

        // 2. Добавляем сложную сортировку через SQL-фильтры
        // Эта проверка нужна, чтобы наша сортировка не применялась при AJAX-фильтрации
        if ( ! wp_doing_ajax() ) {
            add_filter( 'posts_join', 'autobiography_car_archive_join' );
            add_filter( 'posts_orderby', 'autobiography_car_archive_orderby' );
        }
    }
}
add_action( 'pre_get_posts', 'autobiography_set_cars_per_page' );

// Новая функция для присоединения таблиц метаданных
function autobiography_car_archive_join( $join ) {
    global $wpdb;
    $join .= " LEFT JOIN {$wpdb->postmeta} AS mt_category ON ({$wpdb->posts}.ID = mt_category.post_id AND mt_category.meta_key = 'car_category')";
    $join .= " LEFT JOIN {$wpdb->postmeta} AS mt_status ON ({$wpdb->posts}.ID = mt_status.post_id AND mt_status.meta_key = 'car_status')";
    return $join;
}

// Новая функция для кастомной сортировки
function autobiography_car_archive_orderby( $orderby ) {
    global $wpdb;
    $orderby = " CASE
        WHEN mt_category.meta_value = 'our_car' AND mt_status.meta_value = 'available' THEN 1
        WHEN mt_category.meta_value = 'our_car' AND mt_status.meta_value = 'preparing' THEN 2
        WHEN mt_category.meta_value = 'verified_car' THEN 3
        ELSE 4
    END, {$wpdb->posts}.post_date DESC";

    // Убираем фильтры после использования, чтобы они не влияли на другие запросы
    remove_filter( 'posts_join', 'autobiography_car_archive_join' );
    remove_filter( 'posts_orderby', 'autobiography_car_archive_orderby' );

    return $orderby;
}


// --- 7. POLYLANG STRING REGISTRATION ---
function autobiography_register_options_strings() {
    if ( function_exists('pll_register_string') ) {
        // Theme Options
        pll_register_string('theme_option_phone_number', get_field('phone_number', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_address', get_field('address', 'option'), 'Налаштування теми', true);
        pll_register_string('theme_option_google_maps_link', get_field('google_maps_link', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_email', get_field('email', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_contact_title', get_field('contact_section_title', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_contact_subtitle', get_field('contact_section_subtitle', 'option'), 'Налаштування теми', true);
        pll_register_string('theme_option_header_button', get_field('header_button_text', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_theme_switcher', get_field('theme_switcher_text', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_footer_about', get_field('footer_about_text', 'option'), 'Налаштування теми', true);
        pll_register_string('theme_option_footer_services', get_field('footer_services_title', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_footer_sitemap', get_field('footer_sitemap_title', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_footer_contacts', get_field('footer_contacts_title', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_footer_addr_lbl', get_field('footer_address_label', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_footer_phone_lbl', get_field('footer_phone_label', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_footer_email_lbl', get_field('footer_email_label', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_footer_copyright', get_field('footer_copyright_text', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_form_shortcode', get_field('contact_section_form_shortcode', 'option'), 'Налаштування теми', false);
        // Catalog Options
        pll_register_string('theme_option_catalog_title', get_field('catalog_title', 'option'), 'Налаштування теми', false);
        pll_register_string('theme_option_catalog_seo', get_field('catalog_seo_text', 'option'), 'Налаштування теми', true);
        pll_register_string('theme_option_catalog_sold_title', get_field('sold_cars_title', 'option'), 'Налаштування теми', false);
    }
    
    $working_hours = get_field('working_hours', 'option');
    if ( $working_hours ) {
        foreach ( $working_hours as $index => $row ) {
            if ( ! empty( $row['days'] ) ) {
                pll_register_string( 'wh_days_' . $index, $row['days'], 'Графік роботи' );
            }
            if ( ! empty( $row['hours'] ) ) {
                pll_register_string( 'wh_hours_' . $index, $row['hours'], 'Графік роботи' );
            }
        }
    }

    // START: РЕЄСТРАЦІЯ НОВИХ РЯДКІВ
    if ( function_exists('pll_register_string') ) {
        $contact_phones = get_field('contact_phones', 'option');
        if ( $contact_phones ) {
            foreach ( $contact_phones as $index => $row ) {
                if ( ! empty( $row['phone_number'] ) ) {
                    pll_register_string( 'contact_phone_' . $index, $row['phone_number'], 'Контактні телефони' );
                }
            }
        }

        $contact_emails = get_field('contact_emails', 'option');
        if ( $contact_emails ) {
            foreach ( $contact_emails as $index => $row ) {
                if ( ! empty( $row['email'] ) ) {
                    pll_register_string( 'contact_email_' . $index, $row['email'], 'Контактні E-mails' );
                }
            }
        }
    }
    // END: РЕЄСТРАЦІЯ НОВИХ РЯДКІВ
}
add_action('acf/init', 'autobiography_register_options_strings');


// --- 8. AJAX HANDLER FOR CAR FILTERS (ОБНОВЛЕНО) ---
function autobiography_filter_cars_ajax_handler() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $args = array(
        'post_type' => 'car',
        'posts_per_page' => 20, // ИЗМЕНЕНО: с 4 на 20
        'paged' => $paged
    );

    $meta_query = array('relation' => 'AND');
    $tax_query = array('relation' => 'AND');
    
    // Status Filter
    if (isset($_POST['status']) && !empty($_POST['status'])) {
         $meta_query[] = array(
            'key' => 'car_status',
            'value' => explode(',', $_POST['status']),
            'compare' => 'IN',
        );
    } else {
        // If no statuses are selected, show nothing
        $args['post__in'] = array(0);
    }

    // Price Filter
    if (isset($_POST['min_price']) && isset($_POST['max_price'])) {
        $meta_query[] = array(
            'key' => 'price_usd',
            'value' => array($_POST['min_price'], $_POST['max_price']),
            'type' => 'numeric',
            'compare' => 'BETWEEN',
        );
    }
    
    // Year Filter
    $min_year = !empty($_POST['min_year']) ? sanitize_text_field($_POST['min_year']) : null;
    $max_year = !empty($_POST['max_year']) ? sanitize_text_field($_POST['max_year']) : null;

    if ($min_year && $max_year) {
        // Если заданы оба значения
        $meta_query[] = array(
            'key' => 'car_year',
            'value' => array($min_year, $max_year),
            'type' => 'numeric',
            'compare' => 'BETWEEN',
        );
    } elseif ($min_year) {
        // Если задано только "от"
        $meta_query[] = array(
            'key' => 'car_year',
            'value' => $min_year,
            'type' => 'numeric',
            'compare' => '>=',
        );
    } elseif ($max_year) {
        // Если задано только "до"
        $meta_query[] = array(
            'key' => 'car_year',
            'value' => $max_year,
            'type' => 'numeric',
            'compare' => '<=',
        );
    }

    // Mileage Filter
    $min_mileage = !empty($_POST['min_mileage']) ? sanitize_text_field($_POST['min_mileage']) : null;
    $max_mileage = !empty($_POST['max_mileage']) ? sanitize_text_field($_POST['max_mileage']) : null;

    if ($min_mileage && $max_mileage) {
        $meta_query[] = array(
            'key' => 'mileage',
            'value' => array($min_mileage, $max_mileage),
            'type' => 'numeric',
            'compare' => 'BETWEEN',
        );
    } elseif ($min_mileage) {
        $meta_query[] = array(
            'key' => 'mileage',
            'value' => $min_mileage,
            'type' => 'numeric',
            'compare' => '>=',
        );
    } elseif ($max_mileage) {
        $meta_query[] = array(
            'key' => 'mileage',
            'value' => $max_mileage,
            'type' => 'numeric',
            'compare' => '<=',
        );
    }

    // Engine Volume Filter
    $min_engine_volume = !empty($_POST['min_engine_volume']) ? sanitize_text_field($_POST['min_engine_volume']) : null;
    $max_engine_volume = !empty($_POST['max_engine_volume']) ? sanitize_text_field($_POST['max_engine_volume']) : null;

    if ($min_engine_volume && $max_engine_volume) {
        $meta_query[] = array(
            'key' => 'engine_volume',
            'value' => array($min_engine_volume, $max_engine_volume),
            'type' => 'DECIMAL(10,1)',
            'compare' => 'BETWEEN',
        );
    } elseif ($min_engine_volume) {
        $meta_query[] = array(
            'key' => 'engine_volume',
            'value' => $min_engine_volume,
            'type' => 'DECIMAL(10,1)',
            'compare' => '>=',
        );
    } elseif ($max_engine_volume) {
        $meta_query[] = array(
            'key' => 'engine_volume',
            'value' => $max_engine_volume,
            'type' => 'DECIMAL(10,1)',
            'compare' => '<=',
        );
    }

    // Model Filter
    if(isset($_POST['model']) && !empty($_POST['model'])) {
        $meta_query[] = array(
            'key' => 'car_model',
            'value' => sanitize_text_field($_POST['model']),
            'compare' => '=',
        );
    }

    // Taxonomy Filters
    $taxonomies = ['brand', 'body_type', 'fuel_type', 'transmission', 'drivetrain'];
    foreach ($taxonomies as $tax) {
        if (isset($_POST[$tax]) && !empty($_POST[$tax])) {
            $tax_query[] = array(
                'taxonomy' => $tax,
                'field' => 'slug',
                'terms' => sanitize_text_field($_POST[$tax]),
            );
        }
    }
    
    if (count($meta_query) > 1) {
        $args['meta_query'] = $meta_query;
    }
    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    // Sorting
    if (isset($_POST['sort']) && !empty($_POST['sort'])) {
        $sort_val = sanitize_text_field($_POST['sort']);
        switch ($sort_val) {
            case 'price_asc':
                $args['meta_key'] = 'price_usd';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                break;
            case 'price_desc':
                $args['meta_key'] = 'price_usd';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'year_desc':
                $args['meta_key'] = 'car_year';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'year_asc':
                $args['meta_key'] = 'car_year';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                break;
        }
    }

    $cars_query = new WP_Query($args);

    if ($cars_query->have_posts()) {
        while ($cars_query->have_posts()) {
            $cars_query->the_post();
            get_template_part('template-parts/content', 'car-card');
        }
    } else {
        echo '<p class="no-cars-found">' . esc_html__('За вашими критеріями автомобілів не знайдено.', 'autobiography') . '</p>';
    }
    
    // Pagination
    $big = 999999999;
    echo '<div class="pagination-wrapper">' . paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, $paged),
        'total' => $cars_query->max_num_pages,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
    )) . '</div>';

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_filter_cars', 'autobiography_filter_cars_ajax_handler');
add_action('wp_ajax_nopriv_filter_cars', 'autobiography_filter_cars_ajax_handler');

function autobiography_translate_string($uk, $en) {
    if (function_exists('pll_current_language')) {
        $lang = pll_current_language('slug');
        if ($lang === 'uk') {
            return $uk;
        }
    }
    // По умолчанию или для любого другого языка возвращаем английский
    return $en;
}

function autobiography_allow_viber_protocol( $protocols ) {
    $protocols[] = 'viber';
    return $protocols;
}
add_filter( 'kses_allowed_protocols', 'autobiography_allow_viber_protocol' );

// --- 9. BREADCRUMBS FUNCTION (Updated for Styling) ---
function autobiography_breadcrumbs() {
    // Настройки
    $separator_html = '<span class="separator">/</span>';
    $home_title = autobiography_translate_string('Головна', 'Home');

    echo '<nav class="breadcrumbs" aria-label="breadcrumb">';
    echo '<ol itemscope itemtype="https://schema.org/BreadcrumbList">';

    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<a itemprop="item" href="' . get_home_url() . '"><span itemprop="name">' . esc_html($home_title) . '</span></a>';
    echo '<meta itemprop="position" content="1" />';
    echo '</li>';

    $position = 2;

    if (is_post_type_archive()) {
        echo $separator_html;
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . post_type_archive_title('', false) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } 
    elseif (is_singular('car')) {
        $post_type = get_post_type_object(get_post_type());
        if ($post_type) {
            echo $separator_html;
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a itemprop="item" href="' . get_post_type_archive_link(get_post_type()) . '"><span itemprop="name">' . $post_type->labels->name . '</span></a>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</li>';
            $position++;
        }
        echo $separator_html;
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . get_the_title() . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    }
    elseif (is_page()) {
        echo $separator_html;
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . get_the_title() . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}