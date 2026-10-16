<?php
/**
 * Glitters theme bootstrap.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!defined('DISALLOW_FILE_EDIT')) {
	define('DISALLOW_FILE_EDIT', true);
}

define('GLITTERS_VERSION', '1.2.1');
define('GLITTERS_DIR', get_template_directory());
define('GLITTERS_URI', get_template_directory_uri());

require GLITTERS_DIR . '/inc/security.php';
require GLITTERS_DIR . '/inc/helpers.php';
require GLITTERS_DIR . '/inc/icons.php';
require GLITTERS_DIR . '/inc/cpt.php';
require GLITTERS_DIR . '/inc/meta.php';
require GLITTERS_DIR . '/inc/settings.php';
require GLITTERS_DIR . '/inc/form.php';
require GLITTERS_DIR . '/inc/seo.php';
require GLITTERS_DIR . '/inc/legal.php';
require GLITTERS_DIR . '/inc/seed.php';

add_action('after_setup_theme', 'glitters_setup');
add_action('wp_enqueue_scripts', 'glitters_assets');
add_action('wp_head', 'glitters_preload_fonts', 2);
add_action('init', 'glitters_cleanup_head');
add_action('init', 'glitters_maybe_seed', 20);
add_action('admin_init', 'glitters_maybe_russian');
add_filter('body_class', 'glitters_body_class');
add_filter('use_block_editor_for_post_type', 'glitters_disable_block_editor', 10, 2);

/**
 * Theme supports.
 */
function glitters_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support(
		'html5',
		array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script')
	);
	add_theme_support('responsive-embeds');
	add_theme_support('align-wide');
	add_theme_support('editor-styles');
	add_editor_style('assets/css/editor.css');
	add_theme_support('wp-block-styles');

	add_image_size('glitters_hero', 1920, 1280, true);
	add_image_size('glitters_gallery', 1600, 1200, true);
	add_image_size('glitters_portrait', 900, 1200, true);

	register_nav_menus(
		array(
			'primary' => 'Главное меню',
			'footer'  => 'Меню в подвале',
		)
	);
}

/**
 * Front-end assets. Fonts are self-hosted: Google Fonts is often slow in Russia.
 */
function glitters_assets() {
	wp_enqueue_style('glitters', GLITTERS_URI . '/assets/css/main.css', array(), GLITTERS_VERSION);
	wp_enqueue_script(
		'glitters',
		GLITTERS_URI . '/assets/js/main.js',
		array(),
		GLITTERS_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}

/**
 * Preload the two faces used above the fold.
 */
function glitters_preload_fonts() {
	$fonts = array('cormorant-500-cyr.woff2', 'manrope-400-cyr.woff2');
	foreach ($fonts as $font) {
		$path = GLITTERS_DIR . '/assets/fonts/' . $font;
		if (!file_exists($path)) {
			continue;
		}
		echo '<link rel="preload" href="' . esc_url(GLITTERS_URI . '/assets/fonts/' . $font) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	}
	if (!has_site_icon()) {
		echo '<link rel="icon" href="' . esc_url(GLITTERS_URI . '/assets/images/favicon.svg') . '" type="image/svg+xml">' . "\n";
	}
}

/**
 * Drop unused head tags.
 */
function glitters_cleanup_head() {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_shortlink_wp_head');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	remove_action('wp_head', 'rest_output_link_wp_head');
	remove_action('template_redirect', 'rest_output_link_header', 11);
}

/**
 * Body classes for the transparent header.
 *
 * @param string[] $classes Classes.
 * @return string[]
 */
function glitters_body_class($classes) {
	if (is_front_page()) {
		$classes[] = 'is-front';
	}
	return $classes;
}

/**
 * Short salon records stay in the classic editor.
 *
 * @param bool   $use  Whether to use the block editor.
 * @param string $type Post type.
 * @return bool
 */
function glitters_disable_block_editor($use, $type) {
	$simple = array('glitters_service', 'glitters_master', 'glitters_review', 'glitters_interior', 'glitters_request');
	if (in_array($type, $simple, true)) {
		return false;
	}
	return $use;
}

add_filter('comments_open', '__return_false', 20);
add_filter('pings_open', '__return_false', 20);
