<?php
/**
 * Autobiography functions and definitions
*/

function autobiography_scripts() {
    wp_enqueue_style( 'autobiography-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Добавьте эту строку
    wp_enqueue_script( 'autobiography-main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
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

function autobiography_add_chevron_to_menu_items($title, $item, $args, $depth) {
    if ( 'header_menu' === $args->theme_location && in_array('menu-item-has-children', $item->classes) ) {
        $svg_icon = '<svg class="header__menu-chevron" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 9L14 14.1599C13.7429 14.4323 13.4329 14.6493 13.089 14.7976C12.7451 14.9459 12.3745 15.0225 12 15.0225C11.6255 15.0225 11.2549 14.9459 10.9109 14.7976C10.567 14.6493 10.2571 14.4323 10 14.1599L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
        $title .= $svg_icon;
    }
    return $title;
}
add_filter('nav_menu_item_title', 'autobiography_add_chevron_to_menu_items', 10, 4);