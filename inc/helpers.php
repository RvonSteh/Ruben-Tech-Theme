<?php

if (!defined('ABSPATH')) {
    exit;
}

function get_np_template_part($slug, $name = null, $args = [])
{
    $template = '';

    if ($name) {
        $template_name = "{$slug}-{$name}.php";
    } else {
        $template_name = "{$slug}.php";
    }

    $templatePath = file_exists(NP_THEME_TEMPLATE_PATH . $template_name) ? NP_THEME_TEMPLATE_PATH . $template_name : null;

    if ($templatePath) {
        ob_start();
        include $templatePath;
        $template = ob_get_clean();
        echo $template;
    }
}
