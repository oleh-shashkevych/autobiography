<?php
get_header();

// Получаем значения из Настроек темы
$catalog_title_option = get_field('catalog_title', 'option');
$catalog_title = $catalog_title_option ? pll__($catalog_title_option) : autobiography_translate_string('Каталог авто в наявності', 'Catalog of available cars');

$sold_cars_title_option = get_field('sold_cars_title', 'option');
$sold_cars_title = $sold_cars_title_option ? pll__($sold_cars_title_option) : autobiography_translate_string('Нещодавно продані авто', 'Recently sold cars');

// НОВЫЙ КОД: Получаем данные для page-hero
$hero_image = get_field('catalog_hero_image', 'option');
$hero_overlay = get_field('catalog_hero_overlay', 'option');
$hero_style = $hero_image ? 'style="background-image: url(' . esc_url($hero_image) . ');"' : '';
$hero_classes = 'page-hero' . ($hero_image && $hero_overlay ? ' has-overlay' : '');


// Получаем данные для фильтров
global $wpdb;
$min_price = $wpdb->get_var("SELECT min(cast(meta_value as unsigned)) FROM $wpdb->postmeta WHERE meta_key = 'price_usd'");
$max_price = $wpdb->get_var("SELECT max(cast(meta_value as unsigned)) FROM $wpdb->postmeta WHERE meta_key = 'price_usd'");
$min_year = $wpdb->get_var("SELECT min(cast(meta_value as unsigned)) FROM $wpdb->postmeta WHERE meta_key = 'car_year'");
$max_year = $wpdb->get_var("SELECT max(cast(meta_value as unsigned)) FROM $wpdb->postmeta WHERE meta_key = 'car_year'");
$models = $wpdb->get_col("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = 'car_model' ORDER BY meta_value ASC");
?>

