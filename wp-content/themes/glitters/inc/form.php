<?php
/**
 * Contact form. Requests are stored even if mail fails.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('admin_post_nopriv_glitters_contact', 'glitters_handle_contact');
add_action('admin_post_glitters_contact', 'glitters_handle_contact');

/**
 * Handle the Russian contact form.
 */
function glitters_handle_contact() {
	if (!isset($_POST['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'glitters_contact')) {
		glitters_form_redirect(
			array(
				'errors' => array('Сессия формы устарела. Обновите страницу и отправьте заявку ещё раз.'),
			)
		);
	}

	$honeypot = isset($_POST['glitters_company']) ? trim((string) wp_unslash($_POST['glitters_company'])) : '';
	$stamp    = isset($_POST['glitters_stamp']) ? sanitize_text_field(wp_unslash($_POST['glitters_stamp'])) : '';
	$timing   = glitters_check_form_stamp($stamp);
	$name_raw    = isset($_POST['guest_name']) ? (string) wp_unslash($_POST['guest_name']) : '';
	$message_raw = isset($_POST['guest_message']) ? (string) wp_unslash($_POST['guest_message']) : '';
	$link_count  = preg_match_all('#https?://#i', $message_raw);
	$spam        = (bool) preg_match('#https?://|www\.#i', $name_raw) || $link_count > 2;
	if ($honeypot !== '' || $timing === 'fast' || $spam) {
		glitters_form_redirect(array('success' => glitters_text('form_success')));
	}
	if ($timing === 'invalid') {
		glitters_form_redirect(
			array(
				'errors' => array('Сессия формы устарела. Обновите страницу и отправьте заявку ещё раз.'),
			)
		);
	}

	$ip    = isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '';
	$limit = 'glitters_rl_' . md5($ip);
	$count = (int) get_transient($limit);
	if ($count > 5) {
		glitters_form_redirect(
			array(
				'errors' => array('Слишком много сообщений подряд. Позвоните, пожалуйста: ' . glitters_get('phone_display') . '.'),
			)
		);
	}
	set_transient($limit, $count + 1, HOUR_IN_SECONDS);

	$name    = isset($_POST['guest_name']) ? sanitize_text_field(wp_unslash($_POST['guest_name'])) : '';
	$phone   = isset($_POST['guest_phone']) ? sanitize_text_field(wp_unslash($_POST['guest_phone'])) : '';
	$message = isset($_POST['guest_message']) ? sanitize_textarea_field(wp_unslash($_POST['guest_message'])) : '';
	$service = isset($_POST['service_id']) ? absint($_POST['service_id']) : 0;
	$consent = isset($_POST['consent']) ? '1' : '';
	$digits  = preg_replace('/\D/', '', $phone);
	$errors  = array();

	if (mb_strlen($name) < 2 || mb_strlen($name) > 80) {
		$errors[] = 'Укажите имя — не длиннее 80 знаков.';
	}
	if (strlen($digits) < 10 || mb_strlen($phone) > 30) {
		$errors[] = 'Укажите телефон — не меньше 10 цифр.';
	}
	if ($consent !== '1') {
		$errors[] = 'Подтвердите согласие на обработку персональных данных.';
	}
	if (mb_strlen($message) > 2000) {
		$errors[] = 'Сообщение слишком длинное.';
	}

	$service_title = 'Не выбрана';
	if ($service) {
		$service_post = get_post($service);
		if ($service_post && $service_post->post_type === 'glitters_service' && $service_post->post_status === 'publish') {
			$service_title = get_the_title($service_post);
		} else {
			$service = 0;
		}
	}

	if ($errors) {
		glitters_form_redirect(
			array(
				'errors' => $errors,
				'old'    => array(
					'name'       => $name,
					'phone'      => $phone,
					'message'    => $message,
					'service_id' => $service,
				),
			)
		);
	}

	$admins = get_users(
		array(
			'role'   => 'administrator',
			'number' => 1,
			'fields' => 'ID',
		)
	);
	$author = $admins ? (int) $admins[0] : 1;
	$post_id = wp_insert_post(
		array(
			'post_type'    => 'glitters_request',
			'post_status'  => 'private',
			'post_title'   => $name . ' — ' . wp_date('d.m.Y H:i'),
			'post_content' => $message,
			'post_author'  => $author,
		),
		true
	);

	if (is_wp_error($post_id)) {
		glitters_form_redirect(
			array(
				'errors' => array('Не удалось отправить заявку. Позвоните нам: ' . glitters_get('phone_display') . '.'),
				'old'    => array(
					'name'       => $name,
					'phone'      => $phone,
					'message'    => $message,
					'service_id' => $service,
				),
			)
		);
	}

	update_post_meta($post_id, 'phone', $phone);
	update_post_meta($post_id, 'service', $service_title);
	update_post_meta($post_id, 'guest_name', $name);

	$body = "Новая заявка с сайта Glitters\n\n"
		. 'Имя: ' . $name . "\n"
		. 'Телефон: ' . $phone . "\n"
		. 'Услуга: ' . $service_title . "\n"
		. 'Сообщение: ' . ($message !== '' ? $message : '—') . "\n"
		. 'Время: ' . wp_date('j F Y, H:i') . "\n";

	$sent = wp_mail(
		glitters_form_email(),
		'Заявка с сайта Glitters',
		$body,
		array('Content-Type: text/plain; charset=UTF-8')
	);
	update_post_meta($post_id, '_mail_sent', $sent ? '1' : '0');

	glitters_form_redirect(
		array(
			'success' => glitters_text('form_success'),
		)
	);
}

/**
 * @param array<string, mixed> $data Notice payload.
 */
function glitters_form_redirect($data) {
	$key = wp_generate_password(20, false, false);
	set_transient('glitters_form_' . $key, $data, 5 * MINUTE_IN_SECONDS);
	setcookie(
		'glitters_form',
		$key,
		array(
			'expires'  => time() + 300,
			'path'     => COOKIEPATH ? COOKIEPATH : '/',
			'domain'   => COOKIE_DOMAIN,
			'secure'   => is_ssl(),
			'httponly' => true,
			'samesite' => 'Lax',
		)
	);
	wp_safe_redirect(home_url('/#contacts'));
	exit;
}

/**
 * Read and clear the one-time form notice.
 *
 * @return array<string, mixed>|null
 */
function glitters_pull_form_notice() {
	static $done = false;
	static $data = null;
	if ($done) {
		return $data;
	}
	$done = true;
	if (empty($_COOKIE['glitters_form'])) {
		return null;
	}
	$key  = preg_replace('/[^a-zA-Z0-9]/', '', wp_unslash($_COOKIE['glitters_form']));
	$data = get_transient('glitters_form_' . $key);
	delete_transient('glitters_form_' . $key);
	setcookie(
		'glitters_form',
		'',
		array(
			'expires'  => time() - 3600,
			'path'     => COOKIEPATH ? COOKIEPATH : '/',
			'domain'   => COOKIE_DOMAIN,
			'secure'   => is_ssl(),
			'httponly' => true,
			'samesite' => 'Lax',
		)
	);
	unset($_COOKIE['glitters_form']);
	return is_array($data) ? $data : null;
}
