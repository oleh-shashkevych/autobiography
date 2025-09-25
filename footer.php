<?php
/**
 * The template for displaying the footer
 */
?>

<footer id="colophon" class="site-footer">
    <div class="site-info">
        &copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>
    </div></footer><?php wp_footer(); // Важный хук. Сюда WordPress и плагины подключают свои JS-скрипты. ?>
</body>
</html>