<?php
/**
 * Template Name: Сторінка Контакти
 * Description: Шаблон для сторінки контактів.
 */

get_header();

// Отримуємо дані з загальних налаштувань теми
$address          = pll__(get_field('address', 'option'));
$google_maps_link = get_field('google_maps_link', 'option');
$working_hours    = get_field('working_hours', 'option');
$social_media     = get_field('social_media', 'option');

// START: ОТРИМУЄМО НОВІ ДАНІ ДЛЯ КОНТАКТІВ
$contact_phones   = get_field('contact_phones', 'option');
$contact_messengers = get_field('contact_messengers', 'option');
$contact_emails   = get_field('contact_emails', 'option');
// END: ОТРИМУЄМО НОВІ ДАНІ ДЛЯ КОНТАКТІВ

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
                        <h3 class="contact-item__title"><?php echo esc_html(autobiography_translate_string('Адреса', 'Address')); ?></h3>
                        <p class="contact-item__text"><?php echo esc_html($address); ?></p>
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
                    
                    <?php if ($contact_phones || $contact_messengers): ?>
                    <div class="contact-item">
                        <h3 class="contact-item__title"><?php echo esc_html(autobiography_translate_string('Для зв\'язку', 'Contact Info')); ?></h3>
                        <?php if ($contact_phones): ?>
                            <div class="contact-item__phones">
                                <?php foreach($contact_phones as $phone): 
                                    if ( empty($phone['phone_number']) ) continue;
                                    $phone_num = $phone['phone_number'];
                                    $phone_tel = preg_replace('/[^0-9\+]/', '', $phone_num);
                                ?>
                                    <a href="tel:<?php echo esc_attr($phone_tel); ?>" class="contact-item__link">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.73268 2.043C6.95002 0.832583 8.95439 1.04804 9.9737 2.40962L11.2347 4.09402C12.0641 5.20191 11.9909 6.75032 11.0064 7.72923L10.7676 7.96665C10.7572 7.99694 10.7319 8.09215 10.76 8.2731C10.8232 8.6806 11.1635 9.545 12.592 10.9654C14.02 12.3853 14.8905 12.7253 15.3038 12.7887C15.4911 12.8174 15.5891 12.7906 15.6194 12.78L16.0274 12.3743C16.9026 11.5041 18.2475 11.3414 19.3311 11.9305L21.2416 12.9691C22.8775 13.8584 23.2909 16.0821 21.9505 17.4148L20.53 18.8273C20.0824 19.2723 19.4805 19.6434 18.7459 19.7119C16.9369 19.8806 12.7187 19.6654 8.28659 15.2584C4.14868 11.144 3.35462 7.556 3.25415 5.78817L4.00294 5.74562L3.25415 5.78817C3.20335 4.89426 3.62576 4.13796 4.16308 3.60369L5.73268 2.043ZM8.77291 3.30856C8.26628 2.63182 7.322 2.57801 6.79032 3.10668L5.22072 4.66737C4.8908 4.99542 4.73206 5.35695 4.75173 5.70307C4.83156 7.10766 5.47286 10.3453 9.34423 14.1947C13.4057 18.2331 17.1569 18.3536 18.6067 18.2184C18.9029 18.1908 19.1975 18.0369 19.4724 17.7636L20.8929 16.3511C21.4704 15.777 21.343 14.7315 20.5252 14.2869L18.6147 13.2484C18.0871 12.9616 17.469 13.0562 17.085 13.438L16.6296 13.8909L16.1008 13.359C16.6296 13.8909 16.6289 13.8916 16.6282 13.8923L16.6267 13.8937L16.6236 13.8967L16.6171 13.903L16.6025 13.9166C16.592 13.9262 16.5799 13.9367 16.5664 13.948C16.5392 13.9705 16.5058 13.9959 16.4659 14.0227C16.3858 14.0763 16.2801 14.1347 16.1472 14.1841C15.8764 14.285 15.5192 14.3392 15.0764 14.2713C14.2096 14.1384 13.0614 13.5474 11.5344 12.0291C10.0079 10.5113 9.41194 9.36834 9.2777 8.50306C9.20906 8.06061 9.26381 7.70331 9.36594 7.43225C9.41599 7.29941 9.47497 7.19378 9.5291 7.11389C9.5561 7.07405 9.58179 7.04074 9.60446 7.01368C9.6158 7.00015 9.6264 6.98817 9.63604 6.9777L9.64977 6.96312L9.65606 6.95666L9.65905 6.95363L9.66051 6.95217C9.66122 6.95146 9.66194 6.95075 10.1908 7.48258L9.66194 6.95075L9.94875 6.66556C10.3774 6.23939 10.4374 5.53194 10.0339 4.99297L8.77291 3.30856Z" fill="currentColor"></path> </g></svg>
                                        <?php echo esc_html(pll__($phone_num)); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($contact_messengers): ?>
                            <div class="contact-messengers">
                                <?php foreach($contact_messengers as $messenger): ?>
                                    <a href="<?php echo esc_url($messenger['link']); ?>" target="_blank" rel="noopener noreferrer" class="contact-messengers__link" aria-label="Messenger link">
                                        <?php echo $messenger['icon']; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($contact_emails): ?>
                    <div class="contact-item">
                        <h3 class="contact-item__title">E-mail</h3>
                        <?php foreach($contact_emails as $email_item): 
                            if ( empty($email_item['email']) ) continue;
                            $current_email = $email_item['email'];
                        ?>
                            <a href="mailto:<?php echo esc_attr($current_email); ?>" class="contact-item__link">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9463 1.25H13.0537C14.1865 1.24998 15.1123 1.24996 15.8431 1.34822C16.6071 1.45093 17.2694 1.67321 17.7981 2.2019C18.3268 2.7306 18.5491 3.39294 18.6518 4.15689C18.7023 4.53259 18.7268 4.95979 18.7388 5.44015C19.797 5.61086 20.6642 5.94692 21.3588 6.64144C22.1071 7.3898 22.4392 8.33875 22.5969 9.51117C22.75 10.6504 22.75 12.106 22.75 13.9438V14.0566C22.75 15.8944 22.75 17.35 22.5969 18.4892C22.4392 19.6616 22.1071 20.6106 21.3588 21.359C20.6104 22.1073 19.6614 22.4394 18.489 22.5971C17.3498 22.7502 15.8942 22.7502 14.0564 22.7502H9.94359C8.10583 22.7502 6.65019 22.7502 5.51098 22.5971C4.33856 22.4394 3.38961 22.1073 2.64124 21.359C1.89288 20.6106 1.56076 19.6616 1.40314 18.4892C1.24997 17.35 1.24998 15.8944 1.25 14.0566V13.9438C1.24998 12.106 1.24997 10.6504 1.40314 9.51117C1.56076 8.33875 1.89288 7.3898 2.64124 6.64144C3.33576 5.94692 4.20302 5.61086 5.26124 5.44015C5.27316 4.95979 5.29771 4.53259 5.34822 4.15689C5.45093 3.39294 5.67321 2.7306 6.2019 2.2019C6.7306 1.67321 7.39293 1.45093 8.15689 1.34822C8.88775 1.24996 9.81348 1.24998 10.9463 1.25ZM5.25 6.96613C4.51901 7.11288 4.05575 7.34825 3.7019 7.7021C3.27869 8.12531 3.02502 8.70495 2.88976 9.71104C2.75159 10.7387 2.75 12.0934 2.75 14.0002C2.75 15.907 2.75159 17.2617 2.88976 18.2893C3.02502 19.2954 3.27869 19.8751 3.7019 20.2983C4.12511 20.7215 4.70476 20.9752 5.71085 21.1104C6.73851 21.2486 8.09318 21.2502 10 21.2502H14C15.9068 21.2502 17.2615 21.2486 18.2892 21.1104C19.2952 20.9752 19.8749 20.7215 20.2981 20.2983C20.7213 19.8751 20.975 19.2954 21.1102 18.2893C21.2484 17.2617 21.25 15.907 21.25 14.0002C21.25 12.0934 21.2484 10.7387 21.1102 9.71104C20.975 8.70495 20.7213 8.12531 20.2981 7.7021C19.9443 7.34825 19.481 7.11288 18.75 6.96613V8.1265C18.75 8.17264 18.75 8.21822 18.7501 8.26327C18.7509 9.04932 18.7516 9.67194 18.4904 10.2297C18.2291 10.7874 17.7504 11.1855 17.146 11.6881C17.1114 11.7169 17.0763 11.746 17.0409 11.7756L16.2837 12.4066C15.3973 13.1452 14.6789 13.7439 14.0448 14.1517C13.3843 14.5765 12.7411 14.8449 12 14.8449C11.2589 14.8449 10.6157 14.5765 9.95518 14.1517C9.32112 13.7439 8.60272 13.1452 7.71637 12.4066L6.95912 11.7756C6.92368 11.746 6.88864 11.7169 6.85401 11.6881C6.2496 11.1855 5.77086 10.7874 5.50963 10.2297C5.2484 9.67194 5.24906 9.04932 5.2499 8.26326C5.24995 8.21822 5.25 8.17264 5.25 8.1265L5.25 6.96613ZM8.35676 2.83484C7.75914 2.91519 7.4661 3.05902 7.26256 3.26256C7.05902 3.4661 6.91519 3.75914 6.83484 4.35676C6.75159 4.97595 6.75 5.80029 6.75 7V8.1265C6.75 9.11781 6.76657 9.37686 6.86801 9.59345C6.96946 9.81003 7.15786 9.9886 7.9194 10.6232L8.63903 11.2229C9.57199 12.0004 10.2197 12.5384 10.7666 12.8901C11.2959 13.2306 11.6549 13.3449 12 13.3449C12.3451 13.3449 12.7041 13.2306 13.2334 12.8901C13.7803 12.5384 14.428 12.0004 15.361 11.2229L16.0806 10.6232C16.8421 9.9886 17.0305 9.81003 17.132 9.59345C17.2334 9.37686 17.25 9.11781 17.25 8.1265V7C17.25 5.80029 17.2484 4.97595 17.1652 4.35676C17.0848 3.75914 16.941 3.4661 16.7374 3.26256C16.5339 3.05902 16.2409 2.91519 15.6432 2.83484C15.0241 2.75159 14.1997 2.75 13 2.75H11C9.80029 2.75 8.97595 2.75159 8.35676 2.83484ZM9.25 6C9.25 5.58579 9.58579 5.25 10 5.25H14C14.4142 5.25 14.75 5.58579 14.75 6C14.75 6.41422 14.4142 6.75 14 6.75H10C9.58579 6.75 9.25 6.41422 9.25 6ZM10.25 9C10.25 8.58579 10.5858 8.25 11 8.25H13C13.4142 8.25 13.75 8.58579 13.75 9C13.75 9.41422 13.4142 9.75 13 9.75H11C10.5858 9.75 10.25 9.41422 10.25 9Z" fill="currentColor"></path> </g></svg>
                                <?php echo esc_html(pll__($current_email)); ?>
                            </a>
                        <?php endforeach; ?>
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