<?php
get_header();
if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('single')) {
} else {
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <?php echo get_np_template_part('partials/stundennachweis/stundennachweis', 'frame'); ?>
<?php endwhile;
    endif;
}

get_footer();
