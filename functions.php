<?php
/**
 * Autobiography functions and definitions
*/

function autobiography_scripts() {
    // Подключаем основной файл стилей style.css
    wp_enqueue_style( 'autobiography-style', get_stylesheet_uri(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'autobiography_scripts' );

function autobiography_setup() {
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'autobiography_setup' );

function autobiography_menus() {
    register_nav_menus( array(
        'header_menu' => 'Головне меню в шапці'
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