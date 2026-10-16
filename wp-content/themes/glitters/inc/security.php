<?php
/**
 * Quiet hardening for a public salon site.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('send_headers', 'glitters_security_headers');
add_filter('xmlrpc_methods', 'glitters_disable_pingbacks');
add_filter('xmlrpc_enabled', '__return_false');
add_filter('wp_headers', 'glitters_strip_pingback_header');
add_filter('rest_endpoints', 'glitters_hide_user_endpoints');
add_action('template_redirect', 'glitters_block_author_archives');
add_filter('login_errors', 'glitters_generic_login_error');
add_filter('authenticate', 'glitters_limit_login', 100, 3);
add_action('wp_login_failed', 'glitters_note_login_fail');
add_action('wp_login', 'glitters_clear_login_fail', 10, 2);
add_filter('wp_is_application_passwords_available', '__return_false');
add_filter('pre_option_users_can_register', 'glitters_registration_closed');
add_filter('upload_mimes', 'glitters_block_svg');
add_filter('style_loader_src', 'glitters_hide_wp_version');
add_filter('script_loader_src', 'glitters_hide_wp_version');

/**
 * Headers that do not block Yandex Maps or Dikidi.
 */
function glitters_security_headers() {
	if (headers_sent() || is_admin()) {
		return;
	}
	header('X-Content-Type-Options: nosniff');
	header('Referrer-Policy: strict-origin-when-cross-origin');
	header('X-Frame-Options: SAMEORIGIN');
	header('X-Permitted-Cross-Domain-Policies: none');
	header('X-XSS-Protection: 0');
	header('Cross-Origin-Opener-Policy: same-origin-allow-popups');
	header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=()');

	$csp = "default-src 'self'; base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; img-src 'self' data: https://yandex.ru https://*.yandex.ru https://*.yandex.net; font-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self'; frame-src https://yandex.ru https://*.yandex.ru https://*.yandex.net; connect-src 'self'";
	if (is_ssl()) {
		$csp .= '; upgrade-insecure-requests';
	}
	$csp = apply_filters('glitters_csp', $csp);
	if (is_string($csp) && $csp !== '') {
		header('Content-Security-Policy: ' . $csp);
	}
}

/**
 * Pingbacks are a common spam entry and are unused here.
 *
 * @param array<string, string> $methods Methods.
 * @return array<string, string>
 */
function glitters_disable_pingbacks($methods) {
	unset($methods['pingback.ping'], $methods['pingback.extensions.getPingbacks']);
	return $methods;
}

/**
 * @param array<string, string> $headers Headers.
 * @return array<string, string>
 */
function glitters_strip_pingback_header($headers) {
	unset($headers['X-Pingback']);
	return $headers;
}

/**
 * Registration stays closed on a salon site.
 *
 * @return string
 */
function glitters_registration_closed() {
	return '0';
}

/**
 * SVG uploads can carry scripts.
 *
 * @param array<string, string> $mimes Mime types.
 * @return array<string, string>
 */
function glitters_block_svg($mimes) {
	unset($mimes['svg'], $mimes['svgz']);
	return $mimes;
}

/**
 * Drop the WordPress version from public asset URLs. Theme versions stay.
 *
 * @param string $src Asset URL.
 * @return string
 */
function glitters_hide_wp_version($src) {
	if (is_admin()) {
		return $src;
	}
	$parts = wp_parse_url($src);
	if (empty($parts['query'])) {
		return $src;
	}
	parse_str($parts['query'], $query);
	if (isset($query['ver']) && $query['ver'] === get_bloginfo('version')) {
		return remove_query_arg('ver', $src);
	}
	return $src;
}

/**
 * @return string
 */
function glitters_login_key() {
	$ip = isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
	return 'glitters_login_' . md5($ip);
}

/**
 * @param WP_User|WP_Error|null $user User.
 * @param string                $username Username.
 * @param string                $password Password.
 * @return WP_User|WP_Error|null
 */
function glitters_limit_login($user, $username, $password) {
	unset($username, $password);
	if ((int) get_transient(glitters_login_key()) >= 8) {
		return new WP_Error('glitters_locked', 'Слишком много попыток. Подождите 15 минут.');
	}
	return $user;
}

/**
 * @param string $username Username.
 */
function glitters_note_login_fail($username) {
	unset($username);
	$key   = glitters_login_key();
	$count = (int) get_transient($key);
	set_transient($key, $count + 1, 15 * MINUTE_IN_SECONDS);
}

/**
 * @param string  $user_login Login.
 * @param WP_User $user User.
 */
function glitters_clear_login_fail($user_login, $user) {
	unset($user_login, $user);
	delete_transient(glitters_login_key());
}

/**
 * Hide the public user list from anonymous visitors.
 *
 * @param array<string, mixed> $endpoints Endpoints.
 * @return array<string, mixed>
 */
function glitters_hide_user_endpoints($endpoints) {
	if (is_user_logged_in()) {
		return $endpoints;
	}
	unset($endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)']);
	return $endpoints;
}

/**
 * Author archives would expose account names. The salon has no blog authors.
 */
function glitters_block_author_archives() {
	if (is_admin()) {
		return;
	}
	if (!is_author() && !isset($_GET['author'])) {
		return;
	}
	wp_safe_redirect(home_url('/'), 301);
	exit;
}

/**
 * @return string
 */
function glitters_generic_login_error() {
	return 'Неверные данные для входа.';
}

/**
 * Signed time so a form cannot be posted the instant it is rendered.
 *
 * @return string
 */
function glitters_form_stamp() {
	$time = (string) time();
	return $time . '.' . wp_hash($time . '|glitters-form');
}

/**
 * @param string $stamp Posted stamp.
 * @return string ok|fast|invalid
 */
function glitters_check_form_stamp($stamp) {
	$parts = explode('.', (string) $stamp, 2);
	if (count($parts) !== 2 || !ctype_digit($parts[0])) {
		return 'invalid';
	}
	$expected = wp_hash($parts[0] . '|glitters-form');
	if (!hash_equals($expected, $parts[1])) {
		return 'invalid';
	}
	$age = time() - (int) $parts[0];
	if ($age < 3) {
		return 'fast';
	}
	if ($age > 2 * HOUR_IN_SECONDS) {
		return 'invalid';
	}
	return 'ok';
}
