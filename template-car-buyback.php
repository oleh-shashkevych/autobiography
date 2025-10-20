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
            <?php autobiography_breadcrumbs(); ?>
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
        </div>
    </section>
    
    <?php
    // Получаем все данные для новой секции
    $main_content = get_field('buyback_seo_content');
    $popup_button = get_field('buyback_popup_button');
    $media_type = get_field('buyback_media_type');
    $content_image = get_field('buyback_content_image');
    $content_video = get_field('buyback_content_video');

    // Показываем секцию только если есть основной контент
    if ($main_content):
    ?>
    <section class="page-content">
        <div class="container">
            <div class="buyback-content-grid">
                <div class="buyback-content-grid__text">
                    <div class="content-styles">
                        <?php echo $main_content; ?>
                    </div>

                    <?php 
                    // Выводим кнопку, если она есть
                    if ($popup_button): 
                        $link_url = esc_url($popup_button['url']);
                        $link_title = esc_html($popup_button['title']);
                        $link_target = esc_attr($popup_button['target'] ? $popup_button['target'] : '_self');
                    ?>
                    <div class="buyback-content-grid__button-wrapper">
                        <a href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>" class="button button--primary">
                            <?php echo $link_title; ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php 
                // Проверяем, есть ли медиа для правой колонки
                if ($content_image || $content_video):
                ?>
                <div class="buyback-content-grid__media">
                    <?php if ($media_type == 'image' && $content_image): ?>
                        <img src="<?php echo esc_url($content_image); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php elseif ($media_type == 'video' && $content_video): ?>
                        <video src="<?php echo esc_url($content_video); ?>" autoplay loop muted playsinline></video>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
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
                        <?php // Выводим иконку, если она есть ?>
                        <?php if (!empty($step['icon'])): ?>
                            <div class="how-we-work__icon-wrapper"><?php echo $step['icon']; ?></div>
                        <?php endif; ?>
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
            
            <?php 
            $steps_content = get_field('buyback_steps_content');
            if ($steps_content):
            ?>
            <div class="buyback-steps__content content-styles">
                <?php echo $steps_content; ?>
            </div>
            <?php endif; ?>
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
            <?php 
            $criteria_content = get_field('buyback_criteria_content');
            if ($criteria_content):
            ?>
            <div class="buyback-criteria__content content-styles">
                <?php echo $criteria_content; ?>
            </div>
            <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>