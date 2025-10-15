<?php
get_header();

// Отримуємо дані про авто
$brand = get_the_term_list(get_the_ID(), 'brand', '', ', ');
$model = get_field('car_model');
$year = get_field('car_year');
$price_usd = get_field('price_usd');
$old_price_usd = get_field('old_price_usd');
$gallery = get_field('car_gallery');
$complectation = get_field('complectation');
$action_buttons = get_field('action_buttons');

// Отримуємо курс валют
$rate = get_field('uah_to_usd_rate', 'option');
$price_uah = $rate ? number_format($price_usd * $rate, 0, '', ' ') : null;

// Дані для характеристик з переводом
$specs = array(
    autobiography_translate_string('Тип кузова', 'Body Type')       => get_the_term_list(get_the_ID(), 'body_type', '', ', '),
    autobiography_translate_string('Пробіг', 'Mileage')          => get_field('mileage') ? sprintf(autobiography_translate_string('%s тис. км', '%s k km'), get_field('mileage')) : null,
    autobiography_translate_string('Тип палива', 'Fuel Type')       => get_the_term_list(get_the_ID(), 'fuel_type', '', ', '),
    autobiography_translate_string('Об\'єм двигуна', 'Engine Volume')   => get_field('engine_volume') ? sprintf(autobiography_translate_string('%s л', '%s L'), get_field('engine_volume')) : null,
    autobiography_translate_string('Коробка передач', 'Transmission')  => get_the_term_list(get_the_ID(), 'transmission', '', ', '),
    autobiography_translate_string('Походження', 'Origin')      => get_field('car_origin') ? get_field_object('field_car_origin')['choices'][get_field('car_origin')] : null,
    autobiography_translate_string('VIN-код', 'VIN')         => get_field('vin_code'),
);

// Складна логіка для потужності з переводом
$power_hp = get_field('engine_power_hp');
$power_kw = get_field('engine_power_kw');
$fuel_terms = wp_get_post_terms(get_the_ID(), 'fuel_type', array('fields' => 'slugs'));
$fuel_type_slug = !empty($fuel_terms) ? $fuel_terms[0] : '';
$power_string = '';

if ($fuel_type_slug === 'hybrid' && $power_hp && $power_kw) {
    $power_string = sprintf(autobiography_translate_string('%1$s к.с. (ДВЗ) + %2$s кВт (Електро)', '%1$s hp (ICE) + %2$s kW (Electric)'), $power_hp, $power_kw);
} elseif ($fuel_type_slug === 'electric' && $power_kw) {
    $power_string = sprintf(autobiography_translate_string('%s кВт', '%s kW'), $power_kw);
} elseif ($power_hp) {
    $power_string = sprintf(autobiography_translate_string('%s к.с.', '%s hp'), $power_hp);
}
if ($power_string) {
    $specs[autobiography_translate_string('Потужність', 'Power')] = $power_string;
}
?>

<main id="primary" class="site-main">
    <div class="container single-car-container">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php autobiography_breadcrumbs(); ?>
            <h1 class="single-car__title"><?php echo strip_tags($brand); ?> <?php echo $model; ?>, <?php echo $year; ?></h1>

            <div class="single-car-grid">
                <div class="single-car__gallery">
                    <?php if ($gallery): ?>
                        <div class="swiper swiper-main-gallery">
                            <div class="swiper-wrapper">
                                <?php foreach ($gallery as $image): ?>
                                    <div class="swiper-slide">
                                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                    </div>
                                <?php endforeach; ?>
                            </div>
                             <div class="swiper-button-next"></div>
                             <div class="swiper-button-prev"></div>
                        </div>
                        <div thumbsSlider="" class="swiper swiper-thumb-gallery">
                            <div class="swiper-wrapper">
                                 <?php foreach ($gallery as $image): ?>
                                    <div class="swiper-slide">
                                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php elseif (has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>" class="single-car__main-image-fallback">
                    <?php endif; ?>
                </div>

                <div class="single-car__details">
                    <div class="car-price-block">
                        <div class="car-price--current">
                            <span class="price-usd">$<?php echo number_format_i18n($price_usd, 0); ?></span>
                            <?php if ($price_uah): ?>
                                <span class="price-uah">≈ <?php echo $price_uah; ?> <?php echo esc_html(autobiography_translate_string('грн', 'UAH')); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ($old_price_usd): ?>
                             <span class="car-price--old">$<?php echo number_format_i18n($old_price_usd, 0); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="car-specs-block">
                        <h3 class="car-specs__title"><?php echo esc_html(autobiography_translate_string('Основні характеристики', 'Main Specifications')); ?></h3>
                        <ul class="car-specs__list">
                            <?php foreach ($specs as $label => $value): ?>
                                <?php if (!empty($value)): ?>
                                    <li>
                                        <span class="spec-label"><?php echo esc_html($label); ?></span>
                                        <span class="spec-value"><?php echo strip_tags($value, '<a>'); ?></span>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <?php if ($action_buttons = get_field('action_buttons')): ?>
                    <div class="car-action-buttons">
                        <?php foreach($action_buttons as $button): 
                            // Предполагаем, что текст кнопки может быть зарегистрирован для перевода Polylang
                            $button_text = function_exists('pll__') ? pll__($button['button_text']) : $button['button_text'];
                        ?>
                             <a href="<?php echo esc_attr($button['button_link']); ?>" class="button button--primary"><?php echo esc_html($button_text); ?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="single-car-content">
                <?php if (get_the_content()): ?>
                    <div class="car-description content-styles">
                        <h2><?php echo esc_html(autobiography_translate_string('Опис автомобіля', 'Car Description')); ?></h2>
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($complectation = get_field('complectation')): ?>
                    <div class="car-complectation content-styles">
                        <h2><?php echo esc_html(autobiography_translate_string('Комплектація', 'Features')); ?></h2>
                        <?php echo $complectation; ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>