<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="container" style="padding: 80px 30px;">
        <h1 class="page-title">Каталог автомобілів</h1>
        <p>Тут буде повний каталог з фільтрами та сортуванням.</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <div style="border: 1px solid #ccc; padding: 20px;">
                        <a href="<?php the_permalink(); ?>">
                            <?php if(has_post_thumbnail()): the_post_thumbnail('medium'); endif; ?>
                            <h2><?php the_title(); ?></h2>
                            <p>Ціна: $<?php echo number_format(get_field('price_usd')); ?></p>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>На жаль, автомобілів не знайдено.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>