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
                <?php foreach( $how_we_work_steps as $index => $step ): 
                    $step_icon        = $step['step_icon'];
                    $step_title       = $step['step_title'];
                    $step_description = $step['step_description'];
                ?>
                <div class="how-we-work__item">
                    <div class="how-we-work__item-header">
                        <?php if ($step_icon): ?>
                            <div class="how-we-work__icon-wrapper">
                                <?php echo $step_icon; // Выводим SVG как есть ?>
                            </div>
                        <?php endif; ?>
                        <span class="how-we-work__step-number"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <?php if ($step_title): ?>
                        <h3 class="how-we-work__item-title"><?php echo esc_html($step_title); ?></h3>
                    <?php endif; ?>
                    <?php if ($step_description): ?>
                        <p class="how-we-work__item-description"><?php echo esc_html($step_description); ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    $args = array(
        'post_type'      => 'car',
        'posts_per_page' => 4,
        'meta_query'     => array(
            array(
                'key'     => 'car_status',
                'value'   => 'available',
                'compare' => '=',
            ),
        ),
    );
    $cars_query = new WP_Query( $args );

    if ( $cars_query->have_posts() ) :
    ?>
    <section class="available-cars">
        <div class="container">
            <h2 class="available-cars__title">Авто в наявності</h2>
            
            <div class="available-cars__grid">
                <?php while ( $cars_query->have_posts() ) : $cars_query->the_post(); 
                    // Получаем все данные заранее
                    $mileage = get_field('mileage');
                    $fuel_type = get_the_term_list(get_the_ID(), 'fuel_type', '', ', ');
                    $transmission = get_the_term_list(get_the_ID(), 'transmission', '', ', ');
                    $engine_volume = get_field('engine_volume');
                    $price_usd = get_field('price_usd');
                    $old_price_usd = get_field('old_price_usd');
                    $brand = get_the_term_list(get_the_ID(), 'brand', '', ', ');
                    $model = get_field('car_model');
                    $year = get_field('car_year');
                ?>
                    <div class="car-card">
                        <a href="<?php the_permalink(); ?>" class="car-card__image-link">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                            <?php else : 
                                $gallery = get_field('car_gallery');
                                if ($gallery) :
                                    echo wp_get_attachment_image($gallery[0]['ID'], 'large', false, array('alt' => get_the_title()));
                                endif;
                            ?>
                            <?php endif; ?>
                        </a>
                        <div class="car-card__content">
                            <h3 class="car-card__title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php echo strip_tags($brand); ?> <?php echo $model; ?>, <?php echo $year; ?>
                                </a>
                            </h3>
                            
                            <div class="car-card__pills">
                                <?php if ($mileage) : ?>
                                <div class="car-card__pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v3m0 16v3M4.22 4.22l2.12 2.12m11.32 11.32l2.12 2.12M1 12h3m16 0h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12"></path><circle cx="12" cy="12" r="5"></circle></svg>
                                    <span><?php echo $mileage; ?> тис. км</span>
                                </div>
                                <?php endif; ?>
                                <?php if ($fuel_type) : ?>
                                <div class="car-card__pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 8h.01"></path><path d="M10 8h.01"></path><path d="M16 4.1C16 2.94 15.06 2 14 2H6c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h1c1.1 0 2-.9 2-2v-2h4v2c0 1.1.9 2 2 2h1c1.1 0 2-.9 2-2V8c0-2.2-1.8-4-4-4z"></path></svg>
                                    <span><?php echo strip_tags($fuel_type); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if ($transmission) : ?>
                                <div class="car-card__pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path><path d="M12 12m-8 0a8 8 0 1 0 16 0a8 8 0 1 0 -16 0"></path><path d="M3 12h-2"></path><path d="M23 12h-2"></path><path d="M12 3v-2"></path><path d="M12 23v-2"></path></svg>
                                    <span><?php echo strip_tags($transmission); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if ($engine_volume) : ?>
                                <div class="car-card__pill">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12v5"></path><path d="M15.24 15.24 13.5 13.5"></path><path d="M12 22a9.96 9.96 0 0 1-5-1.46"></path><path d="M12 22a9.96 9.96 0 0 0 5-1.46"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 1 0-6 0"></path><path d="m13.5 13.5.76.76"></path><path d="M12 2v2.5"></path><path d="M10.5 4.5 12 6l1.5-1.5"></path></svg>
                                    <span><?php echo $engine_volume; ?> л</span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="car-card__footer">
                                <?php if ($price_usd) : ?>
                                <div class="car-card__price-block">
                                    <?php if ($old_price_usd) : ?>
                                        <span class="car-card__price--old">$<?php echo number_format($old_price_usd, 0, '', ' '); ?></span>
                                    <?php endif; ?>
                                    <span class="car-card__price--current">$<?php echo number_format($price_usd, 0, '', ' '); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="available-cars__footer">
                <a href="<?php echo get_post_type_archive_link( 'car' ); ?>" class="button button--primary">Показати більше</a>
            </div>
        </div>
    </section>
    <?php 
    endif; 
    wp_reset_postdata(); 
    ?>

</main>

<?php
get_footer();