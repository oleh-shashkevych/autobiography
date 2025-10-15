<?php
// Отримуємо значення з Налаштувань теми і пропускаємо через функцію перекладу Polylang
$footer_about_text      = pll__(get_field('footer_about_text', 'option'));
$footer_services_title  = pll__(get_field('footer_services_title', 'option'));
$footer_sitemap_title   = pll__(get_field('footer_sitemap_title', 'option'));
$footer_contacts_title  = pll__(get_field('footer_contacts_title', 'option'));
$footer_copyright_text  = pll__(get_field('footer_copyright_text', 'option'));

// Отримуємо дані для контактів
$address                = pll__(get_field('address', 'option'));
$google_maps_link       = get_field('google_maps_link', 'option');
$email                  = pll__(get_field('email', 'option'));
$contact_phones         = get_field('contact_phones', 'option');

// Отримуємо мітки
$footer_address_label   = pll__(get_field('footer_address_label', 'option'));
$footer_phone_label     = pll__(get_field('footer_phone_label', 'option'));
$footer_email_label     = pll__(get_field('footer_email_label', 'option'));

// Отримуємо дані для секції з формою
$contact_title      = pll__(get_field('contact_section_title', 'option'));
$contact_subtitle   = pll__(get_field('contact_section_subtitle', 'option'));
$contact_image_url  = get_field('contact_section_image', 'option');
$contact_shortcode  = pll__(get_field('contact_section_form_shortcode', 'option'));

// Отримуємо логотипи для футера
$light_logo_url = get_field('light_theme_logo', 'option');

// Отримуємо дані соцмереж
$social_media = get_field('social_media', 'option');
?>

<section class="contact-section">
    <div class="contact-section__container">

        <?php if ($contact_image_url) : ?>
            <div class="contact-section__image-wrapper">
                <img src="<?php echo esc_url($contact_image_url); ?>" alt="<?php echo esc_attr($contact_title); ?>">
            </div>
        <?php endif; ?>

        <div class="contact-section__form-wrapper">
            <?php if ($contact_title) : ?>
                <h2 class="contact-section__title"><?php echo esc_html($contact_title); ?></h2>
            <?php endif; ?>

            <?php if ($contact_subtitle) : ?>
                <p class="contact-section__subtitle"><?php echo esc_html($contact_subtitle); ?></p>
            <?php endif; ?>
            
            <?php if ($contact_shortcode) : ?>
                <div class="contact-section__form">
                    <?php echo do_shortcode($contact_shortcode); ?>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
</section>

<footer class="footer">
    <div class="footer__container">
        <div class="footer__main">
            <div class="footer__column footer__column--about">
                
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer__logo" rel="home">
                    <?php
                    if ( has_custom_logo() ) {
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo_dark = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                        // Выводим стандартный (темный) логотип
                        echo '<img src="' . esc_url( $logo_dark[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" class="logo-dark">';
                    } else {
                        // Если стандартного лого нет, выводим текстом
                        echo '<span class="logo-dark">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
                    }

                    // Выводим лого для светлой темы, если оно загружено
                    if ( $light_logo_url ) {
                         echo '<img src="' . esc_url( $light_logo_url ) . '" alt="' . get_bloginfo( 'name' ) . ' (Light theme logo)" class="logo-light">';
                    } else if ( !has_custom_logo() ) {
                        // Если НИКАКИХ лого нет, выводим текст и для светлой темы
                        echo '<span class="logo-light">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
                    }
                    ?>
                </a>

                <?php if ($footer_about_text) : ?>
                    <p class="footer__about-text"><?php echo esc_html($footer_about_text); ?></p>
                <?php endif; ?>

                <?php if ($social_media): ?>
                <div class="footer__socials">
                    <?php foreach($social_media as $sm): ?>
                        <a href="<?php echo esc_url($sm['link']); ?>" target="_blank" rel="noopener noreferrer" class="footer__social-link">
                            <?php echo $sm['icon']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </div>
            <div class="footer__column footer__column--links">
                <h3 class="footer__title"><?php echo esc_html($footer_services_title); ?></h3>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer_services_menu',
                    'container'      => false,
                    'menu_class'     => 'footer__list',
                    'fallback_cb'    => false,
                ) );
                ?>
            </div>
            <div class="footer__column footer__column--links">
                <h3 class="footer__title"><?php echo esc_html($footer_sitemap_title); ?></h3>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer_sitemap_menu',
                    'container'      => false,
                    'menu_class'     => 'footer__list',
                    'fallback_cb'    => false,
                ) );
                ?>
            </div>
            <div class="footer__column footer__column--contacts">
                <h3 class="footer__title"><?php echo esc_html($footer_contacts_title ?? pll__('Контакти')); ?></h3>
                <ul class="footer__contact-list">
                    <?php if ($address) : ?>
                    <li class="footer__contact-item">
                        <div class="footer__contact-details">
                            <strong><?php echo esc_html($footer_address_label); ?></strong>
                            <?php if ($google_maps_link): ?>
                                <a href="<?php echo esc_url($google_maps_link); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php echo esc_html($address); ?>
                                </a>
                            <?php else: ?>
                                <span><?php echo esc_html($address); ?></span>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if ( !empty($contact_phones) ) : ?>
                    <li class="footer__contact-item">
                        <div class="footer__contact-details">
                            <strong><?php echo esc_html($footer_phone_label); ?></strong>
                            <?php foreach($contact_phones as $phone) : 
                                if (empty($phone['phone_number'])) continue;
                                $phone_num = $phone['phone_number'];
                                $phone_tel = preg_replace('/[^0-9\+]/', '', $phone_num);
                            ?>
                                <a href="tel:<?php echo esc_attr($phone_tel); ?>"><?php echo esc_html(pll__($phone_num)); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if ($email) : ?>
                    <li class="footer__contact-item">
                        <div class="footer__contact-details">
                            <strong><?php echo esc_html($footer_email_label); ?></strong>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </div>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <p class="footer__copyright">&copy; <?php echo date('Y'); ?>. <?php echo esc_html($footer_copyright_text); ?> <?php bloginfo( 'name' ); ?></p>
        </div>
    </div>
    <a href="#" class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'autobiography'); ?>">
        <svg viewBox="0 -5 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#fff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>chevron-up</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-519.000000, -1200.000000)" fill="#fff"> <path d="M542.687,1212.29 L531.745,1200.31 C531.535,1200.1 531.258,1200.01 530.984,1200.03 C530.711,1200.01 530.434,1200.1 530.224,1200.31 L519.281,1212.29 C518.89,1212.69 518.89,1213.32 519.281,1213.72 C519.674,1214.11 520.31,1214.11 520.701,1213.72 L530.984,1202.46 L541.268,1213.72 C541.659,1214.11 542.295,1214.11 542.687,1213.72 C543.079,1213.32 543.079,1212.69 542.687,1212.29" id="chevron-up" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
    </a>
</footer>

<?php wp_footer(); ?>
</body>
</html>