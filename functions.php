<?php
/**
 * Autobiography functions and definitions
*/

function autobiography_scripts() {
    wp_enqueue_style( 'autobiography-style', get_stylesheet_uri(), array(), '1.0.3' );

    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0' );
    wp_enqueue_style( 'baguettebox-css', 'https://cdn.jsdelivr.net/npm/baguettebox.js@1.11.1/dist/baguetteBox.min.css', array(), '1.11.1' );

    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0', true );
    wp_enqueue_script( 'baguettebox-js', 'https://cdn.jsdelivr.net/npm/baguettebox.js@1.11.1/dist/baguetteBox.min.js', array(), '1.11.1', true );
    wp_enqueue_script( 'autobiography-main-js', get_template_directory_uri() . '/assets/js/main.js', array('swiper-js', 'baguettebox-js'), '1.0.3', true );
}
add_action( 'wp_enqueue_scripts', 'autobiography_scripts' );

function autobiography_setup() {
    // Цей рядок завантажує текстовий домен, що необхідно для перекладу теми.
    load_theme_textdomain( 'autobiography', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'autobiography_setup' );

function autobiography_menus() {
    register_nav_menus( array(
        'header_menu'          => 'Головне меню в шапці',
        'footer_services_menu' => 'Меню послуг в футері',
        'footer_sitemap_menu'  => 'Карта сайту в футері'
    ) );
}
add_action( 'init', 'autobiography_menus' );

// --- Custom Post Type for Cars ---
function autobiography_register_car_post_type() {
    $labels = array('name' => 'Автомобілі', 'singular_name' => 'Автомобіль', 'menu_name' => 'Каталог Авто', 'add_new' => 'Додати авто', 'all_items' => 'Всі автомобілі');
    $args = array('labels' => $labels, 'public' => true, 'has_archive' => true, 'rewrite' => array( 'slug' => 'cars' ), 'supports' => array( 'title', 'editor', 'thumbnail' ), 'menu_icon' => 'dashicons-car');
    register_post_type( 'car', $args );
}
add_action( 'init', 'autobiography_register_car_post_type' );

// --- Custom Taxonomies for Cars ---
function autobiography_register_car_taxonomies() {
    register_taxonomy('brand', 'car', array('label' => 'Марка', 'rewrite' => array('slug' => 'brand'), 'hierarchical' => true));
    register_taxonomy('body_type', 'car', array('label' => 'Тип кузова', 'rewrite' => array('slug' => 'body-type'), 'hierarchical' => true));
    register_taxonomy('fuel_type', 'car', array('label' => 'Тип палива', 'rewrite' => array('slug' => 'fuel-type'), 'hierarchical' => true));
    register_taxonomy('transmission', 'car', array('label' => 'Коробка передач', 'rewrite' => array('slug' => 'transmission'), 'hierarchical' => true));
}
add_action( 'init', 'autobiography_register_car_taxonomies' );

if ( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array('page_title' => 'Загальні налаштування теми', 'menu_title' => 'Налаштування теми', 'menu_slug' => 'theme-general-settings'));
}

