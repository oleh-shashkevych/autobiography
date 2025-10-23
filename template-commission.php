<?php
/**
 * Template Name: Сторінка Комісійний Продаж
 * Description: Шаблон для сторінки послуги комісійного продажу.
 */

get_header();

// --- Отримуємо дані з ACF ---

// Hero
$hero_image = get_field('commission_hero_image');
$hero_overlay = get_field('commission_hero_overlay');
$hero_style = $hero_image ? 'style="background-image: url(' . esc_url($hero_image) . ');"' : '';
$hero_classes = 'page-hero' . ($hero_image && $hero_overlay ? ' has-overlay' : '');

// Intro
$intro_text = get_field('commission_intro_text');
$intro_button = get_field('commission_intro_button');
$intro_media_url = get_field('commission_intro_media');

// Procedure
$procedure_title = get_field('commission_procedure_title');
$procedure_steps = get_field('commission_procedure_steps');

// What's Included
$included_title = get_field('commission_included_title');
$included_items = get_field('commission_included_items');
$included_note = get_field('commission_included_note');

// Other Ways
$other_ways_title = get_field('commission_other_ways_title');
$other_ways_items = get_field('commission_other_ways_items');

?>

<main id="primary" class="site-main">

    <section class="<?php echo esc_attr($hero_classes); ?>" <?php echo $hero_style; ?>>
        <div class="container">
            <?php autobiography_breadcrumbs(); ?>
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
        </div>
    </section>

    <?php if ($intro_text): ?>
    <section class="page-content">
        <div class="container">
            <div class="commission-intro-grid">
                <div class="commission-intro-grid__media">
                    <?php if ($intro_media_url): ?>
                        <img src="<?php echo esc_url($intro_media_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <?php endif; ?>
                </div>
                <div class="commission-intro-grid__text">
                    <div class="content-styles">
                        <?php echo $intro_text; ?>
                    </div>
                    <?php if ($intro_button): 
                        $link_url = esc_url($intro_button['url']);
                        $link_title = esc_html($intro_button['title']);
                        $link_target = esc_attr($intro_button['target'] ?: '_self');
                    ?>
                    <div class="commission-intro-grid__button-wrapper">
                        <a href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>" class="button button--primary"><?php echo $link_title; ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($procedure_steps): ?>
    <section class="commission-steps">
        <div class="container">
            <?php if ($procedure_title): ?>
                <h2 class="buyback-steps__title"><?php echo esc_html($procedure_title); ?></h2>
            <?php endif; ?>
            <div class="how-we-work__grid">
                <?php foreach ($procedure_steps as $index => $step): ?>
                <div class="how-we-work__item">
                    <div class="how-we-work__item-header">
                        <span class="how-we-work__step-number"><?php echo $index + 1; ?></span>
                    </div>
                    <?php if (!empty($step['title'])): ?>
                        <h3 class="how-we-work__item-title"><?php echo esc_html($step['title']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($step['description'])): ?>
                        <p class="how-we-work__item-description"><?php echo $step['description']; ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($included_items): ?>
    <section class="buyback-criteria commission-included">
        <div class="container">
            <?php if ($included_title): ?>
                <h2 class="buyback-criteria__title"><?php echo esc_html($included_title); ?></h2>
            <?php endif; ?>
            <div class="our-values__grid">
                <?php foreach ($included_items as $item): ?>
                    <div class="our-values__item">
                        <?php if (!empty($item['icon'])): ?>
                            <div class="our-values__icon-wrapper"><?php echo $item['icon']; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($item['text'])): ?>
                            <p class="our-values__item-description"><?php echo $item['text']; ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($included_note): ?>
                <div class="commission-included__note content-styles">
                    <?php echo $included_note; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if ($other_ways_items): ?>
    <section class="commission-other-ways">
        <div class="container">
            <?php if ($other_ways_title): ?>
                <h2 class="commission-other-ways__title"><?php echo esc_html($other_ways_title); ?></h2>
            <?php endif; ?>
            <div class="commission-other-ways__grid">
                <?php foreach ($other_ways_items as $item): 
                    $link = $item['link'];
                ?>
                <div class="other-way-card">
                    <?php if (!empty($item['icon'])): ?>
                        <div class="other-way-card__icon"><?php echo $item['icon']; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($item['title'])): ?>
                        <h3 class="other-way-card__title"><?php echo esc_html($item['title']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($item['description'])): ?>
                        <p class="other-way-card__description"><?php echo $item['description']; ?></p>
                    <?php endif; ?>
                    <?php if ($link): ?>
                        <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>" class="button button--outline">
                            <?php echo esc_html($link['title']); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>