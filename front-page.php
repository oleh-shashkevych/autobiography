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
</main>

<?php
get_footer();