function autobiography_acf_add_local_field_groups() {
    if( function_exists('acf_add_local_field_group') ) {
        acf_add_local_field_group(array(
            'key' => 'group_header_settings', 'title' => 'Налаштування хедера',
            'fields' => array(
                array('key' => 'field_phone_number', 'label' => 'Номер телефону', 'name' => 'phone_number', 'type' => 'text'),
                array('key' => 'field_address', 'label' => 'Адреса', 'name' => 'address', 'type' => 'text'),
                array('key' => 'field_google_maps_link', 'label' => 'Посилання на Google Maps', 'name' => 'google_maps_link', 'type' => 'url'),
                array('key' => 'field_email', 'label' => 'Email', 'name' => 'email', 'type' => 'email'),
                array('key' => 'field_header_button_text', 'label' => 'Текст кнопки в хедері', 'name' => 'header_button_text', 'type' => 'text', 'default_value' => 'Потрібна консультація'),
                array('key' => 'field_theme_switcher_text', 'label' => 'Текст біля перемикача теми', 'name' => 'theme_switcher_text', 'type' => 'text', 'default_value' => 'ТЕМА'),
                array('key' => 'field_tab_contact_section', 'label' => 'Секція з формою', 'type' => 'tab'),
                array('key' => 'field_contact_section_title', 'label' => 'Заголовок', 'name' => 'contact_section_title', 'type' => 'text'),
                array('key' => 'field_contact_section_subtitle', 'label' => 'Підзаголовок', 'name' => 'contact_section_subtitle', 'type' => 'text'),
                array('key' => 'field_contact_section_image', 'label' => 'Зображення', 'name' => 'contact_section_image', 'type' => 'image', 'return_format' => 'url'),
                array('key' => 'field_contact_section_form_shortcode', 'label' => 'Шорткод форми', 'name' => 'contact_section_form_shortcode', 'type' => 'text'),
                array('key' => 'field_tab_footer_settings', 'label' => 'Налаштування футера', 'type' => 'tab'),
                array('key' => 'field_footer_about_text', 'label' => 'Текст "Про нас" у футері', 'name' => 'footer_about_text', 'type' => 'textarea', 'default_value' => 'Клієнти з усієї України довіряють нам, і багато хто з них повертається з проханням - продати авто, швидкий автовикуп. Ми робимо все, щоб це рішення було продуманим та максимально вдалим.'),
                array('key' => 'field_footer_services_title', 'label' => 'Заголовок колонки "Наші Послуги"', 'name' => 'footer_services_title', 'type' => 'text', 'default_value' => 'Наші Послуги'),
                array('key' => 'field_footer_sitemap_title', 'label' => 'Заголовок колонки "Карта Сайту"', 'name' => 'footer_sitemap_title', 'type' => 'text', 'default_value' => 'Карта Сайту'),
                array('key' => 'field_footer_contacts_title', 'label' => 'Заголовок колонки "Контакти"', 'name' => 'footer_contacts_title', 'type' => 'text', 'default_value' => 'Контакти'),
                array('key' => 'field_footer_address_label', 'label' => 'Мітка "Адреса"', 'name' => 'footer_address_label', 'type' => 'text', 'default_value' => 'Адреса'),
                array('key' => 'field_footer_phone_label', 'label' => 'Мітка "Телефон"', 'name' => 'footer_phone_label', 'type' => 'text', 'default_value' => 'Телефон'),
                array('key' => 'field_footer_email_label', 'label' => 'Мітка "E-mail"', 'name' => 'footer_email_label', 'type' => 'text', 'default_value' => 'E-mail'),
                array('key' => 'field_footer_copyright_text', 'label' => 'Текст копірайту', 'name' => 'footer_copyright_text', 'type' => 'text', 'default_value' => 'All rights reserved'),
            ),
            'location' => array(array(array('param' => 'options_page', 'operator' => '==', 'value' => 'theme-general-settings'))),
        ));
        
        acf_add_local_field_group(array(
            'key' => 'group_front_page_settings', 'title' => 'Налаштування Головної Сторінки',
            'fields' => array(
                array('key' => 'field_hero_slider', 'label' => 'Слайдер в шапці', 'name' => 'hero_slider', 'type' => 'repeater', 'sub_fields' => array(
                    array('key' => 'field_slide_background_type', 'label' => 'Тип фону', 'name' => 'background_type', 'type' => 'button_group', 'choices' => array('image' => 'Зображення', 'video' => 'Відео')),
                    array('key' => 'field_slide_image', 'label' => 'Фонове зображення', 'name' => 'image', 'type' => 'image', 'return_format' => 'url', 'conditional_logic' => array(array(array('field' => 'field_slide_background_type', 'operator' => '==', 'value' => 'image')))),
                    array('key' => 'field_slide_video', 'label' => 'Фонове відео', 'name' => 'video', 'type' => 'file', 'return_format' => 'url', 'conditional_logic' => array(array(array('field' => 'field_slide_background_type', 'operator' => '==', 'value' => 'video')))),
                )),
                array('key' => 'field_hero_form_shortcode', 'label' => 'Шорткод форми в шапці', 'name' => 'hero_form_shortcode', 'type' => 'text'),
                array('key' => 'field_tab_how_we_work', 'label' => 'Секція "Як ми працюємо"', 'type' => 'tab'),
                array('key' => 'field_how_we_work_title', 'label' => 'Заголовок секції', 'name' => 'how_we_work_title', 'type' => 'text'),
                array('key' => 'field_how_we_work_steps', 'label' => 'Етапи роботи', 'name' => 'how_we_work_steps', 'type' => 'repeater', 'sub_fields' => array(
                    array('key' => 'field_step_icon', 'label' => 'Іконка етапу (SVG)', 'name' => 'step_icon', 'type' => 'textarea'),
                    array('key' => 'field_step_title', 'label' => 'Назва етапу', 'name' => 'step_title', 'type' => 'text'),
                    array('key' => 'field_step_description', 'label' => 'Опис етапу', 'name' => 'step_description', 'type' => 'textarea'),
                )),
                array('key' => 'field_tab_our_values', 'label' => 'Секція "Наші цінності"', 'type' => 'tab'),
                array('key' => 'field_our_values_title', 'label' => 'Заголовок секції', 'name' => 'our_values_title', 'type' => 'text', 'default_value' => 'Наші цінності'),
                array('key' => 'field_our_values_subtitle', 'label' => 'Підзаголовок', 'name' => 'our_values_subtitle', 'type' => 'text', 'instructions' => 'Короткий текст під головним заголовком.'),
                array('key' => 'field_our_values_list', 'label' => 'Список цінностей', 'name' => 'our_values_list', 'type' => 'repeater', 'sub_fields' => array(
                    array('key' => 'field_value_icon', 'label' => 'Іконка (SVG)', 'name' => 'value_icon', 'type' => 'textarea'),
                    array('key' => 'field_value_title', 'label' => 'Назва цінності', 'name' => 'value_title', 'type' => 'text'),
                    array('key' => 'field_value_description', 'label' => 'Короткий опис', 'name' => 'value_description', 'type' => 'textarea'),
                )),
                array('key' => 'field_our_values_seo_content', 'label' => 'SEO-текст', 'name' => 'our_values_seo_content', 'type' => 'wysiwyg', 'instructions' => 'Додайте сюди основний SEO-оптимізований текст, він буде відображений під блоками цінностей.'),
                array('key' => 'field_tab_our_clients', 'label' => 'Секція "Наші клієнти"', 'type' => 'tab'),
                array('key' => 'field_our_clients_title', 'label' => 'Заголовок секції', 'name' => 'our_clients_title', 'type' => 'text', 'default_value' => 'Наші клієнти'),
                array('key' => 'field_our_clients_gallery', 'label' => 'Фото клієнтів', 'name' => 'our_clients_gallery', 'type' => 'gallery'),
                array('key' => 'field_tab_our_services', 'label' => 'Секція "Наші Послуги"', 'type' => 'tab'),
                array('key' => 'field_services_section_title', 'label' => 'Заголовок секції послуг', 'name' => 'services_section_title', 'type' => 'text', 'default_value' => 'Наші Послуги'),
                array(
                    'key' => 'field_our_services_list',
                    'label' => 'Список послуг',
                    'name' => 'our_services_list',
                    'type' => 'repeater',
                    'button_label' => 'Додати послугу',
                    'sub_fields' => array(
                        array('key' => 'field_service_title', 'label' => 'Назва послуги', 'name' => 'service_title', 'type' => 'text'),
                        array('key' => 'field_service_description', 'label' => 'Опис послуги', 'name' => 'service_description', 'type' => 'wysiwyg'),
                        array('key' => 'field_service_link', 'label' => 'Посилання', 'name' => 'service_link', 'type' => 'link'),
                    ),
                ),
                array('key' => 'field_tab_fp_available_cars', 'label' => 'Секція "Авто в наявності"', 'type' => 'tab'),
                array(
                    'key' => 'field_fp_available_cars_title',
                    'label' => 'Заголовок секції',
                    'name' => 'fp_available_cars_title',
                    'type' => 'text',
                    'default_value' => 'Авто в наявності',
                ),
                array(
                    'key' => 'field_fp_available_cars_button',
                    'label' => 'Текст кнопки "Показати більше"',
                    'name' => 'fp_available_cars_button_text',
                    'type' => 'text',
                    'default_value' => 'Показати більше',
                ),
            ),
            'location' => array(array(array('param' => 'page_type', 'operator' => '==', 'value' => 'front_page'))),
        ));

        acf_add_local_field_group(array('key' => 'group_car_details', 'title' => 'Інформація про автомобіль', 'fields' => array(
             array('key' => 'field_tab_main_info', 'label' => 'Основна інформація', 'type' => 'tab'),
             array('key' => 'field_car_model', 'label' => 'Модель', 'name' => 'car_model', 'type' => 'text', 'required' => 1),
             array('key' => 'field_car_year', 'label' => 'Рік випуску', 'name' => 'car_year', 'type' => 'number', 'required' => 1),
             array('key' => 'field_car_price_usd', 'label' => 'Ціна ($)', 'name' => 'price_usd', 'type' => 'number', 'required' => 1),
             array('key' => 'field_car_old_price_usd', 'label' => 'Стара ціна ($)', 'name' => 'old_price_usd', 'type' => 'number'),
             array('key' => 'field_car_status', 'label' => 'Статус', 'name' => 'car_status', 'type' => 'select', 'choices' => array('available' => 'В наявності', 'sold' => 'Продано'), 'required' => 1),
             array('key' => 'field_tab_specifications', 'label' => 'Характеристики', 'type' => 'tab'),
             array('key' => 'field_car_mileage', 'label' => 'Пробіг (тис. км)', 'name' => 'mileage', 'type' => 'number'),
             array('key' => 'field_car_engine_volume', 'label' => 'Об\'єм двигуна (л)', 'name' => 'engine_volume', 'type' => 'number'),
             array('key' => 'field_car_vin', 'label' => 'VIN-код', 'name' => 'vin_code', 'type' => 'text'),
             array('key' => 'field_tab_photos', 'label' => 'Фотографії', 'type' => 'tab'),
             array('key' => 'field_car_gallery', 'label' => 'Галерея', 'name' => 'car_gallery', 'type' => 'gallery'),
             array('key' => 'field_tab_other', 'label' => 'Комплектація', 'type' => 'tab'),
             array('key' => 'field_car_complectation', 'label' => 'Комплектація', 'name' => 'complectation', 'type' => 'wysiwyg'),
        ), 'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'car')))));
    }
}
add_action('acf/init', 'autobiography_acf_add_local_field_groups');

function autobiography_add_chevron_to_menu_items($title, $item, $args, $depth) {
    if ( 'header_menu' === $args->theme_location && in_array('menu-item-has-children', $item->classes) ) {
        $title .= '<svg class="header__menu-chevron" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
    }
    return $title;
}
add_filter('nav_menu_item_title', 'autobiography_add_chevron_to_menu_items', 10, 4);

/**
 * Register ACF Options Page fields for Polylang String Translation.
 */
function autobiography_register_options_strings() {
    if ( function_exists('pll_register_string') ) {
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
    }
}
add_action('acf/init', 'autobiography_register_options_strings');

acf_add_local_field_group(array(
    'key' => 'group_car_buyback_page',
    'title' => 'Налаштування сторінки "Викуп Авто"',
    'fields' => array(
        array(
            'key' => 'field_buyback_hero_tab',
            'label' => 'Налаштування заголовка',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_buyback_hero_image',
            'label' => 'Фонове зображення заголовка',
            'name' => 'buyback_hero_image',
            'type' => 'image',
            'instructions' => 'Необов\'язково. Якщо вибрано, буде показано як фон для заголовка сторінки.',
            'return_format' => 'url',
        ),
        array(
            'key' => 'field_buyback_hero_overlay',
            'label' => 'Увімкнути оверлей',
            'name' => 'buyback_hero_overlay',
            'type' => 'true_false',
            'instructions' => 'Затемнює фонове зображення для кращої читабельності тексту.',
            'ui' => 1,
            'default_value' => 1,
        ),
        array(
            'key' => 'field_buyback_content_tab',
            'label' => 'Контент сторінки',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_buyback_seo_content',
            'label' => 'SEO-опис послуги',
            'name' => 'buyback_seo_content',
            'type' => 'wysiwyg',
            'instructions' => 'Основний текст, що описує послугу викупу авто.',
        ),
        array(
            'key' => 'field_buyback_criteria_tab',
            'label' => 'Критерії викупу',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_buyback_criteria_title',
            'label' => 'Заголовок секції критеріїв',
            'name' => 'buyback_criteria_title',
            'type' => 'text',
            'default_value' => 'Які автомобілі ми викуповуємо?',
        ),
        array(
            'key' => 'field_buyback_criteria_list',
            'label' => 'Список критеріїв',
            'name' => 'buyback_criteria_list',
            'type' => 'repeater',
            'button_label' => 'Додати критерій',
            'sub_fields' => array(
                array('key' => 'field_criteria_icon', 'label' => 'Іконка (SVG)', 'name' => 'icon', 'type' => 'textarea'),
                array('key' => 'field_criteria_title', 'label' => 'Назва критерію', 'name' => 'title', 'type' => 'text'),
                array('key' => 'field_criteria_description', 'label' => 'Опис критерію', 'name' => 'description', 'type' => 'textarea'),
            ),
        ),
        array(
            'key' => 'field_buyback_steps_tab',
            'label' => 'Етапи викупу',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_buyback_steps_title',
            'label' => 'Заголовок секції етапів',
            'name' => 'buyback_steps_title',
            'type' => 'text',
            'default_value' => 'Етапи процедури викупу',
        ),
        array(
            'key' => 'field_buyback_steps_list',
            'label' => 'Список етапів',
            'name' => 'buyback_steps_list',
            'type' => 'repeater',
            'button_label' => 'Додати етап',
            'sub_fields' => array(
                array('key' => 'field_step_title_new', 'label' => 'Назва етапу', 'name' => 'title', 'type' => 'text'),
                array('key' => 'field_step_description_new', 'label' => 'Опис етапу', 'name' => 'description', 'type' => 'textarea'),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'template-car-buyback.php',
            ),
        ),
    ),
));