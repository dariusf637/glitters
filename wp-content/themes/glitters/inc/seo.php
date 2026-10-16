<?php
/**
 * Local SEO. Yields to Yoast, Rank Math, AIOSEO and SEOPress.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

add_filter('pre_get_document_title', 'glitters_document_title');
add_filter('document_title_parts', 'glitters_title_parts');
add_action('wp_head', 'glitters_meta_tags', 1);
add_action('wp_head', 'glitters_schema', 20);

/**
 * @param string $title Title.
 * @return string
 */
function glitters_document_title($title) {
	if (glitters_has_seo_plugin()) {
		return $title;
	}
	if (is_front_page()) {
		return 'Glitters — женский салон красоты в Санкт-Петербурге, ул. Правды, 16';
	}
	return $title;
}

/**
 * @param array<string, string> $parts Title parts.
 * @return array<string, string>
 */
function glitters_title_parts($parts) {
	if (glitters_has_seo_plugin()) {
		return $parts;
	}
	if (is_singular('glitters_service')) {
		$parts['title'] = get_the_title() . ' — Glitters';
		$parts['site']  = 'Санкт-Петербург, ул. Правды, 16';
	}
	return $parts;
}

/**
 * Meta description, Open Graph and verification tags.
 */
function glitters_meta_tags() {
	if (glitters_has_seo_plugin()) {
		glitters_verification_tags();
		return;
	}
	$description = glitters_meta_description();
	echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
	echo '<meta property="og:locale" content="ru_RU">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url(glitters_current_url()) . '">' . "\n";
	$image = glitters_share_image();
	if ($image) {
		echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
	}
	echo '<meta name="geo.placename" content="Санкт-Петербург">' . "\n";
	echo '<meta name="geo.region" content="RU-SPE">' . "\n";
	echo '<meta name="geo.position" content="' . esc_attr(glitters_get('lat') . ';' . glitters_get('lng')) . '">' . "\n";
	glitters_verification_tags();
}

/**
 * Verification meta is useful even when an SEO plugin owns the description.
 */
function glitters_verification_tags() {
	$yandex = (string) glitters_get('yandex_verification');
	$google = (string) glitters_get('google_verification');
	if ($yandex !== '') {
		echo '<meta name="yandex-verification" content="' . esc_attr($yandex) . '">' . "\n";
	}
	if ($google !== '') {
		echo '<meta name="google-site-verification" content="' . esc_attr($google) . '">' . "\n";
	}
}

/**
 * @return string
 */
function glitters_meta_description() {
	if (is_front_page()) {
		return 'Женский салон красоты и студия ухода за волосами Glitters в Санкт-Петербурге. Стрижки, окрашивание, укладки и уход за волосами. Онлайн-запись.';
	}
	if (is_singular('glitters_service')) {
		$text = wp_strip_all_tags(get_the_excerpt());
		$text = trim($text . ' Салон Glitters, ул. Правды, 16, Санкт-Петербург.');
		return mb_substr($text, 0, 180);
	}
	if (is_page()) {
		$text = trim(wp_strip_all_tags(get_the_excerpt()));
		if ($text !== '') {
			return mb_substr($text, 0, 180);
		}
	}
	return 'Женский салон красоты Glitters в Санкт-Петербурге, ул. Правды, 16. Онлайн-запись ежедневно с 09:00 до 21:00.';
}

/**
 * @return string
 */
function glitters_current_url() {
	if (is_singular()) {
		return (string) get_permalink();
	}
	return home_url('/');
}

/**
 * @return string
 */
function glitters_share_image() {
	$id = glitters_hero_attachment_id();
	if ($id) {
		$url = wp_get_attachment_image_url($id, 'full');
		if ($url) {
			return $url;
		}
	}
	return GLITTERS_URI . '/assets/images/salon-hero.jpg';
}

/**
 * HairSalon JSON-LD. No self-serving review markup.
 */
function glitters_schema() {
	$forced = (int) glitters_get('force_schema') === 1;
	if (glitters_has_seo_plugin() && !$forced) {
		return;
	}

	$offers = array();
	foreach (glitters_posts('glitters_service') as $service) {
		$offer = array(
			'@type'         => 'Offer',
			'availability'  => 'https://schema.org/InStock',
			'itemOffered'   => array(
				'@type'       => 'Service',
				'name'        => get_the_title($service),
				'description' => wp_strip_all_tags(get_the_excerpt($service)),
				'url'         => get_permalink($service),
			),
		);
		$price = (int) get_post_meta($service->ID, 'price_from', true);
		if ($price > 0) {
			$offer['priceSpecification'] = array(
				'@type'         => 'PriceSpecification',
				'minPrice'      => $price,
				'priceCurrency' => 'RUB',
			);
		}
		$offers[] = $offer;
	}

	$same = array_filter(
		array(
			(string) glitters_get('yandex_map'),
			(string) glitters_get('dikidi'),
		)
	);

	$data = array(
		'@context'    => 'https://schema.org',
		'@type'       => array('HairSalon', 'BeautySalon'),
		'@id'         => home_url('/#salon'),
		'name'        => 'Glitters',
		'description' => 'Женский салон красоты и студия ухода за волосами Glitters в Санкт-Петербурге. Стрижки, окрашивание, укладки и уход за волосами. Онлайн-запись.',
		'url'         => home_url('/'),
		'image'       => glitters_share_image(),
		'telephone'   => glitters_schema_phone(),
		'priceRange'  => '₽₽₽',
		'currenciesAccepted' => 'RUB',
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'ул. Правды, 16',
			'addressLocality' => 'Санкт-Петербург',
			'addressRegion'   => 'Санкт-Петербург',
			'addressCountry'  => 'RU',
		),
		'geo'         => array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => (float) glitters_get('lat'),
			'longitude' => (float) glitters_get('lng'),
		),
		'hasMap'      => glitters_get('yandex_map'),
		'openingHoursSpecification' => array(
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
				'opens'     => glitters_get('opens'),
				'closes'    => glitters_get('closes'),
			),
		),
		'areaServed'  => 'Санкт-Петербург',
		'inLanguage'  => 'ru-RU',
		'sameAs'      => array_values($same),
		'makesOffer'  => $offers,
	);

	echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
