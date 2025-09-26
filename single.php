<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('single')) {
} else {
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <div class="post-content">
                <?php echo get_np_template_part('partials/stundennachweis/stundennachweis', 'frame'); ?>
                <?php echo get_np_template_part('partials/stundennachweis/stundennachweis', 'mask'); ?>
                <?php echo get_np_template_part('partials/stundennachweis/stundennachweis', 'switcher'); ?>
                <?php echo get_np_template_part('partials/stundennachweis/stundennachweis', 'download'); ?>

            </div>
<?php endwhile;
    endif;
}
?>
<?php get_footer();
