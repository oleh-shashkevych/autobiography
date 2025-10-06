<?php
/**
 * Template Name: Сторінка Лізинг
 * Description: Шаблон для сторінки послуги лізингу.
 */

get_header();

// Отримуємо дані для заголовка (hero)
$hero_image = get_field('leasing_hero_image');
$hero_overlay = get_field('leasing_hero_overlay');
$hero_style = $hero_image ? 'style="background-image: url(' . esc_url($hero_image) . ');"' : '';
$hero_classes = 'page-hero' . ($hero_image && $hero_overlay ? ' has-overlay' : '');

// Отримуємо дані для контенту
$main_content = get_field('leasing_main_content');

// Отримуємо дані для секції переваг
$benefits_title = get_field('leasing_benefits_title');
$benefits_list = get_field('leasing_benefits_list');
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

    <?php if ($benefits_list): ?>
    <section class="our-values"> <div class="container">
            <?php if ($benefits_title): ?>
                <h2 class="our-values__title"><?php echo esc_html($benefits_title); ?></h2>
            <?php endif; ?>
            <div class="our-values__grid">
                <?php foreach ($benefits_list as $benefit): ?>
                    <div class="our-values__item">
                        <?php if (!empty($benefit['benefit_icon'])): ?>
                            <div class="our-values__icon-wrapper"><?php echo $benefit['benefit_icon']; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($benefit['benefit_title'])): ?>
                            <h3 class="our-values__item-title"><?php echo esc_html($benefit['benefit_title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($benefit['benefit_description'])): ?>
                            <p class="our-values__item-description"><?php echo esc_html($benefit['benefit_description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php 
get_footer(); 
?>