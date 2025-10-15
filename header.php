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
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.9894 4.9502L16.52 4.42014V4.42014L15.9894 4.9502ZM19.0716 8.03562L18.541 8.56568L19.0716 8.03562ZM8.73837 19.429L8.20777 19.9591L8.73837 19.429ZM4.62169 15.3081L5.15229 14.7781L4.62169 15.3081ZM17.5669 14.9943L17.3032 14.2922L17.5669 14.9943ZM15.6498 15.7146L15.9136 16.4167H15.9136L15.6498 15.7146ZM8.3322 8.38177L7.62798 8.12375L8.3322 8.38177ZM9.02665 6.48636L9.73087 6.74438V6.74438L9.02665 6.48636ZM5.84504 10.6735L6.04438 11.3965L5.84504 10.6735ZM7.30167 10.1351L6.86346 9.52646L6.86346 9.52646L7.30167 10.1351ZM7.67582 9.79038L8.24665 10.2768H8.24665L7.67582 9.79038ZM14.251 16.3805L14.742 16.9475L14.742 16.9475L14.251 16.3805ZM13.3806 18.2012L12.6574 18.0022V18.0022L13.3806 18.2012ZM13.9169 16.7466L13.3075 16.3094L13.3075 16.3094L13.9169 16.7466ZM2.71846 12.7552L1.96848 12.76L1.96848 12.76L2.71846 12.7552ZM2.93045 11.9521L2.28053 11.5778H2.28053L2.93045 11.9521ZM11.3052 21.3431L11.3064 20.5931H11.3064L11.3052 21.3431ZM12.0933 21.1347L11.7215 20.4833L11.7215 20.4833L12.0933 21.1347ZM11.6973 2.03606L11.8588 2.76845L11.6973 2.03606ZM1.4694 21.4699C1.17666 21.763 1.1769 22.2379 1.46994 22.5306C1.76298 22.8233 2.23786 22.8231 2.5306 22.5301L1.4694 21.4699ZM7.18383 17.8721C7.47657 17.5791 7.47633 17.1042 7.18329 16.8114C6.89024 16.5187 6.41537 16.5189 6.12263 16.812L7.18383 17.8721ZM15.4588 5.48026L18.541 8.56568L19.6022 7.50556L16.52 4.42014L15.4588 5.48026ZM9.26897 18.8989L5.15229 14.7781L4.09109 15.8382L8.20777 19.9591L9.26897 18.8989ZM17.3032 14.2922L15.386 15.0125L15.9136 16.4167L17.8307 15.6964L17.3032 14.2922ZM9.03642 8.63979L9.73087 6.74438L8.32243 6.22834L7.62798 8.12375L9.03642 8.63979ZM6.04438 11.3965C6.75583 11.2003 7.29719 11.0625 7.73987 10.7438L6.86346 9.52646C6.69053 9.65097 6.46601 9.72428 5.6457 9.95044L6.04438 11.3965ZM7.62798 8.12375C7.33502 8.92332 7.24338 9.14153 7.10499 9.30391L8.24665 10.2768C8.60041 9.86175 8.7823 9.33337 9.03642 8.63979L7.62798 8.12375ZM7.73987 10.7438C7.92696 10.6091 8.09712 10.4523 8.24665 10.2768L7.10499 9.30391C7.0337 9.38757 6.9526 9.46229 6.86346 9.52646L7.73987 10.7438ZM15.386 15.0125C14.697 15.2714 14.1716 15.4571 13.76 15.8135L14.742 16.9475C14.9028 16.8082 15.1192 16.7152 15.9136 16.4167L15.386 15.0125ZM14.1037 18.4001C14.329 17.5813 14.4021 17.3569 14.5263 17.1838L13.3075 16.3094C12.9902 16.7517 12.8529 17.2919 12.6574 18.0022L14.1037 18.4001ZM13.76 15.8135C13.5903 15.9605 13.4384 16.1269 13.3075 16.3094L14.5263 17.1838C14.5887 17.0968 14.6611 17.0175 14.742 16.9475L13.76 15.8135ZM5.15229 14.7781C4.50615 14.1313 4.06799 13.691 3.78366 13.3338C3.49835 12.9753 3.46889 12.8201 3.46845 12.7505L1.96848 12.76C1.97215 13.3422 2.26127 13.8297 2.61002 14.2679C2.95976 14.7073 3.47115 15.2176 4.09109 15.8382L5.15229 14.7781ZM5.6457 9.95044C4.80048 10.1835 4.10396 10.3743 3.58296 10.5835C3.06341 10.792 2.57116 11.0732 2.28053 11.5778L3.58038 12.3264C3.615 12.2663 3.71693 12.146 4.1418 11.9755C4.56523 11.8055 5.16337 11.6394 6.04438 11.3965L5.6457 9.95044ZM3.46845 12.7505C3.46751 12.6016 3.50616 12.4553 3.58038 12.3264L2.28053 11.5778C2.07354 11.9372 1.96586 12.3452 1.96848 12.76L3.46845 12.7505ZM8.20777 19.9591C8.83164 20.5836 9.34464 21.0987 9.78647 21.4506C10.227 21.8015 10.7179 22.0922 11.3041 22.0931L11.3064 20.5931C11.2369 20.593 11.0814 20.5644 10.721 20.2773C10.3618 19.9912 9.91923 19.5499 9.26897 18.8989L8.20777 19.9591ZM12.6574 18.0022C12.4133 18.8897 12.2462 19.4924 12.0751 19.9188C11.9033 20.3467 11.7821 20.4487 11.7215 20.4833L12.465 21.7861C12.974 21.4956 13.2573 21.0004 13.4671 20.4775C13.6776 19.9532 13.8694 19.2516 14.1037 18.4001L12.6574 18.0022ZM11.3041 22.0931C11.7112 22.0937 12.1114 21.9879 12.465 21.7861L11.7215 20.4833C11.595 20.5555 11.4519 20.5933 11.3064 20.5931L11.3041 22.0931ZM18.541 8.56568C19.6045 9.63022 20.3403 10.3695 20.7917 10.9788C21.2353 11.5774 21.2863 11.8959 21.2321 12.1464L22.6982 12.4634C22.8881 11.5854 22.5382 10.8162 21.9969 10.0857C21.4635 9.36592 20.6305 8.53486 19.6022 7.50556L18.541 8.56568ZM17.8307 15.6964C19.1921 15.1849 20.294 14.773 21.0771 14.3384C21.8718 13.8973 22.5083 13.3416 22.6982 12.4634L21.2321 12.1464C21.178 12.3968 21.0001 12.6655 20.3491 13.0268C19.6865 13.3946 18.7112 13.7632 17.3032 14.2922L17.8307 15.6964ZM16.52 4.42014C15.4841 3.3832 14.6481 2.54353 13.9246 2.00638C13.1908 1.46165 12.4175 1.10912 11.5357 1.30367L11.8588 2.76845C12.1086 2.71335 12.4277 2.7633 13.0304 3.21075C13.6433 3.66579 14.3876 4.40801 15.4588 5.48026L16.52 4.42014ZM9.73087 6.74438C10.2525 5.32075 10.6161 4.33403 10.9812 3.66315C11.3402 3.00338 11.609 2.82357 11.8588 2.76845L11.5357 1.30367C10.654 1.49819 10.1005 2.14332 9.66362 2.94618C9.23278 3.73793 8.82688 4.85154 8.32243 6.22834L9.73087 6.74438ZM2.5306 22.5301L7.18383 17.8721L6.12263 16.812L1.4694 21.4699L2.5306 22.5301Z" fill="currentColor"></path> </g></svg>
                            </span>
                            <span class="header__contact-text"><?php echo esc_html($address); ?></span>
                        </a>
                    <?php endif; ?>
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
                <button class="header__button button button--primary"><?php echo esc_html($header_button_text); ?></button>
            </div>
            <div class="header__contacts">
                <?php if ($phone_number) : ?>
                    <a href="tel:<?php echo esc_attr($phone_tel); ?>" class="header__contact-link">
                        <span class="header__contact-text"><?php echo esc_html($phone_number); ?></span>
                    </a>
                <?php endif; ?>
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
            <div class="header__lang-switcher">
                <ul>
                    <?php pll_the_languages( array( 'hide_current' => 0, 'show_names' => 1, 'display_names_as' => 'slug' ) ); ?>
                </ul>
            </div>
        </div>
    </div>
</header>