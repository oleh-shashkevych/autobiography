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
            <?php autobiography_breadcrumbs(); ?>
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
        </div>
    </section>
    
    <?php
    // Отримуємо дані для всіх частин
    $main_content = get_field('tradein_main_content');
    $popup_button = get_field('tradein_popup_button');
    $secondary_content = get_field('tradein_secondary_content');

    // Нові дані для медіа
    $media_type = get_field('tradein_media_type');
    $content_image = get_field('tradein_content_image');
    $content_video = get_field('tradein_content_video');

    // Виводимо секцію, тільки якщо є хоча б перший блок тексту
    if ($main_content):
    ?>
    <section class="page-content">
        <div class="container">
            <div class="tradein-content-grid">
                <div class="tradein-content-grid__text">
                    <div class="content-styles">
                        <?php echo $main_content; ?>
                    </div>

                    <?php 
                    if ($popup_button): 
                        $link_url = esc_url($popup_button['url']);
                        $link_title = esc_html($popup_button['title']);
                        $link_target = esc_attr($popup_button['target'] ? $popup_button['target'] : '_self');
                    ?>
                    <div class="tradein-button-wrapper">
                        <a href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>" class="button button--primary">
                            <?php echo $link_title; ?>
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if ($secondary_content): ?>
                    <div class="content-styles">
                        <?php echo $secondary_content; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if ($content_image || $content_video): ?>
                <div class="tradein-content-grid__media">
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
                            <span class="how-we-work__step-number"><?php echo $index + 1; ?></span>
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
    // Отримуємо кастомні заголовок та текст кнопки для цієї сторінки
    $available_cars_title = get_field('tradein_cars_title') ?: autobiography_translate_string('Автомобілі для обміну', 'Cars for trade-in');
    $available_cars_button_text = get_field('tradein_cars_button_text') ?: autobiography_translate_string('Переглянути всі авто', 'View all cars');

    // Запит до бази даних залишається таким самим
    $cars_query = new WP_Query( array('post_type' => 'car', 'posts_per_page' => 4, 'meta_query' => array(array('key' => 'car_status', 'value' => 'available'))));
    if ( $cars_query->have_posts() ) :
    ?>
    <section class="available-cars">
        <div class="container">
            <h2 class="available-cars__title"><?php echo esc_html($available_cars_title); ?></h2>
        </div>
        <div class="available-cars__grid">
            <?php while ( $cars_query->have_posts() ) : $cars_query->the_post(); 
                $brand = get_the_term_list(get_the_ID(), 'brand', '', ', ');
                $model = get_field('car_model');
                $year = get_field('car_year');
            ?>
                <div class="car-card">
                    <a href="<?php the_permalink(); ?>" class="car-card__image-link">
                        <?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?>
                    </a>
                    <div class="car-card__content">
                        <h3 class="car-card__title"><a href="<?php the_permalink(); ?>"><?php echo strip_tags($brand); ?> <?php echo $model; ?>, <?php echo $year; ?></a></h3>
                        <div class="car-card__pills">
                            <?php if ($mileage = get_field('mileage')) : ?><div class="car-card__pill"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" xml:space="preserve" fill="currentColor"><path d="M256,0C114.62,0,0,114.611,0,256c0,141.38,114.62,256,256,256s256-114.62,256-256C512,114.611,397.38,0,256,0z M256,486.4 C128.956,486.4,25.6,383.044,25.6,256S128.956,25.6,256,25.6S486.4,128.956,486.4,256S383.044,486.4,256,486.4z"></path><path d="M256,76.8c-98.97,0-179.2,80.23-179.2,179.2S157.03,435.2,256,435.2S435.2,354.97,435.2,256S354.97,76.8,256,76.8z M268.8,103.049c58.078,4.821,107.102,41.993,128.811,93.483l-111.283,36.156c-4.463-5.803-10.496-10.24-17.528-12.74V103.049z M256,243.2c7.057,0,12.8,5.743,12.8,12.8s-5.743,12.8-12.8,12.8s-12.8-5.743-12.8-12.8S248.943,243.2,256,243.2z M243.2,103.049 v116.898c-7.023,2.5-13.056,6.946-17.527,12.74l-111.283-36.156C136.098,145.041,185.122,107.87,243.2,103.049z M102.4,256 c0-12.083,1.544-23.791,4.198-35.081l111.104,36.096c0.205,7.689,2.603,14.814,6.682,20.727l-68.599,94.404 C123.162,343.962,102.4,302.396,102.4,256z M256,409.6c-29.116,0-56.269-8.294-79.497-22.426l68.676-94.515 c3.456,1.024,7.04,1.741,10.82,1.741c3.789,0,7.373-0.717,10.829-1.741l68.668,94.515C312.269,401.306,285.116,409.6,256,409.6z M356.207,372.147l-68.591-94.413c4.079-5.914,6.468-13.039,6.673-20.727l111.104-36.096c2.662,11.298,4.207,23.006,4.207,35.089 C409.6,302.396,388.838,343.962,356.207,372.147z"></path></svg><span>
                                <?php echo esc_html($mileage) . (pll_current_language('slug') === 'uk' ? ' тис. км' : ' thousand km'); ?>
                            </span></div><?php endif; ?>
                            <?php if ($transmission = get_the_term_list(get_the_ID(), 'transmission', '', ', ')) : ?><div class="car-card__pill"><svg fill="currentColor" viewBox="0 0 512 512" xml:space="preserve"><path d="M256,0C114.62,0,0,114.611,0,256c0,141.38,114.62,256,256,256c141.389,0,256-114.62,256-256C512,114.611,397.389,0,256,0z M256,486.4C128.956,486.4,25.6,383.044,25.6,256S128.956,25.6,256,25.6S486.4,128.956,486.4,256S383.044,486.4,256,486.4z"></path><path d="M371.2,128v115.2h-59.733V128h-25.6v115.2h-59.733V128h-25.6v115.2H140.8V128h-25.6v128c0,7.074,5.726,12.8,12.8,12.8 h72.533V384h25.6V268.8h59.733V384h25.6V268.8H371.2V384h25.6V128H371.2z"></path></svg><span><?php echo strip_tags($transmission); ?></span></div><?php endif; ?>
                            <?php if ($fuel_type = get_the_term_list(get_the_ID(), 'fuel_type', '', ', ')) : ?><div class="car-card__pill"><svg fill="currentColor" viewBox="0 0 512 512" xml:space="preserve"><path d="M407.403,179.2l33.101-33.101c10.001-10.001,10.001-26.206,0-36.207l-25.6-25.6c-5.009-4.992-11.554-7.492-18.108-7.492 c-6.554,0-13.107,2.5-18.099,7.501l-33.101,33.092l-33.101-33.101c-4.796-4.796-11.307-7.492-18.099-7.492h-25.6V25.6 c0-14.14-11.46-25.6-25.6-25.6h-102.4c-14.14,0-25.6,11.46-25.6,25.6v51.2h-25.6c-14.14,0-25.6,11.46-25.6,25.6v384 c0,14.14,11.46,25.6,25.6,25.6h332.8c14.14,0,25.6-11.46,25.6-25.6v-256c0-6.793-2.697-13.303-7.501-18.099L407.403,179.2z M396.796,102.4l25.6,25.6l-33.101,33.101l-25.6-25.6L396.796,102.4z M140.796,25.6h102.4v51.2h-102.4V25.6z M422.396,486.4 h-332.8v-384h204.8l128,128V486.4z"></path><path d="M378.296,424.55l-58.3-38.869V250.121l34.85-36.48c4.898-5.112,4.702-13.21-0.401-18.091 c-5.154-4.89-13.252-4.676-18.099,0.41L303.45,230.4h-90.505l-61.824-84.361c-4.198-5.734-12.177-6.946-17.903-2.765 c-5.7,4.173-6.929,12.186-2.748,17.886l61.525,83.959v140.57l-58.3,38.869c-5.871,3.925-7.475,11.861-3.55,17.749 c2.475,3.703,6.528,5.7,10.65,5.7c2.449,0,4.924-0.7,7.1-2.15L202.27,409.6h107.452l54.374,36.25c2.176,1.451,4.651,2.15,7.1,2.15 c4.122,0,8.175-1.997,10.65-5.7C385.771,436.412,384.166,428.476,378.296,424.55z M294.396,384h-76.8V256h76.8V384z"></path></svg><span><?php echo strip_tags($fuel_type); ?></span></div><?php endif; ?>
                            <?php if ($engine_volume = get_field('engine_volume')) : ?><div class="car-card__pill"><svg fill="currentColor" viewBox="0 0 512 512" xml:space="preserve"><path d="M486.4,256V153.6c0-14.14-11.46-25.6-25.6-25.6H243.2v-25.6H320c7.074,0,12.8-5.726,12.8-12.8 c0-7.074-5.726-12.8-12.8-12.8H140.8c-7.074,0-12.8,5.726-12.8,12.8c0,7.074,5.726,12.8,12.8,12.8h76.8V128H76.8 c-14.14,0-25.6,11.46-25.6,25.6v89.6H25.6v-76.8c0-7.074-5.726-12.8-12.8-12.8c-7.074,0-12.8,5.726-12.8,12.8v179.2 c0,7.074,5.726,12.8,12.8,12.8c7.074,0,12.8-5.726,12.8-12.8v-76.8h25.6v89.6c0,14.14,11.46,25.6,25.6,25.6h91.793l43.699,43.699 c4.804,4.804,11.315,7.501,18.108,7.501h256c14.14,0,25.6-11.46,25.6-25.6v-128C512,267.46,500.54,256,486.4,256z M486.4,409.6 h-256l-51.2-51.2H76.8V153.6h384v128h25.6V409.6z"></path><path d="M140.8,179.2c-21.171,0-38.4,17.229-38.4,38.4s17.229,38.4,38.4,38.4s38.4-17.229,38.4-38.4 C179.2,196.429,161.971,179.2,140.8,179.2z M140.8,230.4c-7.066,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 c7.066,0,12.8,5.726,12.8,12.8C153.6,224.666,147.866,230.4,140.8,230.4z"></path><path d="M226.133,179.2c-21.171,0-38.4,17.229-38.4,38.4c0,21.171,17.229,38.4,38.4,38.4s38.4-17.229,38.4-38.4 C264.533,196.429,247.305,179.2,226.133,179.2z M226.133,230.4c-7.066,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 c7.074,0,12.8,5.726,12.8,12.8C238.933,224.666,233.207,230.4,226.133,230.4z"></path><path d="M311.467,179.2c-21.171,0-38.4,17.229-38.4,38.4s17.229,38.4,38.4,38.4s38.4-17.229,38.4-38.4 C349.867,196.429,332.638,179.2,311.467,179.2z M311.467,230.4c-7.074,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 s12.8,5.726,12.8,12.8C324.267,224.666,318.532,230.4,311.467,230.4z"></path><path d="M396.8,179.2c-21.171,0-38.4,17.229-38.4,38.4s17.229,38.4,38.4,38.4c21.171,0,38.4-17.229,38.4-38.4 C435.2,196.429,417.971,179.2,396.8,179.2z M396.8,230.4c-7.066,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 c7.066,0,12.8,5.726,12.8,12.8C409.6,224.666,403.866,230.4,396.8,230.4z"></path><rect x="102.4" y="307.2" width="358.4" height="25.6"></rect><circle cx="448" cy="371.2" r="12.8"></circle><circle cx="396.8" cy="371.2" r="12.8"></circle><circle cx="345.6" cy="371.2" r="12.8"></circle><circle cx="294.4" cy="371.2" r="12.8"></circle><circle cx="243.2" cy="371.2" r="12.8"></circle></svg><span>
                                <?php echo esc_html($engine_volume) . (pll_current_language('slug') === 'uk' ? ' л' : ' L'); ?>
                            </span></div><?php endif; ?>
                        </div>
                        <div class="car-card__footer">
                            <?php if ($price_usd = get_field('price_usd')) : ?>
                            <div class="car-card__price-block">
                                <?php if ($old_price_usd = get_field('old_price_usd')) : ?><span class="car-card__price--old">$<?php echo number_format($old_price_usd, 0, '', ' '); ?></span><?php endif; ?>
                                <span class="car-card__price--current">$<?php echo number_format($price_usd, 0, '', ' '); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="container">
            <div class="available-cars__footer">
                <a href="<?php echo get_post_type_archive_link( 'car' ); ?>" class="button button--primary"><?php echo esc_html($available_cars_button_text); ?></a>
            </div>
        </div>
    </section>
    <?php endif; wp_reset_postdata(); ?>

</main>

<?php 
get_footer(); 
?>