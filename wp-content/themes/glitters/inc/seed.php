<?php
/**
 * First-run content: pages, services, language, permalinks.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Seed once, after post types exist.
 */
function glitters_maybe_seed() {
	if (get_option('glitters_seeded')) {
		return;
	}
	if (get_transient('glitters_seeding')) {
		return;
	}
	set_transient('glitters_seeding', 1, MINUTE_IN_SECONDS);
	glitters_seed();
	update_option('glitters_seeded', 1);
	flush_rewrite_rules(false);
	delete_transient('glitters_seeding');
}

/**
 * Download ru_RU when an administrator opens the dashboard.
 */
function glitters_maybe_russian() {
	if (get_option('WPLANG') === 'ru_RU') {
		return;
	}
	if (!current_user_can('update_core') && !current_user_can('install_languages')) {
		return;
	}
	require_once ABSPATH . 'wp-admin/includes/translation-install.php';
	if (function_exists('wp_download_language_pack')) {
		wp_download_language_pack('ru_RU');
	}
	update_option('WPLANG', 'ru_RU');
}

/**
 * Create the front page, legal pages and services.
 */
function glitters_seed() {
	if (get_option('timezone_string') === '') {
		update_option('timezone_string', 'Europe/Moscow');
	}
	if (get_option('permalink_structure') === '') {
		update_option('permalink_structure', '/%postname%/');
	}
	if (in_array(get_option('blogname'), array('WordPress', 'Мой сайт', 'Мой первый сайт'), true)) {
		update_option('blogname', 'Glitters');
	}
	$description = (string) get_option('blogdescription');
	if ($description === '' || $description === 'Just another WordPress site' || $description === 'Ещё один сайт на WordPress') {
		update_option('blogdescription', 'Женский салон красоты и студия ухода за волосами в Санкт-Петербурге');
	}

	$front = glitters_ensure_page(
		'glavnaya',
		'Главная',
		'<!-- Главная страница собирается темой Glitters. Услуги, мастера, отзывы, фотографии и тексты редактируются в меню Glitters. -->'
	);
	if ($front) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $front);
	}

	$privacy = glitters_ensure_page('politika-konfidentsialnosti', 'Политика конфиденциальности', glitters_privacy_html());
	$legal   = glitters_ensure_page('pravovaya-informatsiya', 'Правовая информация', glitters_legal_html());
	if ($privacy) {
		update_option('glitters_page_privacy', $privacy);
		update_option('wp_page_for_privacy_policy', $privacy);
	}
	if ($legal) {
		update_option('glitters_page_legal', $legal);
	}

	if (!glitters_posts('glitters_service')) {
		glitters_seed_services();
	}
}

/**
 * @param string $slug    Slug.
 * @param string $title   Title.
 * @param string $content Content.
 * @return int
 */
function glitters_ensure_page($slug, $title, $content) {
	$existing = get_page_by_path($slug);
	if ($existing) {
		return (int) $existing->ID;
	}
	$page = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
		),
		true
	);
	return is_wp_error($page) ? 0 : (int) $page;
}

/**
 * Eight services. Prices stay empty until the salon enters them.
 */
