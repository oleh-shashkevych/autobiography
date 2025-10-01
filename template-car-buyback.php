<?php
/**
 * Template Name: Сторінка Викуп Авто
 * Description: Шаблон для сторінки послуги викупу автомобілів.
 */

get_header();

// Отримуємо дані для заголовка
$hero_image = get_field('buyback_hero_image');
$hero_overlay = get_field('buyback_hero_overlay');
$hero_style = $hero_image ? 'style="background-image: url(' . esc_url($hero_image) . ');"' : '';
$hero_classes = 'page-hero' . ($hero_image && $hero_overlay ? ' has-overlay' : '');

// Отримуємо дані для контенту
$seo_content = get_field('buyback_seo_content');
$criteria_title = get_field('buyback_criteria_title');
$criteria_list = get_field('buyback_criteria_list');
$steps_title = get_field('buyback_steps_title');
$steps_list = get_field('buyback_steps_list');
?>

<main id="primary" class="site-main">

    <section class="<?php echo esc_attr($hero_classes); ?>" <?php echo $hero_style; ?>>
        <div class="container">
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
        </div>
    </section>
    
    <?php if ($seo_content): ?>
    <section class="page-content">
        <div class="container content-container">
            <div class="content-styles">
                <?php echo $seo_content; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($criteria_list): ?>
    <section class="buyback-criteria">
        <div class="container">
            <?php if ($criteria_title): ?>
                <h2 class="buyback-criteria__title"><?php echo esc_html($criteria_title); ?></h2>
            <?php endif; ?>
            <div class="our-values__grid">
                <?php foreach ($criteria_list as $item): ?>
                    <div class="our-values__item">
                        <?php if (!empty($item['icon'])): ?>
                            <div class="our-values__icon-wrapper"><?php echo $item['icon']; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($item['title'])): ?>
                            <h3 class="our-values__item-title"><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($item['description'])): ?>
                            <p class="our-values__item-description"><?php echo esc_html($item['description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if ($steps_list): ?>
    <section class="buyback-steps">
        <div class="container">
            <?php if ($steps_title): ?>
                <h2 class="buyback-steps__title"><?php echo esc_html($steps_title); ?></h2>
            <?php endif; ?>
            <div class="how-we-work__grid">
                <?php foreach ($steps_list as $index => $step): ?>
                <div class="how-we-work__item">
                    <div class="how-we-work__item-header">
                        <span class="how-we-work__step-number"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <?php if (!empty($step['title'])): ?>
                        <h3 class="how-we-work__item-title"><?php echo esc_html($step['title']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($step['description'])): ?>
                        <p class="how-we-work__item-description"><?php echo esc_html($step['description']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>