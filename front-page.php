<?php
get_header();
?>

<main id="primary" class="site-main">
    <?php 
    $slides = get_field('hero_slider');
    $hero_form_shortcode = get_field('hero_form_shortcode');
    $hero_form_title = get_field('hero_form_title');
    $hero_content_title = get_field('hero_content_title');
    $hero_content_title_small = get_field('hero_content_title_small');
    $hero_content_subtitle = get_field('hero_content_subtitle');

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
            <div class="hero__grid">
                <div class="hero-form">
                    <?php if ($hero_form_title): ?>
                        <h3 class="hero-form__title"><?php echo esc_html($hero_form_title); ?></h3>
                    <?php endif; ?>

                    <?php if ($hero_form_shortcode) {
                        echo do_shortcode($hero_form_shortcode);
                    } ?>
                </div>
                <div class="hero__text-content">
                    <?php if ($hero_content_title): ?>
                        <h1 class="hero__main-title"><?php echo esc_html($hero_content_title); ?><?php if ($hero_content_title_small): ?><span><?php echo esc_html($hero_content_title_small); ?></span><?php endif; ?></h1>
                    <?php endif; ?>
                    <?php if ($hero_content_subtitle): ?>
                        <p class="hero__subtitle"><?php echo esc_html($hero_content_subtitle); ?></p>
                    <?php endif; ?>
                </div>
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
    $how_we_work_button = get_field('how_we_work_button');
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
                        <span class="how-we-work__step-number"><?php echo $index + 1; ?></span>
                    </div>
                    <?php if ($step['step_title']): ?><h3 class="how-we-work__item-title"><?php echo esc_html($step['step_title']); ?></h3><?php endif; ?>
                    <?php if ($step['step_description']): ?><p class="how-we-work__item-description"><?php echo esc_html($step['step_description']); ?></p><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php // START: ВЫВОД КНОПКИ
            if( $how_we_work_button ): 
                $link_url = $how_we_work_button['url'];
                $link_title = $how_we_work_button['title'];
                $link_target = $how_we_work_button['target'] ? $how_we_work_button['target'] : '_self';
            ?>
                <div class="how-we-work__footer">
                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="button button--primary">
                        <?php echo esc_html( $link_title ); ?>
                    </a>
                </div>
            <?php endif; // END: ВЫВОД КНОПКИ ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    $available_cars_title = get_field('fp_available_cars_title');
    $available_cars_button_text = get_field('fp_available_cars_button_text');

    $cars_query = new WP_Query( array('post_type' => 'car', 'posts_per_page' => 3, 'meta_query' => array(array('key' => 'car_status', 'value' => 'available'))));
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
                            <?php if ($mileage = get_field('mileage')) : ?><div class="car-card__pill"><svg fill="currentColor" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M256,0C114.62,0,0,114.611,0,256c0,141.38,114.62,256,256,256s256-114.62,256-256C512,114.611,397.38,0,256,0z M256,486.4 C128.956,486.4,25.6,383.044,25.6,256S128.956,25.6,256,25.6S486.4,128.956,486.4,256S383.044,486.4,256,486.4z"></path> </g> </g> <g> <g> <path d="M256,76.8c-98.97,0-179.2,80.23-179.2,179.2S157.03,435.2,256,435.2S435.2,354.97,435.2,256S354.97,76.8,256,76.8z M268.8,103.049c58.078,4.821,107.102,41.993,128.811,93.483l-111.283,36.156c-4.463-5.803-10.496-10.24-17.528-12.74V103.049z M256,243.2c7.057,0,12.8,5.743,12.8,12.8s-5.743,12.8-12.8,12.8s-12.8-5.743-12.8-12.8S248.943,243.2,256,243.2z M243.2,103.049 v116.898c-7.023,2.5-13.056,6.946-17.527,12.74l-111.283-36.156C136.098,145.041,185.122,107.87,243.2,103.049z M102.4,256 c0-12.083,1.544-23.791,4.198-35.081l111.104,36.096c0.205,7.689,2.603,14.814,6.682,20.727l-68.599,94.404 C123.162,343.962,102.4,302.396,102.4,256z M256,409.6c-29.116,0-56.269-8.294-79.497-22.426l68.676-94.515 c3.456,1.024,7.04,1.741,10.82,1.741c3.789,0,7.373-0.717,10.829-1.741l68.668,94.515C312.269,401.306,285.116,409.6,256,409.6z M356.207,372.147l-68.591-94.413c4.079-5.914,6.468-13.039,6.673-20.727l111.104-36.096c2.662,11.298,4.207,23.006,4.207,35.089 C409.6,302.396,388.838,343.962,356.207,372.147z"></path> </g> </g> </g></svg><span>
                                <?php 
                                // Перевіряємо поточну мову
                                if (pll_current_language('slug') === 'uk') {
                                    echo esc_html($mileage) . ' тис. км';
                                } else {
                                    echo esc_html($mileage) . ' thousand km';
                                }
                                ?>
                            </span></div><?php endif; ?>
                            <?php if ($transmission = get_the_term_list(get_the_ID(), 'transmission', '', ', ')) : ?><div class="car-card__pill"><svg fill="currentColor" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M256,0C114.62,0,0,114.611,0,256c0,141.38,114.62,256,256,256c141.389,0,256-114.62,256-256C512,114.611,397.389,0,256,0z M256,486.4C128.956,486.4,25.6,383.044,25.6,256S128.956,25.6,256,25.6S486.4,128.956,486.4,256S383.044,486.4,256,486.4z"></path> </g> </g> <g> <g> <path d="M371.2,128v115.2h-59.733V128h-25.6v115.2h-59.733V128h-25.6v115.2H140.8V128h-25.6v128c0,7.074,5.726,12.8,12.8,12.8 h72.533V384h25.6V268.8h59.733V384h25.6V268.8H371.2V384h25.6V128H371.2z"></path> </g> </g> </g></svg><span><?php echo strip_tags($transmission); ?></span></div><?php endif; ?>
                            <?php if ($fuel_type = get_the_term_list(get_the_ID(), 'fuel_type', '', ', ')) : ?><div class="car-card__pill"><svg fill="currentColor" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M407.403,179.2l33.101-33.101c10.001-10.001,10.001-26.206,0-36.207l-25.6-25.6c-5.009-4.992-11.554-7.492-18.108-7.492 c-6.554,0-13.107,2.5-18.099,7.501l-33.101,33.092l-33.101-33.101c-4.796-4.796-11.307-7.492-18.099-7.492h-25.6V25.6 c0-14.14-11.46-25.6-25.6-25.6h-102.4c-14.14,0-25.6,11.46-25.6,25.6v51.2h-25.6c-14.14,0-25.6,11.46-25.6,25.6v384 c0,14.14,11.46,25.6,25.6,25.6h332.8c14.14,0,25.6-11.46,25.6-25.6v-256c0-6.793-2.697-13.303-7.501-18.099L407.403,179.2z M396.796,102.4l25.6,25.6l-33.101,33.101l-25.6-25.6L396.796,102.4z M140.796,25.6h102.4v51.2h-102.4V25.6z M422.396,486.4 h-332.8v-384h204.8l128,128V486.4z"></path> </g> </g> <g> <g> <path d="M378.296,424.55l-58.3-38.869V250.121l34.85-36.48c4.898-5.112,4.702-13.21-0.401-18.091 c-5.154-4.89-13.252-4.676-18.099,0.41L303.45,230.4h-90.505l-61.824-84.361c-4.198-5.734-12.177-6.946-17.903-2.765 c-5.7,4.173-6.929,12.186-2.748,17.886l61.525,83.959v140.57l-58.3,38.869c-5.871,3.925-7.475,11.861-3.55,17.749 c2.475,3.703,6.528,5.7,10.65,5.7c2.449,0,4.924-0.7,7.1-2.15L202.27,409.6h107.452l54.374,36.25c2.176,1.451,4.651,2.15,7.1,2.15 c4.122,0,8.175-1.997,10.65-5.7C385.771,436.412,384.166,428.476,378.296,424.55z M294.396,384h-76.8V256h76.8V384z"></path> </g> </g> </g></svg><span><?php echo strip_tags($fuel_type); ?></span></div><?php endif; ?>
                            <?php 
                            // Отримуємо тип палива та обидві характеристики
                            $fuel_terms = wp_get_post_terms(get_the_ID(), 'fuel_type', array('fields' => 'slugs'));
                            $fuel_type_slug = !empty($fuel_terms) ? $fuel_terms[0] : '';
                            $engine_volume = get_field('engine_volume');
                            $power_kw = get_field('engine_power_kw');

                            // Визначаємо, чи це електрокар (враховуючи можливі варіанти слага)
                            $is_electric = ($fuel_type_slug === 'electric' || $fuel_type_slug === 'elektro');

                            // Логіка виводу
                            if ($is_electric && $power_kw) : // Якщо електрокар І є потужність (кВт)
                            ?>
                            <div class="car-card__pill">
                                <svg fill="currentColor" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M486.4,256V153.6c0-14.14-11.46-25.6-25.6-25.6H243.2v-25.6H320c7.074,0,12.8-5.726,12.8-12.8 c0-7.074-5.726-12.8-12.8-12.8H140.8c-7.074,0-12.8,5.726-12.8,12.8c0,7.074,5.726,12.8,12.8,12.8h76.8V128H76.8 c-14.14,0-25.6,11.46-25.6,25.6v89.6H25.6v-76.8c0-7.074-5.726-12.8-12.8-12.8c-7.074,0-12.8,5.726-12.8,12.8v179.2 c0,7.074,5.726,12.8,12.8,12.8c7.074,0,12.8-5.726,12.8-12.8v-76.8h25.6v89.6c0,14.14,11.46,25.6,25.6,25.6h91.793l43.699,43.699 c4.804,4.804,11.315,7.501,18.108,7.501h256c14.14,0,25.6-11.46,25.6-25.6v-128C512,267.46,500.54,256,486.4,256z M486.4,409.6 h-256l-51.2-51.2H76.8V153.6h384v128h25.6V409.6z"></path> </g> </g> <g> <g> <path d="M140.8,179.2c-21.171,0-38.4,17.229-38.4,38.4s17.229,38.4,38.4,38.4s38.4-17.229,38.4-38.4 C179.2,196.429,161.971,179.2,140.8,179.2z M140.8,230.4c-7.066,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 c7.066,0,12.8,5.726,12.8,12.8C153.6,224.666,147.866,230.4,140.8,230.4z"></path> </g> </g> <g> <g> <path d="M226.133,179.2c-21.171,0-38.4,17.229-38.4,38.4c0,21.171,17.229,38.4,38.4,38.4s38.4-17.229,38.4-38.4 C264.533,196.429,247.305,179.2,226.133,179.2z M226.133,230.4c-7.066,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 c7.074,0,12.8,5.726,12.8,12.8C238.933,224.666,233.207,230.4,226.133,230.4z"></path> </g> </g> <g> <g> <path d="M311.467,179.2c-21.171,0-38.4,17.229-38.4,38.4s17.229,38.4,38.4,38.4s38.4-17.229,38.4-38.4 C349.867,196.429,332.638,179.2,311.467,179.2z M311.467,230.4c-7.074,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 s12.8,5.726,12.8,12.8C324.267,224.666,318.532,230.4,311.467,230.4z"></path> </g> </g> <g> <g> <path d="M396.8,179.2c-21.171,0-38.4,17.229-38.4,38.4s17.229,38.4,38.4,38.4c21.171,0,38.4-17.229,38.4-38.4 C435.2,196.429,417.971,179.2,396.8,179.2z M396.8,230.4c-7.066,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 c7.066,0,12.8,5.726,12.8,12.8C409.6,224.666,403.866,230.4,396.8,230.4z"></path> </g> </g> <g> <g> <rect x="102.4" y="307.2" width="358.4" height="25.6"></rect> </g> </g> <g> <g> <circle cx="448" cy="371.2" r="12.8"></circle> </g> </g> <g> <g> <circle cx="396.8" cy="371.2" r="12.8"></circle> </g> </g> <g> <g> <circle cx="345.6" cy="371.2" r="12.8"></circle> </g> </g> <g> <g> <circle cx="294.4" cy="371.2" r="12.8"></circle> </g> </g> <g> <g> <circle cx="243.2" cy="371.2" r="12.8"></circle> </g> </g> </g></svg>
                                <span><?php printf(esc_html(autobiography_translate_string('%s кВт', '%s kW')), esc_html($power_kw)); ?></span>
                            </div>
                            <?php 
                            elseif ($engine_volume) : // Інакше, якщо є об'єм двигуна
                            ?>
                            <div class="car-card__pill">
                                <svg fill="currentColor" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M486.4,256V153.6c0-14.14-11.46-25.6-25.6-25.6H243.2v-25.6H320c7.074,0,12.8-5.726,12.8-12.8 c0-7.074-5.726-12.8-12.8-12.8H140.8c-7.074,0-12.8,5.726-12.8,12.8c0,7.074,5.726,12.8,12.8,12.8h76.8V128H76.8 c-14.14,0-25.6,11.46-25.6,25.6v89.6H25.6v-76.8c0-7.074-5.726-12.8-12.8-12.8c-7.074,0-12.8,5.726-12.8,12.8v179.2 c0,7.074,5.726,12.8,12.8,12.8c7.074,0,12.8-5.726,12.8-12.8v-76.8h25.6v89.6c0,14.14,11.46,25.6,25.6,25.6h91.793l43.699,43.699 c4.804,4.804,11.315,7.501,18.108,7.501h256c14.14,0,25.6-11.46,25.6-25.6v-128C512,267.46,500.54,256,486.4,256z M486.4,409.6 h-256l-51.2-51.2H76.8V153.6h384v128h25.6V409.6z"></path> </g> </g> <g> <g> <path d="M140.8,179.2c-21.171,0-38.4,17.229-38.4,38.4s17.229,38.4,38.4,38.4s38.4-17.229,38.4-38.4 C179.2,196.429,161.971,179.2,140.8,179.2z M140.8,230.4c-7.066,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 c7.066,0,12.8,5.726,12.8,12.8C153.6,224.666,147.866,230.4,140.8,230.4z"></path> </g> </g> <g> <g> <path d="M226.133,179.2c-21.171,0-38.4,17.229-38.4,38.4c0,21.171,17.229,38.4,38.4,38.4s38.4-17.229,38.4-38.4 C264.533,196.429,247.305,179.2,226.133,179.2z M226.133,230.4c-7.066,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 c7.074,0,12.8,5.726,12.8,12.8C238.933,224.666,233.207,230.4,226.133,230.4z"></path> </g> </g> <g> <g> <path d="M311.467,179.2c-21.171,0-38.4,17.229-38.4,38.4s17.229,38.4,38.4,38.4s38.4-17.229,38.4-38.4 C349.867,196.429,332.638,179.2,311.467,179.2z M311.467,230.4c-7.074,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 s12.8,5.726,12.8,12.8C324.267,224.666,318.532,230.4,311.467,230.4z"></path> </g> </g> <g> <g> <path d="M396.8,179.2c-21.171,0-38.4,17.229-38.4,38.4s17.229,38.4,38.4,38.4c21.171,0,38.4-17.229,38.4-38.4 C435.2,196.429,417.971,179.2,396.8,179.2z M396.8,230.4c-7.066,0-12.8-5.734-12.8-12.8c0-7.074,5.734-12.8,12.8-12.8 c7.066,0,12.8,5.726,12.8,12.8C409.6,224.666,403.866,230.4,396.8,230.4z"></path> </g> </g> <g> <g> <rect x="102.4" y="307.2" width="358.4" height="25.6"></rect> </g> </g> <g> <g> <circle cx="448" cy="371.2" r="12.8"></circle> </g> </g> <g> <g> <circle cx="396.8" cy="371.2" r="12.8"></circle> </g> </g> <g> <g> <circle cx="345.6" cy="371.2" r="12.8"></circle> </g> </g> <g> <g> <circle cx="294.4" cy="371.2" r="12.8"></circle> </g> </g> <g> <g> <circle cx="243.2" cy="371.2" r="12.8"></circle> </g> </g> </g></svg>
                                <span><?php printf(esc_html(autobiography_translate_string('%s л', '%s L')), esc_html($engine_volume)); ?></span>
                            </div>
                            <?php endif; ?>
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