<?php
// Отримуємо значення з Налаштувань теми і пропускаємо через функцію перекладу Polylang
$phone_number     = pll__(get_field('phone_number', 'option'));
$phone_tel        = preg_replace('/[^0-9\+]/', '', $phone_number);
$address          = pll__(get_field('address', 'option'));
$email            = pll__(get_field('email', 'option'));
$contact_title      = pll__(get_field('contact_section_title', 'option'));
$contact_subtitle   = pll__(get_field('contact_section_subtitle', 'option'));
$contact_image_url  = get_field('contact_section_image', 'option');
$contact_shortcode  = pll__(get_field('contact_section_form_shortcode', 'option'));

// Нові змінні для футера
$footer_about_text      = pll__(get_field('footer_about_text', 'option'));
$footer_services_title  = pll__(get_field('footer_services_title', 'option'));
$footer_sitemap_title   = pll__(get_field('footer_sitemap_title', 'option'));
$footer_contacts_title  = pll__(get_field('footer_contacts_title', 'option'));
$footer_address_label   = pll__(get_field('footer_address_label', 'option'));
$footer_phone_label     = pll__(get_field('footer_phone_label', 'option'));
$footer_email_label     = pll__(get_field('footer_email_label', 'option'));
$footer_copyright_text  = pll__(get_field('footer_copyright_text', 'option'));
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
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer__logo">
                    <?php bloginfo( 'name' ); ?>
                </a>
                <?php if ($footer_about_text) : ?>
                    <p class="footer__about-text"><?php echo esc_html($footer_about_text); ?></p>
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
                <h3 class="footer__title"><?php echo esc_html($footer_contacts_title); ?></h3>
                <ul class="footer__contact-list">
                    <li class="footer__contact-item">
                        <span class="footer__contact-icon"></span>
                        <div class="footer__contact-details">
                            <strong><?php echo esc_html($footer_address_label); ?></strong>
                            <span><?php echo esc_html($address); ?></span>
                        </div>
                    </li>
                    <li class="footer__contact-item">
                        <span class="footer__contact-icon"></span>
                        <div class="footer__contact-details">
                            <strong><?php echo esc_html($footer_phone_label); ?></strong>
                            <a href="tel:<?php echo esc_attr($phone_tel); ?>"><?php echo esc_html($phone_number); ?></a>
                        </div>
                    </li>
                    <li class="footer__contact-item">
                        <span class="footer__contact-icon"></span>
                        <div class="footer__contact-details">
                            <strong><?php echo esc_html($footer_email_label); ?></strong>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </div>
                    </li>
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