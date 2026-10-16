<?php
/**
 * Template helpers and brand defaults.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Stored settings merged with defaults. An empty saved value falls back.
 *
 * @param string $key Setting key.
 * @return mixed
 */
function glitters_get($key) {
	$saved = get_option('glitters_settings', array());
	if (is_array($saved) && array_key_exists($key, $saved) && $saved[$key] !== '' && $saved[$key] !== null) {
		return $saved[$key];
	}
	$defaults = glitters_defaults();
	return $defaults[$key] ?? '';
}

/**
 * Contact and map defaults. Coordinates come from the salon's Yandex booking link.
 *
 * @return array<string, mixed>
 */
function glitters_defaults() {
	return array(
		'phone_display'       => '+7 911 109-01-88',
		'phone_href'          => '+79111090188',
		'email_form'          => '',
		'address'             => 'Санкт-Петербург, ул. Правды, 16',
		'district'            => 'Центральный район, метро «Звенигородская»',
		'hours'               => 'ежедневно с 09:00 до 21:00',
		'opens'               => '09:00',
		'closes'              => '21:00',
		'yandex_booking'      => 'https://yandex.ru/maps/org/glitters/168159611812/?booking%5Bpage%5D=resources&booking%5Bpermalink%5D=168159611812&ll=30.341084%2C59.922305&z=16',
		'dikidi'              => 'https://dikidi.net/ru/2119020?p=0.pi-po',
		'yandex_map'          => 'https://yandex.ru/maps/org/glitters/168159611812/',
		'map_oid'             => '168159611812',
		'lat'                 => '59.922305',
		'lng'                 => '30.341084',
		'whatsapp'            => '',
		'telegram'            => '',
		'hero_id'             => 0,
		'show_film'           => 1,
		'force_schema'        => 0,
		'yandex_verification' => '',
		'google_verification' => '',
	);
}

/**
 * Publish-ready Russian copy. Empty admin overrides fall back to these lines.
 *
 * @return array<string, string>
 */
function glitters_default_texts() {
	return array(
		'hero_kicker'    => 'Санкт-Петербург · ул. Правды, 16',
		'hero_title'     => 'Glitters — забота о вашей красоте в центре Санкт-Петербурга',
		'hero_subtitle'  => 'Женский салон красоты и студия ухода за волосами на ул. Правды, 16',
		'about_title'    => 'Частное пространство для женщин, которые ценят тишину и точность',
		'about_text'     => "Glitters — женский салон красоты и студия ухода за волосами в Санкт-Петербурге, на улице Правды, 16. Здесь нет случайной спешки: каждая встреча начинается с разговора, а работа строится вокруг ваших волос, черт и привычного ритма жизни.\n\nКамерный интерьер, опытные специалисты и профессиональные средства — чтобы вы уходили с ощущением собранности и спокойной красоты.",
		'interior_text'  => 'Атмосфера уюта, стиля и заботы в каждой детали',
		'booking_title'  => 'Запишитесь в удобное время',
		'booking_text'   => 'Выберите удобный способ онлайн-записи — мы подтвердим ваше посещение.',
		'services_title' => 'Уход, цвет и форма — в одном внимательном месте',
		'masters_title'  => 'Специалисты салона',
		'reviews_title'  => 'Слова наших гостей',
		'contacts_title' => 'Ждём вас на улице Правды',
	);
}

/**
 * @param string $key Text key.
 * @return string
 */
function glitters_text($key) {
	$defaults = glitters_default_texts();
	$custom   = get_option('glitters_settings', array());
	if (is_array($custom) && isset($custom['tx_' . $key]) && trim((string) $custom['tx_' . $key]) !== '') {
		return (string) $custom['tx_' . $key];
	}
	return $defaults[$key] ?? '';
}

/**
 * Paragraphs from a plain-text textarea.
 *
 * @param string $text Text.
 * @return string
 */
function glitters_paragraphs($text) {
	$parts = preg_split("/\n\s*\n/", trim((string) $text));
	$html  = '';
	foreach ($parts as $part) {
		$part = trim($part);
		if ($part === '') {
			continue;
		}
		$html .= '<p>' . nl2br(esc_html($part)) . '</p>';
	}
	return $html;
}

/**
 * @return string
 */
function glitters_tel() {
	$href   = (string) glitters_get('phone_href');
	$digits = preg_replace('/[^\d+]/', '', $href);
	if ($digits === '') {
		$digits = preg_replace('/[^\d+]/', '', (string) glitters_get('phone_display'));
	}
	return $digits;
}

/**
 * International phone for schema.
 *
 * @return string
 */
function glitters_schema_phone() {
	$digits = preg_replace('/\D/', '', glitters_tel());
	if (strlen($digits) === 11 && $digits[0] === '8') {
		$digits = '7' . substr($digits, 1);
	}
	return $digits ? '+' . $digits : glitters_tel();
}

/**
 * @return string
 */
function glitters_form_email() {
	$email = (string) glitters_get('email_form');
	if (is_email($email)) {
		return $email;
	}
	return (string) get_option('admin_email');
}

/**
 * Anchor on the front page, full URL elsewhere.
 *
 * @param string $id Section id.
 * @return string
 */
function glitters_anchor($id) {
	$id = ltrim($id, '#');
	if (is_front_page()) {
		return '#' . $id;
	}
	return home_url('/#' . $id);
}

/**
 * @return array<string, string>
 */
