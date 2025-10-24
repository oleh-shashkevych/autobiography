<?php
// Отримуємо ВСІ значення з ACF
$phone_number = pll__(get_field('phone_number', 'option'));
$address = pll__(get_field('address', 'option'));
$google_maps_link = pll__(get_field('google_maps_link', 'option'));
$phone_tel = preg_replace('/[^0-9\+]/', '', $phone_number);

// НОВИЙ КОД: Отримуємо дані повторювачів
$contact_phones = get_field('contact_phones', 'option');
$contact_messengers = get_field('contact_messengers', 'option');

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
                    // START: ОБНОВЛЕННЫЙ ВЫВОД ЛОГОТИПОВ
                    $light_logo_url = get_field('light_theme_logo', 'option');
                    
                    if ( has_custom_logo() ) {
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo_dark = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                        // Выводим стандартный (темный) логотип
                        echo '<img src="' . esc_url( $logo_dark[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" class="logo-dark">';
                    } else {
                        // Если стандартного лого нет, выводим текстом (только для темной темы)
                        echo '<span class="logo-dark">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
                    }

                    // Выводим лого для светлой темы, если оно загружено
                    if ( $light_logo_url ) {
                        echo '<img src="' . esc_url( $light_logo_url ) . '" alt="' . get_bloginfo( 'name' ) . ' (Light theme logo)" class="logo-light">';
                    } else if ( !has_custom_logo() ) {
                        // Если НИКАКИХ лого нет, выводим текст и для светлой темы
                        echo '<span class="logo-light">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
                    }
                    // END: ОБНОВЛЕННЫЙ ВЫВОД ЛОГОТИПОВ
                    ?>
                </a>
            </div>

            <div class="header__section header__section--right">
                <div class="header__contacts">
                    
                    <div class="header__contact-group">
                        <div class="header__contact-icon-group">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.73268 2.043C6.95002 0.832583 8.95439 1.04804 9.9737 2.40962L11.2347 4.09402C12.0641 5.20191 11.9909 6.75032 11.0064 7.72923L10.7676 7.96665C10.7572 7.99694 10.7319 8.09215 10.76 8.2731C10.8232 8.6806 11.1635 9.545 12.592 10.9654C14.02 12.3853 14.8905 12.7253 15.3038 12.7887C15.4911 12.8174 15.5891 12.7906 15.6194 12.78L16.0274 12.3743C16.9026 11.5041 18.2475 11.3414 19.3311 11.9305L21.2416 12.9691C22.8775 13.8584 23.2909 16.0821 21.9505 17.4148L20.53 18.8273C20.0824 19.2723 19.4805 19.6434 18.7459 19.7119C16.9369 19.8806 12.7187 19.6654 8.28659 15.2584C4.14868 11.144 3.35462 7.556 3.25415 5.78817L4.00294 5.74562L3.25415 5.78817C3.20335 4.89426 3.62576 4.13796 4.16308 3.60369L5.73268 2.043ZM8.77291 3.30856C8.26628 2.63182 7.322 2.57801 6.79032 3.10668L5.22072 4.66737C4.8908 4.99542 4.73206 5.35695 4.75173 5.70307C4.83156 7.10766 5.47286 10.3453 9.34423 14.1947C13.4057 18.2331 17.1569 18.3536 18.6067 18.2184C18.9029 18.1908 19.1975 18.0369 19.4724 17.7636L20.8929 16.3511C21.4704 15.777 21.343 14.7315 20.5252 14.2869L18.6147 13.2484C18.0871 12.9616 17.469 13.0562 17.085 13.438L16.6296 13.8909L16.1008 13.359C16.6296 13.8909 16.6289 13.8916 16.6282 13.8923L16.6267 13.8937L16.6236 13.8967L16.6171 13.903L16.6025 13.9166C16.592 13.9262 16.5799 13.9367 16.5664 13.948C16.5392 13.9705 16.5058 13.9959 16.4659 14.0227C16.3858 14.0763 16.2801 14.1347 16.1472 14.1841C15.8764 14.285 15.5192 14.3392 15.0764 14.2713C14.2096 14.1384 13.0614 13.5474 11.5344 12.0291C10.0079 10.5113 9.41194 9.36834 9.2777 8.50306C9.20906 8.06061 9.26381 7.70331 9.36594 7.43225C9.41599 7.29941 9.47497 7.19378 9.5291 7.11389C9.5561 7.07405 9.58179 7.04074 9.60446 7.01368C9.6158 7.00015 9.6264 6.98817 9.63604 6.9777L9.64977 6.96312L9.65606 6.95666L9.65905 6.95363L9.66051 6.95217C9.66122 6.95146 9.66194 6.95075 10.1908 7.48258L9.66194 6.95075L9.94875 6.66556C10.3774 6.23939 10.4374 5.53194 10.0339 4.99297L8.77291 3.30856Z" fill="currentColor"></path> </g></svg>
                        </div>
                        <div class="header__contact-phones">
                            <?php /* if ($phone_number) : ?>
                                <a href="tel:<?php echo esc_attr($phone_tel); ?>" class="header__contact-link" data-copy-text="<?php echo esc_attr($phone_tel); ?>">
                                    <span class="header__contact-text"><?php echo esc_html($phone_number); ?></span>
                                </a>
                            <?php endif; */ ?>
                            <?php if ($contact_phones) : ?>
                                <?php foreach($contact_phones as $phone_item) : 
                                    $phone_num = $phone_item['phone_number'];
                                    $phone_tel_item = preg_replace('/[^0-9\+]/', '', $phone_num);
                                ?>
                                    <a href="tel:<?php echo esc_attr($phone_tel_item); ?>" class="header__contact-link" data-copy-text="<?php echo esc_attr($phone_tel_item); ?>">
                                        <span class="header__contact-text"><?php echo esc_html($phone_num); ?></span>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <?php if ($contact_messengers) : ?>
                            <div class="header__contact-messengers">
                                <?php foreach($contact_messengers as $messenger) : ?>
                                    <a href="<?php echo esc_url($messenger['link']); ?>" target="_blank" rel="noopener noreferrer" class="header__messenger-link">
                                        <?php echo $messenger['icon']; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($address && $google_maps_link) : ?>
                        <a href="<?php echo esc_url($google_maps_link); ?>" target="_blank" rel="noopener noreferrer" class="header__contact-link header__contact-link--address">
                            <span class="header__contact-icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M18 8L18.9487 8.31623C19.9387 8.64624 20.4337 8.81124 20.7169 9.20407C21 9.5969 21 10.1187 21 11.1623V16.829C21 18.1199 21 18.7653 20.6603 19.18C20.5449 19.3208 20.4048 19.4394 20.247 19.5301C19.7821 19.797 19.1455 19.6909 17.8721 19.4787C16.6157 19.2693 15.9875 19.1646 15.3648 19.2167C15.1463 19.235 14.9292 19.2676 14.715 19.3144C14.1046 19.4477 13.5299 19.735 12.3806 20.3097C10.8809 21.0596 10.131 21.4345 9.33284 21.5501C9.09242 21.5849 8.8498 21.6021 8.60688 21.6016C7.80035 21.6001 7.01186 21.3373 5.43488 20.8116L5.05132 20.6838C4.06129 20.3538 3.56627 20.1888 3.28314 19.7959C3 19.4031 3 18.8813 3 17.8377V12.908C3 11.2491 3 10.4197 3.48841 9.97358C3.57388 9.89552 3.66809 9.82762 3.76917 9.77122C4.34681 9.44894 5.13369 9.71123 6.70746 10.2358" stroke="#2ECC71" stroke-width="1.5"></path> <path d="M6 7.70031C6 4.55211 8.68629 2 12 2C15.3137 2 18 4.55211 18 7.70031C18 10.8238 16.085 14.4687 13.0972 15.7721C12.4007 16.076 11.5993 16.076 10.9028 15.7721C7.91499 14.4687 6 10.8238 6 7.70031Z" stroke="#2ECC71" stroke-width="1.5"></path> <circle cx="12" cy="8" r="2" stroke="#2ECC71" stroke-width="1.5"></circle> </g></svg>
                            </span>
                            <span class="header__contact-text"><?php echo esc_html($address); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="header__actions">
					<?php
						// Determine form ID based on language
						$header_form_id = (function_exists('pll_current_language') && pll_current_language('slug') === 'uk') ? '3' : '5';
						$header_popup_link = '#form-' . $header_form_id;
					?>
					<a href="<?php echo esc_attr($header_popup_link); ?>" class="header__button button button--primary"><?php echo esc_html($header_button_text); ?></a>
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
            <div class="header__lang-switcher">
                <ul>
                    <?php pll_the_languages( array( 'hide_current' => 0, 'show_names' => 1, 'display_names_as' => 'slug' ) ); ?>
                </ul>
            </div>
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
				<?php
					// We can reuse the variables defined above if this is in the same scope,
					// otherwise, redefine them here if needed.
					// $header_form_id = (function_exists('pll_current_language') && pll_current_language('slug') === 'uk') ? '3' : '5';
					// $header_popup_link = '#form-' . $header_form_id;
				?>
				<a href="<?php echo esc_attr($header_popup_link); ?>" class="header__button button button--primary"><?php echo esc_html($header_button_text); ?></a>
			</div>
            <div class="header__contacts">
                 <?php if ($contact_phones) : ?>
                    <?php foreach($contact_phones as $phone_item) : 
                        $phone_num = $phone_item['phone_number'];
                        $phone_tel_item = preg_replace('/[^0-9\+]/', '', $phone_num);
                    ?>
                        <a href="tel:<?php echo esc_attr($phone_tel_item); ?>" class="header__contact-link">
                            <span class="header__contact-text"><?php echo esc_html($phone_num); ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
                 <?php if ($address && $google_maps_link) : ?>
                    <a href="<?php echo esc_url($google_maps_link); ?>" target="_blank" rel="noopener noreferrer" class="header__contact-link">
                        <span class="header__contact-text"><?php echo esc_html($address); ?></span>
                    </a>
                <?php endif; ?>
            </div>
            <div class="theme-switcher">
                <input type="checkbox" id="theme-switcher-toggle-mobile" class="theme-switcher__input">
                <label for="theme-switcher-toggle-mobile" class="theme-switcher__label"></label>
                <span class="theme-switcher__text"><?php echo esc_html($theme_switcher_text); ?></span>
            </div>
            <div class="header__lang-switcher">
                <ul>
                    <?php pll_the_languages( array( 'hide_current' => 0, 'show_names' => 1, 'display_names_as' => 'slug' ) ); ?>
                </ul>
            </div>
        </div>
    </div>
</header>