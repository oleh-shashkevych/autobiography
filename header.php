<?php
// Отримуємо ВСІ значення з ACF
$phone_number = pll__(get_field('phone_number', 'option'));
$address = pll__(get_field('address', 'option'));
$google_maps_link = pll__(get_field('google_maps_link', 'option'));
$telegram_link = get_field('telegram_link', 'option');
$viber_link = get_field('viber_link', 'option');
$phone_tel = preg_replace('/[^0-9\+]/', '', $phone_number);

// Наші нові змінні для перекладу
$header_button_text = pll__(get_field('header_button_text', 'option'));
$theme_switcher_text = pll__(get_field('theme_switcher_text', 'option'));
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'dark-theme' ); ?>>
<?php wp_body_open(); ?>

<header class="header">
    <div class="header__container">
        <div class="header__top-row">
            <div class="header__section header__section--left">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo" rel="home">
                    <?php
                    if ( has_custom_logo() ) {
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                        echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
                    } else {
                        echo esc_html( get_bloginfo( 'name' ) );
                    }
                    ?>
                </a>
                <div class="header__lang-switcher">
                    <ul>
                        <?php pll_the_languages( array( 'hide_current' => 1, 'show_names' => 1, 'display_names_as' => 'slug' ) ); ?>
                    </ul>
                </div>
            </div>

            <div class="header__section header__section--right">
                <div class="header__contacts">
                    <?php if ($phone_number) : ?>
                        <a href="tel:<?php echo esc_attr($phone_tel); ?>" class="header__contact-link" data-copy-text="<?php echo esc_attr($phone_tel); ?>">
                            <span class="header__contact-icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5"><path d="M19 2H5C3.89543 2 3 2.89543 3 4V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V4C21 2.89543 20.1046 2 19 2Z"></path><path d="M15 6H9"></path></svg>
                            </span>
                            <span class="header__contact-text"><?php echo esc_html($phone_number); ?></span>
                        </a>
                    <?php endif; ?>
                    <?php if ($address && $google_maps_link) : ?>
                        <a href="<?php echo esc_url($google_maps_link); ?>" target="_blank" rel="noopener noreferrer" class="header__contact-link">
                            <span class="header__contact-icon">
                               <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5"><path d="M3 11.3201C3 8.93312 3.94822 6.64394 5.63605 4.95612C7.32387 3.26829 9.61305 2.32007 12 2.32007C14.3869 2.32007 16.6762 3.26829 18.364 4.95612C20.0518 6.64394 21 8.93312 21 11.3201"></path><path d="M3 11.3201C3 17.4201 9.76 22.3201 12 22.3201C14.24 22.3201 21 17.4201 21 11.3201"></path><path d="M12 15.3201C14.2091 15.3201 16 13.5292 16 11.3201C16 9.11093 14.2091 7.32007 12 7.32007C9.79086 7.32007 8 9.11093 8 11.3201C8 13.5292 9.79086 15.3201 12 15.3201Z"></path></svg>
                            </span>
                            <span class="header__contact-text"><?php echo esc_html($address); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="header__messengers">
                </div>
                <div class="header__actions">
                    <button class="header__button button button--primary"><?php echo esc_html($header_button_text); ?></button>
                </div>
            </div>
            <button class="header__burger-button" aria-label="<?php esc_attr_e('Open menu', 'autobiography'); ?>" aria-expanded="false">
                <span class="header__burger-line"></span>
                <span class="header__burger-line"></span>
                <span class="header__burger-line"></span>
            </button>
        </div>

        <div class="header__bottom-row">
            <nav class="header__nav">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'header_menu',
                    'container'      => false,
                    'menu_class'     => 'header__menu-list',
                ) );
                ?>
            </nav>
            <div class="theme-switcher">
                <input type="checkbox" id="theme-switcher-toggle" class="theme-switcher__input">
                <label for="theme-switcher-toggle" class="theme-switcher__label"></label>
                <span class="theme-switcher__text"><?php echo esc_html($theme_switcher_text); ?></span>
            </div>
        </div>
    </div>

    <div class="mobile-menu-panel">
        <div class="mobile-menu__nav-container">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'header_menu',
                'container'      => false,
                'menu_class'     => 'header__menu-list',
            ) );
            ?>
        </div>
        <div class="mobile-menu__footer">
            <div class="header__actions">
                <button class="header__button button button--primary"><?php echo esc_html($header_button_text); ?></button>
            </div>
            <div class="header__contacts">
                <?php if ($phone_number) : ?>
                    <a href="tel:<?php echo esc_attr($phone_tel); ?>" class="header__contact-link" data-copy-text="<?php echo esc_attr($phone_tel); ?>">
                        <span class="header__contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5"><path d="M19 2H5C3.89543 2 3 2.89543 3 4V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V4C21 2.89543 20.1046 2 19 2Z" stroke-width="1.5"></path><path d="M15 6H9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </span>
                        <span class="header__contact-text"><?php echo esc_html($phone_number); ?></span>
                    </a>
                <?php endif; ?>
                <?php if ($address && $google_maps_link) : ?>
                    <a href="<?php echo esc_url($google_maps_link); ?>" target="_blank" rel="noopener noreferrer" class="header__contact-link">
                        <span class="header__contact-icon">
                            <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5"><path d="M3 11.3201C3 8.93312 3.94822 6.64394 5.63605 4.95612C7.32387 3.26829 9.61305 2.32007 12 2.32007C14.3869 2.32007 16.6762 3.26829 18.364 4.95612C20.0518 6.64394 21 8.93312 21 11.3201"></path><path d="M3 11.3201C3 17.4201 9.76 22.3201 12 22.3201C14.24 22.3201 21 17.4201 21 11.3201"></path><path d="M12 15.3201C14.2091 15.3201 16 13.5292 16 11.3201C16 9.11093 14.2091 7.32007 12 7.32007C9.79086 7.32007 8 9.11093 8 11.3201C8 13.5292 9.79086 15.3201 12 15.3201Z"></path></svg>
                        </span>
                        <span class="header__contact-text"><?php echo esc_html($address); ?></span>
                    </a>
                <?php endif; ?>
            </div>
            <div class="header__lang-switcher">
                <ul>
                    <?php pll_the_languages( array( 'hide_current' => 0, 'show_names' => 1, 'display_names_as' => 'slug' ) ); ?>
                </ul>
            </div>
        </div>
    </div>
</header>