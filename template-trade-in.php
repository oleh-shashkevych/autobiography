<?php
/**
 * Template Name: Сторінка Трейд-ін
 * Description: Шаблон для сторінки послуги Trade-in.
 */

get_header();

// Отримуємо дані для заголовка (hero)
$hero_image = get_field('tradein_hero_image');
$hero_overlay = get_field('tradein_hero_overlay');
$hero_style = $hero_image ? 'style="background-image: url(' . esc_url($hero_image) . ');"' : '';
$hero_classes = 'page-hero' . ($hero_image && $hero_overlay ? ' has-overlay' : '');

// Отримуємо дані для контенту
$main_content = get_field('tradein_main_content');
$steps_title = get_field('tradein_steps_title');
$steps_list = get_field('tradein_steps_list');

// НОВИЙ КОД: Отримуємо дані для галереї
$gallery_title = get_field('tradein_gallery_title');
$gallery_images = get_field('tradein_gallery');

?>

<main id="primary" class="site-main">

    <section class="<?php echo esc_attr($hero_classes); ?>" <?php echo $hero_style; ?>>
        <div class="container">
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
        </div>
    </section>
    
    <?php if ($main_content): ?>
    <section class="page-content">
        <div class="container content-container">
            <div class="content-styles">
                <?php echo $main_content; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($steps_list): ?>
    <section class="trade-in-steps buyback-steps">
        <div class="container">
            <?php if ($steps_title): ?>
                <h2 class="buyback-steps__title"><?php echo esc_html($steps_title); ?></h2>
            <?php endif; ?>
            <div class="how-we-work__grid">
                <?php foreach ($steps_list as $index => $step): ?>
                <div class="how-we-work__item">
                    <?php if (!empty($step['step_icon'])): ?>
                        <div class="how-we-work__item-header">
                            <div class="how-we-work__icon-wrapper"><?php echo $step['step_icon']; ?></div>
                             <span class="how-we-work__step-number"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($step['step_title'])): ?>
                        <h3 class="how-we-work__item-title"><?php echo esc_html($step['step_title']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($step['step_description'])): ?>
                        <p class="how-we-work__item-description"><?php echo esc_html($step['step_description']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php 
    // НОВИЙ КОД: Секція для галереї
    if ( $gallery_images ) :
    ?>
    <section class="our-clients"> <div class="container">
            <?php if ($gallery_title): ?>
                <h2 class="our-clients__title"><?php echo esc_html($gallery_title); ?></h2>
            <?php endif; ?>
            <div class="our-clients__gallery">
                <?php foreach ( $gallery_images as $image ) : ?>
                    <a href="<?php echo esc_url($image['url']); ?>" class="our-clients__gallery-item">
                        <img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy" />
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php 
get_footer(); 
?>