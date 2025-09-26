<?php

/**
 * Remove unnecessary WordPress assets and load custom assets.
 *
 * @package WordPress
 * @subpackage starter
 * @since 1.0
 */

defined('ABSPATH') || exit;

/**
 * Remove default assest.
 *
 * @since starter 1.0
 */
function starter_remove_default_assets()
{
	/*strange embed assets*/
	wp_deregister_script('wp-embed');
	/*wp emojis*/
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	add_filter('emoji_svg_url', '__return_false');
	/*wp version*/
	remove_action('wp_head', 'wp_generator');
	/*blog and windows live clients*/
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	/*REST API*/
	remove_action('wp_head', 'rest_output_link_wp_head', 10); /*Disable REST API link tag*/
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10); /*Disable oEmbed Discovery Links*/
	remove_action('template_redirect', 'rest_output_link_header', 11, 0); /*Disable REST API link in HTTP headers*/
}
if (! is_admin()) {
	add_action('init', 'starter_remove_default_assets');
}

/**
 * Remove gutenberg block assets.
 *
 * @since starter 1.0
 */
function starter_remove_block_library_css()
{
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
}
add_action('wp_enqueue_scripts', 'starter_remove_block_library_css');

/**
 * Enqueues styles.
 *
 * @since 1.0
 */
function np_enqueue_styles()
{
	$theme_version = wp_get_theme()->get('Version');
	wp_enqueue_style('np-style', NP_THEME_TEMPLATE_URL . 'assets/css/theme.css', array(), $theme_version);
	wp_enqueue_style('np-header-style', NP_THEME_TEMPLATE_URL . 'assets/css/header.css', array(), $theme_version);
	wp_enqueue_style('np-stellennachweis-style', NP_THEME_TEMPLATE_URL . 'assets/css/stundennachweis/body.css', array(), $theme_version);
}
add_action('wp_enqueue_scripts', 'np_enqueue_styles');

/**
 * Enqueues scripts.
 *
 * @since 1.0
 */
function np_enqueue_scripts()
{
	$theme_version = wp_get_theme()->get('Version');
	wp_enqueue_script('np-cloudflare','https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js', array(), true);
	wp_enqueue_script('np-theme-scripts', NP_THEME_TEMPLATE_URL . 'assets/js/theme.js', array(), $theme_version, true);
	wp_localize_script('np-theme-scripts', 'myplugin', [
		'ajax_url' => admin_url('admin-ajax.php')
	]);
}
add_action('wp_enqueue_scripts', 'np_enqueue_scripts');

/**
 * Replace stylesheet attr into preload
 *
 * @since 1.1
 *
 * @param string $tag <link> tag.
 * @return string $tag modified <link> tag.
 */
function starter_css_preloader_tag($tag)
{
	$tag = preg_replace("/rel='stylesheet'/", "rel='preload' as='style' onload=\"this.rel='stylesheet'\" ", $tag);
	return $tag;
}

/**
 * Apply preload filter for all pages exception cart/checkout/account
 *
 * @since 1.1
 */
function starter_preloader_tag()
{
	if (class_exists('WooCommerce') && ! is_cart() && ! is_checkout() && ! is_account_page()) {
		add_filter('style_loader_tag', 'starter_css_preloader_tag');
	} else {
		add_filter('style_loader_tag', 'starter_css_preloader_tag');
	}
}
if (get_theme_mod('preload_css', true)) {
	add_action('wp_head', 'starter_preloader_tag');
	add_action('wp_enqueue_scripts', 'starter_preloader_tag');
}

/**
 * Include critical css to head.
 *
 * @since 1.1
 */
function np_enqueues_critical_styles()
{
	global $template;
	$name_template = substr(basename($template), 0, -4);
	$path_css      = NP_THEME_TEMPLATE_PATH . 'assets/css/critical/' . $name_template . '.css';
	if (file_exists($path_css)) {
		echo '<style>';
		// @codingStandardsIgnoreStart - safe css generated locally by gulp. DOES NOT USE esc_html - will be wrong css.
		echo file_get_contents($path_css);
		// @codingStandardsIgnoreEnd
		echo '</style>';
	}
}
if (get_theme_mod('critical_css', true)) {
	add_action('wp_enqueue_scripts', 'np_enqueues_critical_styles');
}

/**
 * Add custom css file into WordPress admin.
 *
 * @since 1.1
 */
function np_admin_enqueue_styles()
{
	wp_enqueue_style('np-admin-style', NP_THEME_TEMPLATE_URL . 'assets/css/wp_admin.css', '', filemtime(NP_THEME_TEMPLATE_PATH . 'assets/css/wp_admin.css'));
}
add_action('admin_enqueue_scripts', 'np_admin_enqueue_styles');
