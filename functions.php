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

    wp_enqueue_script( 'autobiography-main-js', get_template_directory_uri() . '/assets/js/main.js', array('swiper-js'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'autobiography_scripts' );

function autobiography_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' ); // Добавляем поддержку миниатюр для постов
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
    $labels = array(
        'name'                  => 'Автомобілі',
        'singular_name'         => 'Автомобіль',
        'menu_name'             => 'Каталог Авто',
        'name_admin_bar'        => 'Автомобіль',
        'add_new'               => 'Додати авто',
        'add_new_item'          => 'Додати новий автомобіль',
        'new_item'              => 'Новий автомобіль',
        'edit_item'             => 'Редагувати автомобіль',
        'view_item'             => 'Переглянути автомобіль',
        'all_items'             => 'Всі автомобілі',
        'search_items'          => 'Шукати автомобілі',
        'parent_item_colon'     => 'Батьківський автомобіль:',
        'not_found'             => 'Автомобілі не знайдено.',
        'not_found_in_trash'    => 'Автомобілі не знайдено в кошику.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'cars' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon'          => 'dashicons-car',
    );

    register_post_type( 'car', $args );
}
add_action( 'init', 'autobiography_register_car_post_type' );

// --- Custom Taxonomies for Cars ---
function autobiography_register_car_taxonomies() {
    // Brand
    register_taxonomy('brand', 'car', array(
        'label' => 'Марка',
        'rewrite' => array('slug' => 'brand'),
        'hierarchical' => true,
    ));
    // Body Type
    register_taxonomy('body_type', 'car', array(
        'label' => 'Тип кузова',
        'rewrite' => array('slug' => 'body-type'),
        'hierarchical' => true,
    ));
    // Fuel Type
    register_taxonomy('fuel_type', 'car', array(
        'label' => 'Тип палива',
        'rewrite' => array('slug' => 'fuel-type'),
        'hierarchical' => true,
    ));
    // Transmission
    register_taxonomy('transmission', 'car', array(
        'label' => 'Коробка передач',
        'rewrite' => array('slug' => 'transmission'),
        'hierarchical' => true,
    ));
}
add_action( 'init', 'autobiography_register_car_taxonomies' );


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
                ),
                // Новая вкладка и поля для секции "Як ми працюємо"
                array(
                    'key' => 'field_tab_how_we_work',
                    'label' => 'Секція "Як ми працюємо"',
                    'type' => 'tab',
                    'placement' => 'top',
                ),
                array(
                    'key' => 'field_how_we_work_title',
                    'label' => 'Заголовок секції',
                    'name' => 'how_we_work_title',
                    'type' => 'text',
                    'default_value' => 'Як ми працюємо',
                ),
                array(
                    'key' => 'field_how_we_work_steps',
                    'label' => 'Етапи роботи',
                    'name' => 'how_we_work_steps',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Додати етап',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_step_icon',
                            'label' => 'Іконка етапу (SVG)',
                            'name' => 'step_icon',
                            'type' => 'textarea',
                            'instructions' => 'Вставте SVG-код іконки.',
                        ),
                        array(
                            'key' => 'field_step_title',
                            'label' => 'Назва етапу',
                            'name' => 'step_title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_step_description',
                            'label' => 'Опис етапу',
                            'name' => 'step_description',
                            'type' => 'textarea',
                        ),
                    ),
                ),
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

        acf_add_local_field_group(array(
            'key' => 'group_car_details',
            'title' => 'Інформація про автомобіль',
            'fields' => array(
                // --- Tab: Main Info ---
                array(
                    'key' => 'field_tab_main_info',
                    'label' => 'Основна інформація',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_car_model',
                    'label' => 'Модель',
                    'name' => 'car_model',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_car_year',
                    'label' => 'Рік випуску',
                    'name' => 'car_year',
                    'type' => 'number',
                    'required' => 1,
                    'min' => 1900,
                    'max' => date('Y') + 1,
                ),
                array(
                    'key' => 'field_car_price_usd',
                    'label' => 'Ціна ($)',
                    'name' => 'price_usd',
                    'type' => 'number',
                    'required' => 1,
                    'prepend' => '$',
                ),
                array(
                    'key' => 'field_car_price_uah',
                    'label' => 'Ціна (₴)',
                    'name' => 'price_uah',
                    'type' => 'number',
                    'prepend' => '₴',
                    'instructions' => 'Якщо залишити пустим, ціна буде розрахована автоматично за курсом.',
                ),
                array(
                    'key' => 'field_car_old_price_usd',
                    'label' => 'Стара ціна ($)',
                    'name' => 'old_price_usd',
                    'type' => 'number',
                    'prepend' => '$',
                    'instructions' => 'Буде відображатися закресленою.',
                ),
                array(
                    'key' => 'field_car_status',
                    'label' => 'Статус',
                    'name' => 'car_status',
                    'type' => 'select',
                    'choices' => array(
                        'available' => 'В наявності',
                        'preparing' => 'В підготовці',
                        'sold' => 'Продано',
                    ),
                    'default_value' => 'available',
                    'required' => 1,
                ),
                // --- Tab: Specifications ---
                array(
                    'key' => 'field_tab_specifications',
                    'label' => 'Характеристики',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_car_mileage',
                    'label' => 'Пробіг (тис. км)',
                    'name' => 'mileage',
                    'type' => 'number',
                    'append' => 'тис. км',
                ),
                array(
                    'key' => 'field_car_engine_volume',
                    'label' => 'Об\'єм двигуна (л)',
                    'name' => 'engine_volume',
                    'type' => 'number',
                    'step' => 0.1,
                ),
                array(
                    'key' => 'field_car_engine_power',
                    'label' => 'Потужність двигуна (к.с.)',
                    'name' => 'engine_power_hp',
                    'type' => 'number',
                    'append' => 'к.с.',
                    'instructions' => 'Для ДВЗ та гібридів.',
                ),
                array(
                    'key' => 'field_car_electric_power',
                    'label' => 'Потужність електродвигуна (кВт)',
                    'name' => 'engine_power_kw',
                    'type' => 'number',
                    'append' => 'кВт',
                    'instructions' => 'Для електромобілів та гібридів.',
                ),
                array(
                    'key' => 'field_car_origin',
                    'label' => 'Походження авто',
                    'name' => 'car_origin',
                    'type' => 'select',
                    'choices' => array(
                        'usa' => 'З США',
                        'europe' => 'З Європи',
                        'korea' => 'З Кореї',
                        'official' => 'Офіційне авто',
                    ),
                ),
                array(
                    'key' => 'field_car_vin',
                    'label' => 'VIN-код',
                    'name' => 'vin_code',
                    'type' => 'text',
                ),
                // --- Tab: Photos ---
                array(
                    'key' => 'field_tab_photos',
                    'label' => 'Фотографії',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_car_gallery',
                    'label' => 'Галерея',
                    'name' => 'car_gallery',
                    'type' => 'gallery',
                    'instructions' => 'Перше фото буде головним на картці товару, але ви також можете задати окрему "Мініатюру запису" справа.',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ),
                // --- Tab: Complectation & Buttons ---
                array(
                    'key' => 'field_tab_other',
                    'label' => 'Комплектація та кнопки',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_car_complectation',
                    'label' => 'Комплектація',
                    'name' => 'complectation',
                    'type' => 'wysiwyg',
                    'tabs' => 'visual',
                    'media_upload' => 0,
                    'toolbar' => 'basic',
                ),
                array(
                    'key' => 'field_car_buttons',
                    'label' => 'Кнопки дій',
                    'name' => 'action_buttons',
                    'type' => 'repeater',
                    'button_label' => 'Додати кнопку',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_button_text',
                            'label' => 'Текст кнопки',
                            'name' => 'text',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_button_link',
                            'label' => 'Посилання (або # для модального вікна)',
                            'name' => 'link',
                            'type' => 'text',
                        ),
                    ),
                ),

            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'car',
                    ),
                ),
            ),
            'style' => 'default',
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