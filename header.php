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
        
        <div class="header__left">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo" rel="home">
                <?php bloginfo( 'name' ); ?>
            </a>
            <div class="header__lang-switcher">
                <ul>
                    <?php pll_the_languages( array( 'hide_current' => 1, 'show_names' => 1 ) ); ?>
                </ul>
            </div>
        </div>

        <nav class="header__nav">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'header_menu',
                'container'      => false,
                'menu_class'     => 'header__menu-list',
            ) );
            ?>
        </nav>
        
        <div class="header__right">
            <div class="header__contacts">
                <a href="#" class="header__phone"></a>
                <a href="#" target="_blank" rel="noopener noreferrer" class="header__address"></a>
            </div>
            <div class="header__messengers">
                <a href="#" class="header__messenger-link" aria-label="Telegram"></a>
                <a href="#" class="header__messenger-link" aria-label="Viber"></a>
            </div>
            <div class="header__actions">
                <button class="header__button button">Потрібна консультація</button>
                <button id="theme-toggle" class="header__theme-toggle" aria-label="Toggle theme"></button>
            </div>
        </div>

    </div>
</header>