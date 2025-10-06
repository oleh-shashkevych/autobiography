<?php
/**
 * Template Name: Сторінка Про нас
 * Description: Шаблон для сторінки "Про нас".
 */

get_header();

// Отримуємо дані для унікального Hero-блоку
$hero_image = get_field('about_hero_image');
$hero_title = get_field('about_hero_title');
$hero_subtitle = get_field('about_hero_subtitle');

// Отримуємо дані для основного контенту
$main_content = get_field('about_main_content');

// Отримуємо дані для НЕЗАЛЕЖНОЇ секції послуг
$services_title = get_field('about_services_title');
$services_list = get_field('about_services_list');
?>

<main id="primary" class="site-main">

    <?php if ($hero_image || $hero_title): ?>
    <section class="about-hero">
        <div class="container">
            <div class="about-hero__grid">
                <?php if ($hero_image): ?>
                <div class="about-hero__image-wrapper">
                    <img src="<?php echo esc_url($hero_image); ?>" alt="<?php echo esc_attr($hero_title); ?>">
                </div>
                <?php endif; ?>
                <div class="about-hero__content">
                    <h1 class="about-hero__title"><?php echo esc_html($hero_title); ?></h1>
                    <?php if ($hero_subtitle): ?>
                    <p class="about-hero__subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if ($main_content): ?>
    <section class="page-content">
        <div class="container content-container">
            <div class="content-styles">
                <?php echo $main_content; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php 
    // Незалежна секція "Наші Послуги"
    if ( $services_list ) :
    ?>
    <section class="our-services">
        <div class="container">
            <?php if ( $services_title ) : ?>
                <h2 class="our-services__title"><?php echo esc_html($services_title); ?></h2>
            <?php endif; ?>

            <div class="our-services__content-wrapper">
                <ul class="our-services__tabs">
                    <?php foreach( $services_list as $i => $service ) : ?>
                        <li>
                            <button class="our-services__tab-item <?php if ($i === 0) echo 'is-active'; ?>" data-tab="service-about-<?php echo $i; ?>">
                                <?php echo esc_html($service['service_title']); ?>
                                <svg class="our-services__tab-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="our-services__panels">
                    <?php foreach( $services_list as $i => $service ) : 
                        $link = $service['service_link'];
                    ?>
                        <div class="our-services__panel <?php if ($i === 0) echo 'is-active'; ?>" id="service-about-<?php echo $i; ?>">
                            <div class="our-services__panel-description content-styles">
                                <?php echo $service['service_description']; ?>
                            </div>
                            <?php if( $link ): ?>
                                <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ? $link['target'] : '_self'); ?>" class="button button--outline">
                                    <?php echo esc_html($link['title']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>