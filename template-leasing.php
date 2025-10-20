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
            <?php autobiography_breadcrumbs(); ?>
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

    <?php
    // Отримуємо кастомні заголовок та текст кнопки для сторінки лізингу
    $available_cars_title = get_field('leasing_cars_title') ?: autobiography_translate_string('Автомобілі доступні в лізинг', 'Cars available for lease');
    $available_cars_button_text = get_field('leasing_cars_button_text') ?: autobiography_translate_string('Переглянути всі авто', 'View all cars');

    // Запит до бази даних для отримання 4-х авто зі статусом "В наявності"
    $cars_query = new WP_Query( array('post_type' => 'car', 'posts_per_page' => 4, 'meta_query' => array(array('key' => 'car_status', 'value' => 'available'))));
    if ( $cars_query->have_posts() ) :
    ?>
    <section class="available-cars" style="border-top: 1px solid var(--border-color);">
        <div class="container">
            <h2 class="available-cars__title"><?php echo esc_html($available_cars_title); ?></h2>
        </div>
        <div class="available-cars__grid">
            <?php while ( $cars_query->have_posts() ) : $cars_query->the_post(); ?>
                <?php get_template_part('template-parts/content', 'car-card'); ?>
            <?php endwhile; ?>
        </div>
        <div class="container">
            <div class="available-cars__footer">
                <a href="<?php echo get_post_type_archive_link( 'car' ); ?>" class="button button--primary"><?php echo esc_html($available_cars_button_text); ?></a>
            </div>
        </div>
    </section>
    <?php endif; wp_reset_postdata(); ?>

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