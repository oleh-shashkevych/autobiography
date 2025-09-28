<?php
/**
 * Autobiography functions and definitions
*/

function autobiography_scripts() {
    wp_enqueue_style( 'autobiography-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Подключаем стили Swiper.js
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0' );
    
    // Подключаем скрипт Swiper.js
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0', true );

    wp_enqueue_script( 'autobiography-main-js', get_template_directory_uri() . '/assets/js/main.js', array('swiper-js'), '1.0.0', true ); // Добавляем swiper-js в зависимости
}
add_action( 'wp_enqueue_scripts', 'autobiography_scripts' );

function autobiography_setup() {
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'autobiography_setup' );

function autobiography_menus() {
    register_nav_menus( array(
        'header_menu'          => 'Головне меню в шапці',
        'footer_services_menu' => 'Меню послуг в футері', // Добавить
        'footer_sitemap_menu'  => 'Карта сайту в футері'    // Добавить
    ) );
}
add_action( 'init', 'autobiography_menus' );

if ( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Загальні налаштування теми',
        'menu_title'    => 'Налаштування теми',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
    
}

function autobiography_acf_add_local_field_groups() {
    if( function_exists('acf_add_local_field_group') ) {
        acf_add_local_field_group(array(
            'key' => 'group_header_settings',
            'title' => 'Налаштування хедера',
            'fields' => array(
                array(
                    'key' => 'field_phone_number',
                    'label' => 'Номер телефону',
                    'name' => 'phone_number',
                    'type' => 'text',
                    'instructions' => 'Введіть номер телефону у форматі +38 0XX XXX XX XX',
                ),
                array(
                    'key' => 'field_address',
                    'label' => 'Адреса',
                    'name' => 'address',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_google_maps_link',
                    'label' => 'Посилання на Google Maps',
                    'name' => 'google_maps_link',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_telegram_link',
                    'label' => 'Посилання на Telegram',
                    'name' => 'telegram_link',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_viber_link',
                    'label' => 'Посилання на Viber',
                    'name' => 'viber_link',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_email',
                    'label' => 'Email',
                    'name' => 'email',
                    'type' => 'email',
                ),
                array(
                    'key' => 'field_tab_contact_section',
                    'label' => 'Секція з формою',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_contact_section_title',
                    'label' => 'Заголовок',
                    'name' => 'contact_section_title',
                    'type' => 'text',
                    'default_value' => 'Потрібна консультація?',
                ),
                array(
                    'key' => 'field_contact_section_subtitle',
                    'label' => 'Підзаголовок',
                    'name' => 'contact_section_subtitle',
                    'type' => 'text',
                    'default_value' => 'Заповніть контактні дані, і ми вам зателефонуємо',
                ),
                array(
                    'key' => 'field_contact_section_image',
                    'label' => 'Зображення',
                    'name' => 'contact_section_image',
                    'type' => 'image',
                    'return_format' => 'url',
                    'preview_size' => 'medium',
                ),
                array(
                    'key' => 'field_contact_section_form_shortcode',
                    'label' => 'Шорткод форми',
                    'name' => 'contact_section_form_shortcode',
                    'type' => 'text',
                    'instructions' => 'Вставте сюди шорткод форми, створеної в Fluent Forms. Наприклад: [fluentform id="1"]',
                )
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-general-settings',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
        ));
    }
}
add_action('acf/init', 'autobiography_acf_add_local_field_groups');

function autobiography_add_chevron_to_menu_items($title, $item, $args, $depth) {
    if ( 'header_menu' === $args->theme_location && in_array('menu-item-has-children', $item->classes) ) {
        $svg_icon = '<svg class="header__menu-chevron" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 9L14 14.1599C13.7429 14.4323 13.4329 14.6493 13.089 14.7976C12.7451 14.9459 12.3745 15.0225 12 15.0225C11.6255 15.0225 11.2549 14.9459 10.9109 14.7976C10.567 14.6493 10.2571 14.4323 10 14.1599L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
        $title .= $svg_icon;
    }
    return $title;
}
add_filter('nav_menu_item_title', 'autobiography_add_chevron_to_menu_items', 10, 4);

// Группа полей для главной страницы
acf_add_local_field_group(array(
    'key' => 'group_front_page_settings',
    'title' => 'Налаштування Головної Сторінки',
    'fields' => array(
        array(
            'key' => 'field_hero_slider',
            'label' => 'Слайдер в шапці',
            'name' => 'hero_slider',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Додати слайд',
            'sub_fields' => array(
                array(
                    'key' => 'field_slide_background_type',
                    'label' => 'Тип фону',
                    'name' => 'background_type',
                    'type' => 'button_group',
                    'choices' => array(
                        'image' => 'Зображення',
                        'video' => 'Відео',
                    ),
                    'default_value' => 'image',
                ),
                array(
                    'key' => 'field_slide_image',
                    'label' => 'Фонове зображення',
                    'name' => 'image',
                    'type' => 'image',
                    'return_format' => 'url',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_slide_background_type',
                                'operator' => '==',
                                'value' => 'image',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_slide_video',
                    'label' => 'Фонове відео',
                    'name' => 'video',
                    'type' => 'file',
                    'return_format' => 'url',
                    'library' => 'all',
                    'mime_types' => 'mp4',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_slide_background_type',
                                'operator' => '==',
                                'value' => 'video',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_hero_form_shortcode',
            'label' => 'Шорткод форми в шапці',
            'name' => 'hero_form_shortcode',
            'type' => 'text',
            'instructions' => 'Вставте сюди шорткод єдиної форми для блоку в шапці',
        )
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_type',
                'operator' => '==',
                'value' => 'front_page',
            ),
        ),
    ),
));