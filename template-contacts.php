<?php
/**
 * Template Name: Сторінка Контакти
 * Description: Шаблон для сторінки контактів.
 */

get_header();

// Отримуємо дані з загальних налаштувань теми
$address          = pll__(get_field('address', 'option'));
$google_maps_link = get_field('google_maps_link', 'option');
$phone_number     = pll__(get_field('phone_number', 'option'));
$phone_tel        = preg_replace('/[^0-9\+]/', '', $phone_number);
$email            = get_field('email', 'option');
$working_hours    = get_field('working_hours', 'option');
$social_media     = get_field('social_media', 'option');

// Отримуємо дані з полів самої сторінки
$map_embed        = get_field('google_map_embed');
$hero_image       = get_field('contacts_hero_image');
$hero_overlay     = get_field('contacts_hero_overlay');

// Формуємо класи і стилі для Hero
$hero_style = $hero_image ? 'style="background-image: url(' . esc_url($hero_image) . ');"' : '';
$hero_classes = 'page-hero' . ($hero_image && $hero_overlay ? ' has-overlay' : '');
?>

<main id="primary" class="site-main">

    <section class="<?php echo esc_attr($hero_classes); ?>" <?php echo $hero_style; ?>>
        <div class="container">
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
        </div>
    </section>

    <section class="contacts-section">
        <div class="container">
            <div class="contacts-grid">
                <div class="contacts-grid__info">
                    
                    <?php if ($address): ?>
                    <div class="contact-item">
                        <h3 class="contact-item__title"><?php echo esc_html(autobiography_translate_string('Наша адреса', 'Our Address')); ?></h3>
                        <p class="contact-item__text"><?php echo esc_html($address); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($phone_number || $email): ?>
                    <div class="contact-item">
                        <h3 class="contact-item__title"><?php echo esc_html(autobiography_translate_string('Для зв\'язку', 'Contact Info')); ?></h3>
                        <?php if ($phone_number): ?>
                            <a href="tel:<?php echo esc_attr($phone_tel); ?>" class="contact-item__link"><?php echo esc_html($phone_number); ?></a>
                        <?php endif; ?>
                        <?php if ($email): ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-item__link"><?php echo esc_html($email); ?></a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($working_hours): ?>
                    <div class="contact-item">
                        <h3 class="contact-item__title"><?php echo esc_html(autobiography_translate_string('Графік роботи', 'Working Hours')); ?></h3>
                        <div class="working-hours-list">
                        <?php foreach($working_hours as $wh): ?>
                            <div class="wh-item">
                                <span class="wh-item__days"><?php echo esc_html(pll__($wh['days'])); ?></span>
                                <span class="wh-item__hours"><?php echo esc_html(pll__($wh['hours'])); ?></span>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($social_media): ?>
                    <div class="contact-item">
                        <h3 class="contact-item__title"><?php echo esc_html(autobiography_translate_string('Ми в соцмережах', 'Find Us On Social')); ?></h3>
                        <div class="contact-socials">
                        <?php foreach($social_media as $sm): ?>
                            <a href="<?php echo esc_url($sm['link']); ?>" target="_blank" rel="noopener noreferrer" class="contact-socials__link">
                                <?php echo $sm['icon']; ?>
                            </a>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>

                <div class="contacts-grid__map">
                    <?php if ($map_embed): ?>
                    <div class="map-embed-wrapper">
                        <?php echo $map_embed; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($google_maps_link): ?>
                        <a href="<?php echo esc_url($google_maps_link); ?>" target="_blank" rel="noopener noreferrer" class="button button--primary map-button">
                            <?php echo esc_html(autobiography_translate_string('Прокласти маршрут', 'Get Directions')); ?>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>