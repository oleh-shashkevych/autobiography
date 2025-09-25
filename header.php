<?php
$phone_number     = get_field('phone_number', 'option');
$address          = get_field('address', 'option');
$google_maps_link = get_field('google_maps_link', 'option');
$telegram_link    = get_field('telegram_link', 'option');
$viber_link       = get_field('viber_link', 'option');

// Убираем из номера все, кроме цифр, для ссылки tel:
$phone_tel = preg_replace('/[^0-9\+]/', '', $phone_number);
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

        <button class="header__burger-button" aria-label="Open menu" aria-expanded="false">
            <span class="header__burger-line"></span>
            <span class="header__burger-line"></span>
            <span class="header__burger-line"></span>
        </button>
        
        <div class="header__left">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo" rel="home">
                <?php bloginfo( 'name' ); ?>
            </a>
            <div class="header__lang-switcher">
                <ul>
                    <?php pll_the_languages( array( 'hide_current' => 1, 'show_names' => 1, 'display_names_as' => 'slug' ) ); ?>
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
            <div class="mobile-menu__footer">
                <div class="header__actions">
                    <button class="header__button button button--primary">Потрібна консультація</button>
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
        </nav>
        
        <div class="header__right">
            <div class="header__contacts">
                <?php if ($phone_number) : ?>
                    <a href="tel:<?php echo esc_attr($phone_tel); ?>" class="header__contact-link" data-copy-text="<?php echo esc_attr($phone_tel); ?>">
                        <span class="header__contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18.9998 17.5V6.5C19.0627 5.37366 18.6774 4.2682 17.9279 3.42505C17.1784 2.5819 16.1258 2.06958 14.9998 2H8.99981C7.87387 2.06958 6.82121 2.5819 6.07175 3.42505C5.32228 4.2682 4.9369 5.37366 4.99982 6.5V17.5C4.9369 18.6263 5.32228 19.7317 6.07175 20.5748C6.82121 21.418 7.87387 21.9303 8.99981 21.9999H14.9998C16.1258 21.9303 17.1784 21.418 17.9279 20.5748C18.6774 19.7317 19.0627 18.6263 18.9998 17.5V17.5Z"></path> <path d="M14 5H10"></path> </g></svg>
                        </span>
                        <span class="header__contact-text"><?php echo esc_html($phone_number); ?></span>
                    </a>
                <?php endif; ?>
                <?php if ($address && $google_maps_link) : ?>
                    <a href="<?php echo esc_url($google_maps_link); ?>" target="_blank" rel="noopener noreferrer" class="header__contact-link">
                        <span class="header__contact-icon">
                            <svg viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 11.3201C3 8.93312 3.94822 6.64394 5.63605 4.95612C7.32387 3.26829 9.61305 2.32007 12 2.32007C14.3869 2.32007 16.6762 3.26829 18.364 4.95612C20.0518 6.64394 21 8.93312 21 11.3201"></path> <path d="M3 11.3201C3 17.4201 9.76 22.3201 12 22.3201C14.24 22.3201 21 17.4201 21 11.3201"></path> <path d="M12 15.3201C14.2091 15.3201 16 13.5292 16 11.3201C16 9.11093 14.2091 7.32007 12 7.32007C9.79086 7.32007 8 9.11093 8 11.3201C8 13.5292 9.79086 15.3201 12 15.3201Z"></path> </g></svg>
                        </span>
                        <span class="header__contact-text"><?php echo esc_html($address); ?></span>
                    </a>
                <?php endif; ?>
            </div>
            <div class="header__messengers">
                <?php if ($telegram_link) : ?>
                    <a href="<?php echo esc_url($telegram_link); ?>" class="header__messenger-link" aria-label="Telegram" target="_blank" rel="noopener noreferrer">
                        <svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>telegram_fill</title> <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Brand" transform="translate(-672.000000, -48.000000)"> <g id="telegram_fill" transform="translate(672.000000, 48.000000)"> <path d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z" id="MingCute" fill-rule="nonzero"> </path> <path d="M19.7773,4.42984 C20.8652,3.97177 22.0315,4.8917 21.8394,6.05639 L19.5705,19.8131 C19.3517,21.1395 17.8949,21.9006 16.678,21.2396 C15.6597,20.6865 14.1489,19.8352 12.7873,18.9455 C12.1074,18.5012 10.0255,17.0766 10.2814,16.0625 C10.5002,15.1954 14.0001,11.9375 16.0001,10 C16.7857,9.23893 16.4279,8.79926 15.5001,9.5 C13.1985,11.2383 9.50332,13.8812 8.28136,14.625 C7.20323,15.2812 6.64031,15.3932 5.96886,15.2812 C4.74273,15.0769 3.60596,14.7605 2.67788,14.3758 C1.42351,13.8558 1.48461,12.132 2.67703,11.63 L19.7773,4.42984 Z" id="路径" fill="#fff"> </path> </g> </g> </g> </g></svg>
                    </a>
                <?php endif; ?>
                <?php if ($viber_link) : ?>
                    <a href="<?php echo esc_url($viber_link); ?>" class="header__messenger-link" aria-label="Viber" target="_blank" rel="noopener noreferrer">
                        <svg fill="#fff" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 322 322" xml:space="preserve" stroke="#fff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="XMLID_7_"> <path id="XMLID_8_" d="M275.445,135.123c0.387-45.398-38.279-87.016-86.192-92.771c-0.953-0.113-1.991-0.285-3.09-0.467 c-2.372-0.393-4.825-0.797-7.3-0.797c-9.82,0-12.445,6.898-13.136,11.012c-0.672,4-0.031,7.359,1.902,9.988 c3.252,4.422,8.974,5.207,13.57,5.836c1.347,0.186,2.618,0.359,3.682,0.598c43.048,9.619,57.543,24.742,64.627,67.424 c0.173,1.043,0.251,2.328,0.334,3.691c0.309,5.102,0.953,15.717,12.365,15.717h0.001c0.95,0,1.971-0.082,3.034-0.244 c10.627-1.615,10.294-11.318,10.134-15.98c-0.045-1.313-0.088-2.555,0.023-3.381C275.429,135.541,275.444,135.332,275.445,135.123z "></path> <path id="XMLID_9_" d="M176.077,25.688c1.275,0.092,2.482,0.18,3.487,0.334c70.689,10.871,103.198,44.363,112.207,115.605 c0.153,1.211,0.177,2.688,0.202,4.252c0.09,5.566,0.275,17.145,12.71,17.385l0.386,0.004c3.9,0,7.002-1.176,9.221-3.498 c3.871-4.049,3.601-10.064,3.383-14.898c-0.053-1.186-0.104-2.303-0.091-3.281C318.481,68.729,255.411,2.658,182.614,0.201 c-0.302-0.01-0.59,0.006-0.881,0.047c-0.143,0.021-0.408,0.047-0.862,0.047c-0.726,0-1.619-0.063-2.566-0.127 C177.16,0.09,175.862,0,174.546,0c-11.593,0-13.797,8.24-14.079,13.152C159.817,24.504,170.799,25.303,176.077,25.688z"></path> <path id="XMLID_10_" d="M288.36,233.703c-1.503-1.148-3.057-2.336-4.512-3.508c-7.718-6.211-15.929-11.936-23.87-17.473 c-1.648-1.148-3.296-2.297-4.938-3.449c-10.172-7.145-19.317-10.617-27.957-10.617c-11.637,0-21.783,6.43-30.157,19.109 c-3.71,5.621-8.211,8.354-13.758,8.354c-3.28,0-7.007-0.936-11.076-2.783c-32.833-14.889-56.278-37.717-69.685-67.85 c-6.481-14.564-4.38-24.084,7.026-31.832c6.477-4.396,18.533-12.58,17.679-28.252c-0.967-17.797-40.235-71.346-56.78-77.428 c-7.005-2.576-14.365-2.6-21.915-0.06c-19.02,6.394-32.669,17.623-39.475,32.471C2.365,64.732,2.662,81.578,9.801,99.102 c20.638,50.666,49.654,94.84,86.245,131.293c35.816,35.684,79.837,64.914,130.839,86.875c4.597,1.978,9.419,3.057,12.94,3.844 c1.2,0.27,2.236,0.5,2.991,0.707c0.415,0.113,0.843,0.174,1.272,0.178l0.403,0.002c0.001,0,0,0,0.002,0 c23.988,0,52.791-21.92,61.637-46.91C313.88,253.209,299.73,242.393,288.36,233.703z"></path> <path id="XMLID_11_" d="M186.687,83.564c-4.107,0.104-12.654,0.316-15.653,9.021c-1.403,4.068-1.235,7.6,0.5,10.498 c2.546,4.252,7.424,5.555,11.861,6.27c16.091,2.582,24.355,11.48,26.008,28c0.768,7.703,5.955,13.082,12.615,13.082h0.001 c0.492,0,0.995-0.029,1.496-0.09c8.01-0.953,11.893-6.838,11.542-17.49c0.128-11.117-5.69-23.738-15.585-33.791 C209.543,88.98,197.574,83.301,186.687,83.564z"></path> </g> </g></svg>
                    </a>
                <?php endif; ?>
            </div>
            <div class="header__actions">
                <button class="header__button button button--primary">Потрібна консультація</button>
                <button id="theme-toggle" class="header__theme-toggle" aria-label="Toggle theme">
                    <svg class="header__theme-icon" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M19.0006 9.03002C19.0007 8.10058 18.8158 7.18037 18.4565 6.32317C18.0972 5.46598 17.5709 4.68895 16.9081 4.03734C16.2453 3.38574 15.4594 2.87265 14.5962 2.52801C13.7331 2.18336 12.8099 2.01409 11.8806 2.03002C10.0966 2.08307 8.39798 2.80604 7.12302 4.05504C5.84807 5.30405 5.0903 6.98746 5.00059 8.77001C4.95795 9.9595 5.21931 11.1402 5.75999 12.2006C6.30067 13.2609 7.10281 14.1659 8.09058 14.83C8.36897 15.011 8.59791 15.2584 8.75678 15.5499C8.91565 15.8415 8.99945 16.168 9.00059 16.5V18.03H15.0006V16.5C15.0006 16.1689 15.0829 15.843 15.24 15.5515C15.3971 15.26 15.6241 15.0121 15.9006 14.83C16.8528 14.1911 17.6336 13.328 18.1741 12.3167C18.7147 11.3054 18.9985 10.1767 19.0006 9.03002V9.03002Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M15 21.04C14.1345 21.6891 13.0819 22.04 12 22.04C10.9181 22.04 9.86548 21.6891 9 21.04" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </button>
            </div>
        </div>

    </div>
</header>