<main id="primary" class="site-main">

    <section class="<?php echo esc_attr($hero_classes); ?>" <?php echo $hero_style; ?>>
        <div class="container">
            <h1 class="page-hero__title"><?php echo esc_html($catalog_title); ?></h1>
        </div>
    </section>

    <div class="catalog-page-content container">
        <aside class="catalog-filters">
            <form id="car-filters-form">
                <div class="filters-header">
                    <h3><?php echo esc_html(autobiography_translate_string('Фільтри', 'Filters')); ?></h3>
                    <button type="reset" class="reset-filters"><?php echo esc_html(autobiography_translate_string('Скинути', 'Reset')); ?></button>
                </div>
                
                <div class="filter-group">
                    <label for="brand"><?php echo esc_html(autobiography_translate_string('Марка', 'Brand')); ?></label>
                    <select name="brand" id="brand">
                        <option value=""><?php echo esc_html(autobiography_translate_string('Всі марки', 'All brands')); ?></option>
                        <?php $brands = get_terms(array('taxonomy' => 'brand', 'hide_empty' => true));
                        foreach ($brands as $brand) { echo '<option value="' . $brand->slug . '">' . $brand->name . '</option>'; } ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="model"><?php echo esc_html(autobiography_translate_string('Модель', 'Model')); ?></label>
                    <select name="model" id="model">
                        <option value=""><?php echo esc_html(autobiography_translate_string('Всі моделі', 'All models')); ?></option>
                        <?php foreach ($models as $model) { echo '<option value="' . esc_attr($model) . '">' . esc_html($model) . '</option>'; } ?>
                    </select>
                </div>
                
                <div class="filter-group filter-group-range">
                    <label><?php echo esc_html(autobiography_translate_string('Ціна, $', 'Price, $')); ?></label>
                    <div id="price-slider"></div>
                    <div class="range-inputs">
                        <input type="number" name="min_price" id="min_price" min="<?php echo $min_price; ?>" max="<?php echo $max_price; ?>" placeholder="<?php echo esc_attr(autobiography_translate_string('Від', 'From')); ?>">
                        <input type="number" name="max_price" id="max_price" min="<?php echo $min_price; ?>" max="<?php echo $max_price; ?>" placeholder="<?php echo esc_attr(autobiography_translate_string('До', 'To')); ?>">
                    </div>
                </div>

                <div class="filter-group filter-group-range">
                    <label><?php echo esc_html(autobiography_translate_string('Рік випуску', 'Year')); ?></label>
                    <div id="year-slider"></div>
                    <div class="range-inputs">
                        <input type="number" name="min_year" id="min_year" min="<?php echo $min_year; ?>" max="<?php echo $max_year; ?>" placeholder="<?php echo esc_attr(autobiography_translate_string('Від', 'From')); ?>">
                        <input type="number" name="max_year" id="max_year" min="<?php echo $min_year; ?>" max="<?php echo $max_year; ?>" placeholder="<?php echo esc_attr(autobiography_translate_string('До', 'To')); ?>">
                    </div>
                </div>

                <div class="filter-group">
                    <label for="fuel_type"><?php echo esc_html(autobiography_translate_string('Паливо', 'Fuel type')); ?></label>
                    <select name="fuel_type" id="fuel_type">
                        <option value=""><?php echo esc_html(autobiography_translate_string('Всі', 'All')); ?></option>
                        <?php $fuel_types = get_terms(array('taxonomy' => 'fuel_type', 'hide_empty' => true));
                        foreach ($fuel_types as $type) { echo '<option value="' . $type->slug . '">' . $type->name . '</option>'; } ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="transmission"><?php echo esc_html(autobiography_translate_string('Коробка передач', 'Transmission')); ?></label>
                    <select name="transmission" id="transmission">
                        <option value=""><?php echo esc_html(autobiography_translate_string('Всі', 'All')); ?></option>
                        <?php $transmissions = get_terms(array('taxonomy' => 'transmission', 'hide_empty' => true));
                        foreach ($transmissions as $type) { echo '<option value="' . $type->slug . '">' . $type->name . '</option>'; } ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="body_type"><?php echo esc_html(autobiography_translate_string('Тип кузова', 'Body type')); ?></label>
                    <select name="body_type" id="body_type">
                        <option value=""><?php echo esc_html(autobiography_translate_string('Всі', 'All')); ?></option>
                        <?php $body_types = get_terms(array('taxonomy' => 'body_type', 'hide_empty' => true));
                        foreach ($body_types as $type) { echo '<option value="' . $type->slug . '">' . $type->name . '</option>'; } ?>
                    </select>
                </div>

                 <div class="filter-group">
                    <label><?php echo esc_html(autobiography_translate_string('Статус', 'Status')); ?></label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="status" value="available" checked> <?php echo esc_html(autobiography_translate_string('В наявності', 'Available')); ?></label>
                        <label><input type="checkbox" name="status" value="preparing" checked> <?php echo esc_html(autobiography_translate_string('В підготовці', 'Preparing')); ?></label>
                    </div>
                </div>

            </form>
        </aside>

        <div class="catalog-main">
            <div class="catalog-controls">
                <div class="catalog-sort">
                    <label for="sort-by"><?php echo esc_html(autobiography_translate_string('Сортувати:', 'Sort by:')); ?></label>
                    <select name="sort" id="sort-by" form="car-filters-form">
                        <option value=""><?php echo esc_html(autobiography_translate_string('За замовчуванням', 'Default')); ?></option>
                        <option value="price_asc"><?php echo esc_html(autobiography_translate_string('За ціною (зростання)', 'Price (ascending)')); ?></option>
                        <option value="price_desc"><?php echo esc_html(autobiography_translate_string('За ціною (спадання)', 'Price (descending)')); ?></option>
                        <option value="year_desc"><?php echo esc_html(autobiography_translate_string('За роком (новіші)', 'Year (newest)')); ?></option>
                    </select>
                </div>
                <div class="catalog-view-switcher">
                    <button class="view-btn is-active" data-view="grid" aria-label="<?php echo esc_attr(autobiography_translate_string('Плитка', 'Grid')); ?>">
                        <svg viewBox="0 0 24 24"><path d="M3,3H11V11H3V3M5,5V9H9V5H5M13,3H21V11H13V3M15,5V9H19V5H15M3,13H11V21H3V13M5,15V19H9V15H5M13,13H21V21H13V13M15,15V19H19V15H15Z"/></svg>
                    </button>
                    <button class="view-btn" data-view="list" aria-label="<?php echo esc_attr(autobiography_translate_string('Список', 'List')); ?>">
                        <svg viewBox="0 0 24 24"><path d="M3,4H21V6H3V4M3,11H21V13H3V11M3,18H21V20H3V18Z" /></svg>
                    </button>
                </div>
            </div>

            <div id="car-listings-container" class="car-listings-grid view-grid">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part('template-parts/content', 'car-card'); ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p class="no-cars-found"><?php echo esc_html(autobiography_translate_string('На жаль, автомобілів не знайдено.', 'Sorry, no cars were found.')); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="catalog-pagination">
                <?php the_posts_pagination(array( 'prev_text' => '&larr;', 'next_text' => '&rarr;' )); ?>
            </div>
        </div>
    </div>
    
    <?php 
    $seo_text_from_db = get_field('catalog_seo_text', 'option');
    if ($seo_text_from_db): 
        $seo_text_content = pll__($seo_text_from_db);
    ?>
    <section class="catalog-seo-text">
        <div class="container content-styles">
            <?php echo wpautop($seo_text_content); ?>
        </div>
    </section>
    <?php endif; ?>

    <?php 
    $sold_cars = new WP_Query(array( 'post_type' => 'car', 'posts_per_page' => 4, 'meta_query' => array(array('key' => 'car_status', 'value' => 'sold', 'compare' => '=')), ));
    if ($sold_cars->have_posts()):
    ?>
    <section class="sold-cars-section">
        <div class="container">
            <h2 class="sold-cars__title"><?php echo esc_html($sold_cars_title); ?></h2>
            <div class="available-cars__grid">
                <?php while ($sold_cars->have_posts()): $sold_cars->the_post(); ?>
                    <?php get_template_part('template-parts/content', 'car-card'); ?>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>