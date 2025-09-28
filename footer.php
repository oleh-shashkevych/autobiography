<?php
// Переменные из header.php могут быть недоступны здесь, получим их снова, если нужно
$phone_number     = get_field('phone_number', 'option');
$phone_tel        = preg_replace('/[^0-9\+]/', '', $phone_number);
$address          = get_field('address', 'option');
$google_maps_link = get_field('google_maps_link', 'option');
$contact_title      = get_field('contact_section_title', 'option');
$contact_subtitle   = get_field('contact_section_subtitle', 'option');
$contact_image_url  = get_field('contact_section_image', 'option');
$contact_shortcode  = get_field('contact_section_form_shortcode', 'option');
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
                <p class="footer__about-text">
                    Клієнти з усієї України довіряють нам, і багато хто з них повертається з проханням - продати авто, швидкий автовикуп. Ми робимо все, щоб це рішення було продуманим та максимально вдалим.
                </p>
            </div>
            <div class="footer__column footer__column--links">
                <h3 class="footer__title">Наші Послуги</h3>
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
                <h3 class="footer__title">Карта Сайту</h3>
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
                <h3 class="footer__title">Контакти</h3>
                <ul class="footer__contact-list">
                    <li class="footer__contact-item">
                        <span class="footer__contact-icon"></span>
                        <div class="footer__contact-details">
                            <strong>Адреса</strong>
                            <span><?php echo esc_html(get_field('address', 'option')); ?></span>
                        </div>
                    </li>
                    <li class="footer__contact-item">
                        <span class="footer__contact-icon"></span>
                        <div class="footer__contact-details">
                            <strong>Телефон</strong>
                            <a href="tel:<?php echo esc_attr($phone_tel); ?>"><?php echo esc_html($phone_number); ?></a>
                        </div>
                    </li>
                    <li class="footer__contact-item">
                        <span class="footer__contact-icon"></span>
                        <div class="footer__contact-details">
                            <strong>E-mail</strong>
                            <a href="mailto:<?php echo esc_attr(get_field('email', 'option')); ?>"><?php echo esc_html(get_field('email', 'option')); ?></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <p class="footer__copyright">&copy; <?php echo date('Y'); ?>. All rights reserved <?php bloginfo( 'name' ); ?></p>
        </div>
    </div>
    <a href="#" class="back-to-top" aria-label="Back to top">
        <svg viewBox="0 -5 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#fff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>chevron-up</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-519.000000, -1200.000000)" fill="#fff"> <path d="M542.687,1212.29 L531.745,1200.31 C531.535,1200.1 531.258,1200.01 530.984,1200.03 C530.711,1200.01 530.434,1200.1 530.224,1200.31 L519.281,1212.29 C518.89,1212.69 518.89,1213.32 519.281,1213.72 C519.674,1214.11 520.31,1214.11 520.701,1213.72 L530.984,1202.46 L541.268,1213.72 C541.659,1214.11 542.295,1214.11 542.687,1213.72 C543.079,1213.32 543.079,1212.69 542.687,1212.29" id="chevron-up" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
    </a>
</footer>

<?php wp_footer(); ?>
</body>
</html>