function glitters_nav_items() {
	return array(
		'about'    => 'О салоне',
		'interior' => 'Интерьер',
		'services' => 'Услуги',
		'masters'  => 'Мастера',
		'reviews'  => 'Отзывы',
		'contacts' => 'Контакты',
	);
}

/**
 * @param string $key privacy|legal.
 * @return string
 */
function glitters_page_url($key) {
	$id = (int) get_option('glitters_page_' . $key);
	if ($id && get_post_status($id) === 'publish') {
		return (string) get_permalink($id);
	}
	$slugs = array(
		'privacy' => 'politika-konfidentsialnosti',
		'legal'   => 'pravovaya-informatsiya',
	);
	$page = get_page_by_path($slugs[$key] ?? '');
	return $page ? (string) get_permalink($page) : home_url('/');
}

/**
 * @param int|string $value Price in rubles.
 * @return string
 */
function glitters_format_price($value) {
	$digits = preg_replace('/\D/', '', (string) $value);
	if ($digits === '' || (int) $digits === 0) {
		return '';
	}
	return 'от ' . number_format((int) $digits, 0, '', ' ') . ' ₽';
}

/**
 * @param string $name Name.
 * @return string
 */
function glitters_monogram($name) {
	$name = trim(wp_strip_all_tags($name));
	if ($name === '') {
		return 'G';
	}
	return mb_strtoupper(mb_substr($name, 0, 1));
}

/**
 * @param string $type Post type.
 * @return WP_Post[]
 */
function glitters_posts($type) {
	return get_posts(
		array(
			'post_type'      => $type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'no_found_rows'  => true,
		)
	);
}

/**
 * Role cards shown until real masters are published.
 *
 * @return array<int, array<string, string>>
 */
function glitters_role_cards() {
	return array(
		array(
			'role'  => 'Стилист',
			'focus' => 'Женские стрижки и форма',
			'text'  => 'Точная линия, понятная укладка и внимание к тому, как волосы живут в обычный день.',
		),
		array(
			'role'  => 'Колорист',
			'focus' => 'Цвет и сложные техники',
			'text'  => 'Спокойные оттенки, мягкие переходы и бережная работа с качеством волоса.',
		),
		array(
			'role'  => 'Мастер причёсок',
			'focus' => 'Укладки и свадебные образы',
			'text'  => 'Собранные и распущенные формы, которые держатся и остаются лёгкими.',
		),
	);
}

/**
 * Bundled stills from the salon's own walkthrough.
 *
 * @return array<int, array<string, string>>
 */
function glitters_bundled_gallery() {
	return array(
		array(
			'file'    => 'assets/images/salon-wash.jpg',
			'alt'     => 'Мойка и рабочая зона салона Glitters',
			'caption' => 'Рабочая зона',
			'class'   => 'look-wash',
		),
		array(
			'file'    => 'assets/images/salon-mirror.jpg',
			'alt'     => 'Кресло стилиста и зеркало в салоне Glitters',
			'caption' => 'Кресло стилиста',
			'class'   => 'look-mirror',
		),
		array(
			'file'    => 'assets/images/salon-attente.jpg',
			'alt'     => 'Тихий уголок салона Glitters',
			'caption' => 'Уголок отдыха',
			'class'   => 'look-wait',
		),
	);
}

/**
 * Attachment chosen as the hero, or 0 when the bundled photo should be used.
 *
 * @return int
 */
function glitters_hero_attachment_id() {
	$id = (int) glitters_get('hero_id');
	if ($id && wp_attachment_is_image($id)) {
		return $id;
	}
	$posts = get_posts(
		array(
			'post_type'      => 'glitters_interior',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);
	if ($posts) {
		$thumb = (int) get_post_thumbnail_id($posts[0]);
		if ($thumb) {
			return $thumb;
		}
	}
	return 0;
}

/**
 * @return string
 */
function glitters_map_src() {
	$lng = (string) glitters_get('lng');
	$lat = (string) glitters_get('lat');
	$oid = (string) glitters_get('map_oid');
	return 'https://yandex.ru/map-widget/v1/?ll=' . rawurlencode($lng . ',' . $lat) . '&z=16&mode=search&ol=biz&oid=' . rawurlencode($oid);
}

/**
 * Theme image tag.
 *
 * @param string               $relative Path inside the theme.
 * @param string               $alt      Alt text.
 * @param array<string,string> $attrs    Extra attributes.
 * @return string
 */
function glitters_theme_image($relative, $alt, $attrs = array()) {
	$path = GLITTERS_DIR . '/' . ltrim($relative, '/');
	$url  = GLITTERS_URI . '/' . ltrim($relative, '/');
	$size = file_exists($path) ? getimagesize($path) : false;
	$attrs = array_merge(
		array(
			'src'      => $url,
			'alt'      => $alt,
			'loading'  => 'lazy',
			'decoding' => 'async',
		),
		$attrs
	);
	if ($size) {
		$attrs['width']  = (string) $size[0];
		$attrs['height'] = (string) $size[1];
	}
	$html = '<img';
	foreach ($attrs as $name => $value) {
		$html .= ' ' . $name . '="' . esc_attr($value) . '"';
	}
	return $html . '>';
}

/**
 * @param bool $seo_plugin Whether an SEO plugin is active.
 * @return bool
 */
function glitters_has_seo_plugin() {
	return defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || defined('AIOSEO_VERSION') || defined('SEOPRESS_VERSION');
}
