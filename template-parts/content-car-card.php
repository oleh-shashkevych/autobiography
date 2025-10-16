<?php
// Получаем данные об авто
$brand = get_the_term_list(get_the_ID(), 'brand', '', ', ');
$model = get_field('car_model');
$year = get_field('car_year');
$price_usd = get_field('price_usd');
$old_price_usd = get_field('old_price_usd');
$status_slug = get_field('car_status');
$status_info = get_car_status_info($status_slug);

$category_slug = get_field('car_category');
$category_info = get_car_category_info($category_slug);

$image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : get_template_directory_uri() . '/assets/images/placeholder.png';
?>

<div class="car-card">
    <div class="car-card__image-wrapper">
        <a href="<?php the_permalink(); ?>" class="car-card__image-link">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(strip_tags($brand) . ' ' . $model); ?>" loading="lazy">
        </a>
        
        <?php if ($status_info): ?>
            <div class="car-card__status-badge status--<?php echo esc_attr($status_info['class']); ?>">
                <?php echo esc_html($status_info['label']); ?>
            </div>
        <?php endif; ?>

        <?php if ($category_info): ?>
            <div class="car-card__category-badge category--<?php echo esc_attr($category_info['class']); ?>">
                <?php echo esc_html($category_info['label']); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="car-card__content">
        <h3 class="car-card__title"><a href="<?php the_permalink(); ?>"><?php echo strip_tags($brand); ?> <?php echo $model; ?>, <?php echo $year; ?></a></h3>
        
        <div class="car-card__pills">
            <?php if ($mileage = get_field('mileage')) : ?>
            <div class="car-card__pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v3m0 16v3M4.22 4.22l2.12 2.12m11.32 11.32l2.12 2.12M1 12h3m16 0h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12"></path><circle cx="12" cy="12" r="5"></circle></svg>
                <span><?php printf(esc_html(autobiography_translate_string('%s тис. км', '%s k km')), number_format_i18n($mileage)); ?></span>
            </div>
            <?php endif; ?>

            <?php if ($fuel_type = get_the_term_list(get_the_ID(), 'fuel_type', '', ', ')) : ?>
            <div class="car-card__pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 8h.01M10 8h.01M16 4.1C16 2.94 15.06 2 14 2H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h1c1.1 0 2-.9 2-2v-2h4v2c0 1.1.9 2 2 2h1c1.1 0 2-.9 2-2V8c0-2.2-1.8-4-4-4z"></path></svg>
                <span><?php echo strip_tags($fuel_type); ?></span>
            </div>
            <?php endif; ?>

            <?php if ($transmission = get_the_term_list(get_the_ID(), 'transmission', '', ', ')) : ?>
            <div class="car-card__pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0m1-8a8 8 0 1 0 16 0a8 8 0 1 0-16 0m-9 8h2m18 0h-2m-9-9V1m0 22v-2"></path></svg>
                <span><?php echo strip_tags($transmission); ?></span>
            </div>
            <?php endif; ?>

            <?php if ($engine_volume = get_field('engine_volume')) : ?>
            <div class="car-card__pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12v5m3.24-2.76L13.5 13.5M12 22a9.96 9.96 0 0 1-5-1.46m5 1.46a9.96 9.96 0 0 0 5-1.46M9 12a3 3 0 1 0 6 0 3 3 0 1 0-6 0m4.5 1.5.76.76M12 2v2.5m-1.5-.5L12 6l1.5-1.5"></path></svg>
                <span><?php printf(esc_html(autobiography_translate_string('%s л', '%s L')), esc_html($engine_volume)); ?></span>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="car-card__footer">
            <?php if ($price_usd): ?>
                <div class="car-card__price-block">
                    <?php if ($old_price_usd): ?>
                        <span class="car-card__price--old">$<?php echo number_format_i18n($old_price_usd, 0); ?></span>
                    <?php endif; ?>
                    <span class="car-card__price--current">$<?php echo number_format_i18n($price_usd, 0); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>