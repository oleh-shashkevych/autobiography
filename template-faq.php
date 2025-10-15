<?php
/**
 * Template Name: Сторінка FAQ
 * Description: Шаблон для сторінки з питаннями та відповідями.
 */

get_header();

// Отримуємо дані для Hero
$hero_image = get_field('faq_hero_image');
$hero_overlay = get_field('faq_hero_overlay');
$hero_style = $hero_image ? 'style="background-image: url(' . esc_url($hero_image) . ');"' : '';
$hero_classes = 'page-hero' . ($hero_image && $hero_overlay ? ' has-overlay' : '');

// Отримуємо дані для контенту
$faq_list = get_field('faq_list');
$seo_content = get_field('faq_seo_content');
?>

<main id="primary" class="site-main">

    <section class="<?php echo esc_attr($hero_classes); ?>" <?php echo $hero_style; ?>>
        <div class="container">
            <?php autobiography_breadcrumbs(); ?>
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
        </div>
    </section>
    
    <?php if ($faq_list): ?>
    <section class="faq-section">
        <div class="container content-container">
            <div class="faq-accordion">
                <?php foreach($faq_list as $item): ?>
                    <div class="faq-item">
                        <button class="faq-question">
                            <span><?php echo esc_html($item['question']); ?></span>
                            <span class="faq-icon"></span>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer__content content-styles">
                                <?php echo $item['answer']; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($seo_content): ?>
    <section class="page-content" style="border-top: 1px solid var(--border-color);">
        <div class="container content-container">
            <div class="content-styles">
                <?php echo $seo_content; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>