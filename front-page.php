<?php
get_header();
?>

<main id="primary" class="site-main">
    <?php 
    $slides = get_field('hero_slider');
    $hero_form_shortcode = get_field('hero_form_shortcode');

    if( $slides ): 
    ?>
    <section class="hero">
        <div class="swiper hero-slider">
            <div class="swiper-wrapper">
                <?php foreach( $slides as $slide ): 
                    $bg_type = $slide['background_type'];
                    $bg_image = $slide['image'];
                    $bg_video = $slide['video'];
                ?>
                <div class="swiper-slide hero-slide">
                    <div class="hero-slide__background">
                        <?php if ($bg_type == 'image' && $bg_image): ?>
                            <img src="<?php echo esc_url($bg_image); ?>" alt="Фон слайда">
                        <?php elseif ($bg_type == 'video' && $bg_video): ?>
                            <video src="<?php echo esc_url($bg_video); ?>" autoplay muted loop playsinline></video>
                        <?php endif; ?>
                    </div>
                    <div class="hero-slide__overlay"></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="hero__content-overlay container">
            <div class="hero-form">
                <?php if ($hero_form_shortcode) {
                    echo do_shortcode($hero_form_shortcode);
                } ?>
            </div>
        </div>

        <div class="hero__navigation">
            <div class="swiper-button-prev">
                <svg class="hero-arrow-icon" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M441.749,240.917L207.082,6.251C203.093,2.24,197.674,0,191.999,0H85.333c-8.619,0-16.427,5.184-19.712,13.163 c-3.307,7.979-1.472,17.152,4.629,23.253L289.834,256L70.25,475.584c-6.101,6.101-7.936,15.275-4.629,23.253 C68.906,506.816,76.714,512,85.333,512H192c5.675,0,11.093-2.24,15.083-6.251L441.75,271.082 C450.09,262.741,450.09,249.259,441.749,240.917z"/></svg>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next">
                <svg class="hero-arrow-icon" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M441.749,240.917L207.082,6.251C203.093,2.24,197.674,0,191.999,0H85.333c-8.619,0-16.427,5.184-19.712,13.163 c-3.307,7.979-1.472,17.152,4.629,23.253L289.834,256L70.25,475.584c-6.101,6.101-7.936,15.275-4.629,23.253 C68.906,506.816,76.714,512,85.333,512H192c5.675,0,11.093-2.24,15.083-6.251L441.75,271.082 C450.09,262.741,450.09,249.259,441.749,240.917z"/></svg>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    $how_we_work_title = get_field('how_we_work_title');
    $how_we_work_steps = get_field('how_we_work_steps');
    if( $how_we_work_steps ):
    ?>
    <section class="how-we-work">
        <div class="container">
            <?php if ($how_we_work_title): ?>
                <h2 class="how-we-work__title"><?php echo esc_html($how_we_work_title); ?></h2>
            <?php endif; ?>
            <div class="how-we-work__grid">
                <?php foreach( $how_we_work_steps as $index => $step ): ?>
                <div class="how-we-work__item">
                    <div class="how-we-work__item-header">
                        <?php if ($step['step_icon']): ?><div class="how-we-work__icon-wrapper"><?php echo $step['step_icon']; ?></div><?php endif; ?>
                        <span class="how-we-work__step-number"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <?php if ($step['step_title']): ?><h3 class="how-we-work__item-title"><?php echo esc_html($step['step_title']); ?></h3><?php endif; ?>
                    <?php if ($step['step_description']): ?><p class="how-we-work__item-description"><?php echo esc_html($step['step_description']); ?></p><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    $available_cars_title = get_field('fp_available_cars_title');
    $available_cars_button_text = get_field('fp_available_cars_button_text');

    $cars_query = new WP_Query( array('post_type' => 'car', 'posts_per_page' => 4, 'meta_query' => array(array('key' => 'car_status', 'value' => 'available'))));
    if ( $cars_query->have_posts() ) :
    ?>
    <section class="available-cars">
        <div class="container">
            <h2 class="available-cars__title"><?php echo esc_html($available_cars_title); ?></h2>
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
                                <?php if ($mileage = get_field('mileage')) : ?><div class="car-card__pill"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v3m0 16v3M4.22 4.22l2.12 2.12m11.32 11.32l2.12 2.12M1 12h3m16 0h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12"></path><circle cx="12" cy="12" r="5"></circle></svg><span>
                                    <?php 
                                    // Перевіряємо поточну мову
                                    if (pll_current_language('slug') === 'uk') {
                                        echo esc_html($mileage) . ' тис. км';
                                    } else {
                                        echo esc_html($mileage) . ' thousand km';
                                    }
                                    ?>
                                </span></div><?php endif; ?>
                                <?php if ($fuel_type = get_the_term_list(get_the_ID(), 'fuel_type', '', ', ')) : ?><div class="car-card__pill"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 8h.01M10 8h.01M16 4.1C16 2.94 15.06 2 14 2H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h1c1.1 0 2-.9 2-2v-2h4v2c0 1.1.9 2 2 2h1c1.1 0 2-.9 2-2V8c0-2.2-1.8-4-4-4z"></path></svg><span><?php echo strip_tags($fuel_type); ?></span></div><?php endif; ?>
                                <?php if ($transmission = get_the_term_list(get_the_ID(), 'transmission', '', ', ')) : ?><div class="car-card__pill"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0m1-8a8 8 0 1 0 16 0a8 8 0 1 0-16 0m-9 8h2m18 0h-2m-9-9V1m0 22v-2"></path></svg><span><?php echo strip_tags($transmission); ?></span></div><?php endif; ?>
                                <?php if ($engine_volume = get_field('engine_volume')) : ?><div class="car-card__pill"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12v5m3.24-2.76L13.5 13.5M12 22a9.96 9.96 0 0 1-5-1.46m5 1.46a9.96 9.96 0 0 0 5-1.46M9 12a3 3 0 1 0 6 0 3 3 0 1 0-6 0m4.5 1.5.76.76M12 2v2.5m-1.5-.5L12 6l1.5-1.5"></path></svg><span>
                                    <?php 
                                    // Перевіряємо поточну мову
                                    if (pll_current_language('slug') === 'uk') {
                                        echo esc_html($engine_volume) . ' л';
                                    } else {
                                        echo esc_html($engine_volume) . ' L';
                                    }
                                    ?>
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
            <div class="available-cars__footer">
                <a href="<?php echo get_post_type_archive_link( 'car' ); ?>" class="button button--primary"><?php echo esc_html($available_cars_button_text); ?></a>
            </div>
        </div>
    </section>
    <?php endif; wp_reset_postdata(); ?>

    <?php
    $values_title = get_field('our_values_title');
    $values_subtitle = get_field('our_values_subtitle');
    $values_list  = get_field('our_values_list');
    $values_seo_content = get_field('our_values_seo_content');
    if ( $values_list ) :
    ?>
    <section class="our-values">
        <div class="container">
            <?php if ( $values_title ) : ?>
                <h2 class="our-values__title"><?php echo esc_html($values_title); ?></h2>
            <?php endif; ?>
            <?php if ( $values_subtitle ) : ?>
                <p class="our-values__subtitle"><?php echo esc_html($values_subtitle); ?></p>
            <?php endif; ?>
            
            <div class="our-values__grid">
                <?php foreach( $values_list as $value ) : ?>
                    <div class="our-values__item">
                        <?php if ( !empty($value['value_icon']) ) : ?><div class="our-values__icon-wrapper"><?php echo $value['value_icon']; ?></div><?php endif; ?>
                        <?php if ( !empty($value['value_title']) ) : ?><h3 class="our-values__item-title"><?php echo esc_html($value['value_title']); ?></h3><?php endif; ?>
                        <?php if ( !empty($value['value_description']) ) : ?><p class="our-values__item-description"><?php echo esc_html($value['value_description']); ?></p><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ( $values_seo_content ) : ?>
                <div class="our-values__seo-content content-styles">
                    <?php echo $values_seo_content; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    if ( $clients_gallery = get_field('our_clients_gallery') ) :
    ?>
    <section class="our-clients">
        <div class="container">
            <?php if ($title = get_field('our_clients_title')): ?><h2 class="our-clients__title"><?php echo esc_html($title); ?></h2><?php endif; ?>
            <div class="our-clients__gallery">
                <?php foreach ( $clients_gallery as $image ) : ?>
                    <a href="<?php echo esc_url($image['url']); ?>" class="our-clients__gallery-item">
                        <img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="lazy" />
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // НОВА СЕКЦІЯ "НАШІ ПОСЛУГИ"
    $services_title = get_field('services_section_title');
    $services_list = get_field('our_services_list');
    if ( $services_list ) :
    ?>
    <section class="our-services">
        <div class="container">
            <?php if ( $services_title ) : ?>
                <h2 class="our-services__title"><?php echo esc_html($services_title); ?></h2>
            <?php endif; ?>

            <div class="our-services__content-wrapper">
                <ul class="our-services__tabs">
                    <?php foreach( $services_list as $i => $service ) : ?>
                        <li>
                            <button class="our-services__tab-item <?php if ($i === 0) echo 'is-active'; ?>" data-tab="service-<?php echo $i; ?>">
                                <?php echo esc_html($service['service_title']); ?>
                                <svg class="our-services__tab-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="our-services__panels">
                    <?php foreach( $services_list as $i => $service ) : 
                        $link = $service['service_link'];
                    ?>
                        <div class="our-services__panel <?php if ($i === 0) echo 'is-active'; ?>" id="service-<?php echo $i; ?>">
                            <div class="our-services__panel-description content-styles">
                                <?php echo $service['service_description']; ?>
                            </div>
                            <?php if( $link ): ?>
                                <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ? $link['target'] : '_self'); ?>" class="button button--outline">
                                    <?php echo esc_html($link['title']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php
get_footer();