function glitters_seed_services() {
	$services = array(
		array(
			'slug'    => 'zhenskie-strizhki',
			'title'   => 'Женские стрижки',
			'excerpt' => 'Точная форма и мягкая линия, которые держат объём и легко собираются дома.',
			'content' => "<p>Стрижка в Glitters начинается с разговора: как вы носите волосы, сколько времени уходит на укладку, что хочется сохранить. Мастер смотрит на плотность, рост и черты лица и предлагает форму, которую вы сможете повторить.</p><p>Мы не усложняем образ ради сложности. Линия должна быть чистой, объём — живым, а контур — спокойным даже на второй неделе.</p>",
		),
		array(
			'slug'    => 'okrashivanie-volos',
			'title'   => 'Окрашивание волос',
			'excerpt' => 'Ровный тон, благородные оттенки и бережная работа с качеством волоса.',
			'content' => "<p>Цвет подбирается к коже, глазам и тому, сколько своего пигмента уже есть. Мы красим ровно и заранее говорим, как оттенок будет жить.</p><p>Если волосы уже окрашены, сначала оцениваем их состояние. Иногда честнее обновить тон мягко, чем обещать мгновенную смену цвета.</p>",
		),
		array(
			'slug'    => 'melirovanie',
			'title'   => 'Мелирование и сложные техники окрашивания',
			'excerpt' => 'Мягкий свет, глубина и естественный переход — от балаяжа до сложных техник.',
			'content' => "<p>Сложные техники — это не яркость любой ценой, а свет, который выглядит естественно. Балаяж, шатуш, эйртач и близкие методы помогают расставить блики и глубину так, чтобы отрастание было спокойным.</p><p>Технику выбираем по плотности волос и по тому, сколько времени вы готовы уделять уходу. До окрашивания объясняем, что изменится.</p>",
		),
		array(
			'slug'    => 'ukladki-i-lokony',
			'title'   => 'Укладки и локоны',
			'excerpt' => 'Спокойный объём, гладкость или локоны — на день и на выход.',
			'content' => "<p>Укладка на каждый день, к встрече или к вечеру. Гладкий объём, мягкая волна или собранные локоны — по случаю и по состоянию волос.</p><p>Мы фиксируем причёску так, чтобы она оставалась подвижной.</p>",
		),
		array(
			'slug'    => 'uhod-i-vosstanovlenie',
			'title'   => 'Уход и восстановление волос',
			'excerpt' => 'Питание, блеск и плотность без утяжеления. Волосы остаются живыми на ощупь.',
			'content' => "<p>Восстановление — это ритуал, а не маска на пять минут. Смотрим на сухость, пористость и концы, затем собираем уход: питание, блеск и более плотное ощущение волоса без эффекта плёнки.</p><p>После процедуры подскажем, что стоит менять в домашнем уходе, а что можно оставить.</p>",
		),
		array(
			'slug'    => 'keratinovoe-vypryamlenie',
			'title'   => 'Кератиновое выпрямление',
			'excerpt' => 'Гладкость и дисциплина для непослушных волос, с зеркальным блеском.',
			'content' => "<p>Кератиновое выпрямление подходит тем, кому нужна гладкость и более послушный волос. Мы рассказываем, как пройдёт процедура, сколько обычно держится эффект и как ухаживать в первые дни.</p><p>Срок зависит от исходного волоса и домашнего ухода. Одинаковый результат всем не обещаем.</p>",
		),
		array(
			'slug'    => 'prazdnichnye-pricheski',
			'title'   => 'Праздничные и свадебные причёски',
			'excerpt' => 'Образ для торжества: собранный, лёгкий и рассчитанный на весь день.',
			'content' => "<p>Свадьба, ужин или семейный день. Собираем причёску, которая выдерживает время и при этом не тянет.</p><p>Лучше прийти на короткое обсуждение заранее — так в день события всё идёт спокойно.</p>",
		),
		array(
			'slug'    => 'konsultaciya-stilista',
			'title'   => 'Консультация стилиста',
			'excerpt' => 'Короткий разговор о форме, цвете и уходе — до того, как начнётся работа.',
			'content' => "<p>Консультация — отдельная встреча, если вы выбираете между формой, цветом и уходом и не хотите решать на ходу. Смотрим волосы и говорим, какой шаг разумный первым.</p><p>После разговора можно сразу записаться на работу или взять паузу.</p>",
		),
	);

	$order = 1;
	foreach ($services as $service) {
		$id = wp_insert_post(
			array(
				'post_type'    => 'glitters_service',
				'post_status'  => 'publish',
				'post_title'   => $service['title'],
				'post_name'    => $service['slug'],
				'post_excerpt' => $service['excerpt'],
				'post_content' => $service['content'],
				'menu_order'   => $order,
			),
			true
		);
		if (!is_wp_error($id)) {
			$order++;
		}
	}
}
