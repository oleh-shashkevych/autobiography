<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="container" style="padding: 80px 30px;">
        <?php while ( have_posts() ) : the_post(); ?>
            <article>
                <h1><?php the_title(); ?></h1>
                
                <div class="car-gallery">
                    <?php 
                    $gallery = get_field('car_gallery');
                    if ($gallery) {
                        foreach ($gallery as $image) {
                            echo '<img src="' . esc_url($image['sizes']['large']) . '" alt="' . esc_attr($image['alt']) . '" style="max-width: 300px; margin: 10px;">';
                        }
                    }
                    ?>
                </div>

                <h2>Основні характеристики</h2>
                <ul>
                    <li><strong>Ціна:</strong> $<?php echo number_format(get_field('price_usd')); ?></li>
                    <li><strong>Рік:</strong> <?php the_field('car_year'); ?></li>
                    <li><strong>Пробіг:</strong> <?php the_field('mileage'); ?> тис. км</li>
                    <li><strong>VIN:</strong> <?php the_field('vin_code'); ?></li>
                    <li><strong>Марка:</strong> <?php echo get_the_term_list(get_the_ID(), 'brand', '', ', '); ?></li>
                </ul>

                <div class="content">
                    <?php the_content(); ?>
                </div>

                <div class="complectation">
                    <h3>Комплектація</h3>
                    <?php the_field('complectation'); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>