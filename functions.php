<?php

/**
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage Ninjapiraten
 * @since Ninjapiraten 1.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('NP_THEME_TEMPLATE_PATH', get_stylesheet_directory() . '/');
define('NP_THEME_TEMPLATE_URL', get_stylesheet_directory_uri() . '/');
define('HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0');


include_once(NP_THEME_TEMPLATE_PATH . 'inc/helpers.php');
include_once(NP_THEME_TEMPLATE_PATH . 'inc/shortcodes.php');
/**
 * Debugging functions
 */
require_once NP_THEME_TEMPLATE_PATH . 'inc/debug/debug.php';

/**
 * Manage assets
 */
require_once NP_THEME_TEMPLATE_PATH . 'inc/assets.php';

/**
 * Include woocommerce funstions if plugin enabled
 */
if (class_exists('WooCommerce')) {
    require_once NP_THEME_TEMPLATE_PATH . 'inc/woocommerce/woocommerce.php';
}

/**
 * Custom path save acf fields
 *
 * @since 1.3
 */
function np_acf_save_json($path)
{
    $path = NP_THEME_TEMPLATE_PATH . 'inc/acf-json';
    return $path;
}
add_filter('acf/settings/save_json', 'np_acf_save_json');

/**
 * Custom path load acf fields
 *
 * @since 1.3
 */
function np_acf_load_json($paths)
{
    unset($paths[0]);
    $paths[] = NP_THEME_TEMPLATE_PATH . 'inc/acf-json';
    return $paths;
}