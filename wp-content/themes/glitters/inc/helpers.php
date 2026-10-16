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
		'logo_sub'         => 'салон красоты',
		'hero_kicker'      => 'Санкт-Петербург · ул. Правды, 16',
		'hero_title'       => 'Glitters — забота о вашей красоте в центре Санкт-Петербурга',
		'hero_subtitle'    => 'Женский салон красоты и студия ухода за волосами на ул. Правды,' . "\u{00A0}" . '16',
		'hero_alt'         => 'Интерьер салона Glitters: витрина средств и зона укладки',
		'btn_book'         => 'Записаться онлайн',
		'btn_services'     => 'Посмотреть услуги',
		'btn_yandex'       => 'Записаться через Яндекс',
		'btn_dikidi'       => 'Записаться через Dikidi',
		'btn_call'         => 'Позвонить',
		'btn_book_short'   => 'Записаться',
		'btn_home'         => 'На главную',
		'nav_about'        => 'О салоне',
		'nav_interior'     => 'Интерьер',
		'nav_services'     => 'Услуги',
		'nav_masters'      => 'Мастера',
		'nav_reviews'      => 'Отзывы',
		'nav_contacts'     => 'Контакты',
		'eyebrow_about'    => 'О салоне',
		'about_title'      => 'Частное пространство для женщин, которые ценят тишину и точность',
		'about_text'       => "Glitters — женский салон красоты и студия ухода за волосами в Санкт-Петербурге, на улице Правды, 16. Здесь нет случайной спешки: каждая встреча начинается с разговора, а работа строится вокруг ваших волос, черт и привычного ритма жизни.\n\nКамерный интерьер, опытные специалисты и профессиональные средства — чтобы вы уходили с ощущением собранности и спокойной красоты.",
		'pillar_1_title'   => 'Приватность',
		'pillar_1_text'    => 'Камерный зал и запись по времени. Визит проходит без суеты и постороннего внимания.',
		'pillar_2_title'   => 'Персональное внимание',
		'pillar_2_text'    => 'Форма, оттенок и уход подбираются лично. Решение объясняем спокойно и по существу.',
		'pillar_3_title'   => 'Опыт мастеров',
		'pillar_3_text'    => 'Точная техника, аккуратная работа с цветом и уважение к качеству волоса.',
		'pillar_4_title'   => 'Комфорт',
		'pillar_4_text'    => 'Продуманное пространство, профессиональные средства и деликатное отношение к вашему времени.',
		'eyebrow_interior' => 'Интерьер салона',
		'interior_text'    => 'Атмосфера уюта, стиля и заботы в каждой детали',
		'film_caption'     => 'Фильм о зале',
		'film_alt'         => 'Короткий фильм об интерьере салона Glitters',
		'film_pause'       => 'Пауза',
		'film_play'        => 'Смотреть',
		'caption_wash'     => 'Рабочая зона',
		'caption_mirror'   => 'Кресло стилиста',
		'caption_wait'     => 'Уголок отдыха',
		'eyebrow_services' => 'Услуги',
		'services_title'   => 'Уход, цвет и форма — в одном внимательном месте',
		'price_note'       => 'Стоимость уточняется при записи',
		'services_empty'   => 'Услуги скоро появятся в этом разделе.',
		'eyebrow_booking'  => 'Онлайн-запись',
		'booking_title'    => 'Запишитесь в удобное время',
		'booking_text'     => 'Выберите удобный способ онлайн-записи — мы подтвердим ваше посещение.',
		'booking_or'       => 'Или позвоните:',
		'eyebrow_masters'  => 'Мастера',
		'masters_title'    => 'Специалисты салона',
		'masters_intro'    => 'Стрижка, цвет и укладка — в руках людей, которые работают спокойно и точно.',
		'role_1_title'     => 'Стилист',
		'role_1_focus'     => 'Женские стрижки и форма',
		'role_1_text'      => 'Точная линия, понятная укладка и внимание к тому, как волосы живут в обычный день.',
		'role_2_title'     => 'Колорист',
		'role_2_focus'     => 'Цвет и сложные техники',
		'role_2_text'      => 'Спокойные оттенки, мягкие переходы и бережная работа с качеством волоса.',
		'role_3_title'     => 'Мастер причёсок',
		'role_3_focus'     => 'Укладки и свадебные образы',
		'role_3_text'      => 'Собранные и распущенные формы, которые держатся и остаются лёгкими.',
		'eyebrow_reviews'  => 'Отзывы',
		'reviews_title'    => 'Слова наших гостей',
		'reviews_empty'    => 'После визита нам важно услышать, как вы себя чувствуете. Здесь появятся отзывы гостей — позже их можно дополнить отзывами с Яндекс Карт и Google.',
		'eyebrow_contacts' => 'Контакты',
		'contacts_title'   => 'Ждём вас на улице Правды',
		'label_address'    => 'Адрес',
		'label_phone'      => 'Телефон',
		'label_hours'      => 'Часы',
		'label_whatsapp'   => 'Написать в WhatsApp',
		'label_telegram'   => 'Написать в Telegram',
		'form_name'        => 'Имя',
		'form_phone'       => 'Телефон',
		'form_service'     => 'Услуга',
		'form_service_pick'=> 'Выберите услугу',
		'form_message'     => 'Сообщение',
		'form_consent'     => 'Я соглашаюсь на обработку персональных данных в соответствии с',
		'form_submit'      => 'Отправить заявку',
		'form_success'     => 'Спасибо. Мы получили вашу заявку и свяжемся с вами, чтобы подтвердить визит.',
		'map_open'         => 'Открыть в Яндекс Картах',
		'footer_about'     => 'Женский салон красоты и студия ухода за волосами.',
		'footer_place'     => 'Glitters. Санкт-Петербург.',
		'footer_offer'     => 'Информация на сайте не является публичной офертой.',
		'notfound_title'   => 'Такой страницы нет',
		'notfound_text'    => 'Возможно, ссылка устарела. Вернитесь на главную или запишитесь онлайн.',
	);
}

/**
 * Russian labels for the settings screen.
 *
 * @return array<string, string>
 */
function glitters_text_labels() {
	return array(
		'logo_sub'         => 'Подпись под логотипом',
		'hero_kicker'      => 'Строка над заголовком',
		'hero_title'       => 'Главный заголовок',
		'hero_subtitle'    => 'Подзаголовок',
		'hero_alt'         => 'Описание главного фото',
		'btn_book'         => 'Кнопка записи',
		'btn_services'     => 'Кнопка услуг',
		'btn_yandex'       => 'Кнопка Яндекс',
		'btn_dikidi'       => 'Кнопка Dikidi',
		'btn_call'         => 'Кнопка звонка',
		'btn_book_short'   => 'Короткая ссылка «Записаться»',
		'btn_home'         => 'Кнопка «На главную»',
		'nav_about'        => 'Пункт меню: салон',
		'nav_interior'     => 'Пункт меню: интерьер',
		'nav_services'     => 'Пункт меню: услуги',
		'nav_masters'      => 'Пункт меню: мастера',
		'nav_reviews'      => 'Пункт меню: отзывы',
		'nav_contacts'     => 'Пункт меню: контакты',
		'eyebrow_about'    => 'Малая подпись раздела',
		'about_title'      => 'Заголовок',
		'about_text'       => 'Текст. Пустая строка между абзацами начинает новый абзац.',
		'pillar_1_title'   => 'Карточка 1 — заголовок',
		'pillar_1_text'    => 'Карточка 1 — текст',
		'pillar_2_title'   => 'Карточка 2 — заголовок',
		'pillar_2_text'    => 'Карточка 2 — текст',
		'pillar_3_title'   => 'Карточка 3 — заголовок',
		'pillar_3_text'    => 'Карточка 3 — текст',
		'pillar_4_title'   => 'Карточка 4 — заголовок',
		'pillar_4_text'    => 'Карточка 4 — текст',
		'eyebrow_interior' => 'Малая подпись раздела',
		'interior_text'    => 'Заголовок',
		'film_caption'     => 'Подпись к фильму',
		'film_alt'         => 'Описание фильма',
		'film_pause'       => 'Кнопка паузы',
		'film_play'        => 'Кнопка воспроизведения',
		'caption_wash'     => 'Подпись кадра: мойка',
		'caption_mirror'   => 'Подпись кадра: кресло',
		'caption_wait'     => 'Подпись кадра: отдых',
		'eyebrow_services' => 'Малая подпись раздела',
		'services_title'   => 'Заголовок',
		'price_note'       => 'Текст, если цена не указана',
		'services_empty'   => 'Текст, если услуг ещё нет',
		'eyebrow_booking'  => 'Малая подпись раздела',
		'booking_title'    => 'Заголовок',
		'booking_text'     => 'Пояснение',
		'booking_or'       => 'Строка перед телефоном',
		'eyebrow_masters'  => 'Малая подпись раздела',
		'masters_title'    => 'Заголовок',
		'masters_intro'    => 'Вступление',
		'role_1_title'     => 'Карточка 1 — роль',
		'role_1_focus'     => 'Карточка 1 — специализация',
		'role_1_text'      => 'Карточка 1 — текст',
		'role_2_title'     => 'Карточка 2 — роль',
		'role_2_focus'     => 'Карточка 2 — специализация',
		'role_2_text'      => 'Карточка 2 — текст',
		'role_3_title'     => 'Карточка 3 — роль',
		'role_3_focus'     => 'Карточка 3 — специализация',
		'role_3_text'      => 'Карточка 3 — текст',
		'eyebrow_reviews'  => 'Малая подпись раздела',
		'reviews_title'    => 'Заголовок',
		'reviews_empty'    => 'Текст, пока отзывов нет',
		'eyebrow_contacts' => 'Малая подпись раздела',
		'contacts_title'   => 'Заголовок',
		'label_address'    => 'Подпись «адрес»',
		'label_phone'      => 'Подпись «телефон»',
		'label_hours'      => 'Подпись «часы»',
		'label_whatsapp'   => 'Кнопка WhatsApp',
		'label_telegram'   => 'Кнопка Telegram',
		'form_name'        => 'Поле имени',
		'form_phone'       => 'Поле телефона',
		'form_service'     => 'Поле услуги',
		'form_service_pick'=> 'Пустой пункт списка услуг',
		'form_message'     => 'Поле сообщения',
		'form_consent'     => 'Текст согласия. Ссылка на политику добавляется следом.',
		'form_submit'      => 'Кнопка отправки',
		'form_success'     => 'Сообщение после отправки',
		'map_open'         => 'Ссылка на карту',
		'footer_about'     => 'Короткая подпись салона',
		'footer_place'     => 'Строка рядом с годом',
		'footer_offer'     => 'Оговорка внизу страницы',
		'notfound_title'   => 'Заголовок страницы 404',
		'notfound_text'    => 'Текст страницы 404',
	);
}

/**
 * @return array<string, string[]>
 */
function glitters_text_groups() {
	return array(
		'Шапка и кнопки'     => array('logo_sub', 'btn_book', 'btn_services', 'btn_yandex', 'btn_dikidi', 'btn_call', 'btn_book_short', 'btn_home'),
		'Меню'               => array('nav_about', 'nav_interior', 'nav_services', 'nav_masters', 'nav_reviews', 'nav_contacts'),
		'Главный экран'      => array('hero_kicker', 'hero_title', 'hero_subtitle', 'hero_alt'),
		'О салоне'           => array('eyebrow_about', 'about_title', 'about_text', 'pillar_1_title', 'pillar_1_text', 'pillar_2_title', 'pillar_2_text', 'pillar_3_title', 'pillar_3_text', 'pillar_4_title', 'pillar_4_text'),
		'Интерьер'           => array('eyebrow_interior', 'interior_text', 'film_caption', 'film_alt', 'film_pause', 'film_play', 'caption_wash', 'caption_mirror', 'caption_wait'),
		'Услуги'             => array('eyebrow_services', 'services_title', 'price_note', 'services_empty'),
		'Запись'             => array('eyebrow_booking', 'booking_title', 'booking_text', 'booking_or'),
		'Мастера'            => array('eyebrow_masters', 'masters_title', 'masters_intro', 'role_1_title', 'role_1_focus', 'role_1_text', 'role_2_title', 'role_2_focus', 'role_2_text', 'role_3_title', 'role_3_focus', 'role_3_text'),
		'Отзывы'             => array('eyebrow_reviews', 'reviews_title', 'reviews_empty'),
		'Контакты и форма'   => array('eyebrow_contacts', 'contacts_title', 'label_address', 'label_phone', 'label_hours', 'label_whatsapp', 'label_telegram', 'form_name', 'form_phone', 'form_service', 'form_service_pick', 'form_message', 'form_consent', 'form_submit', 'form_success', 'map_open'),
		'Подвал и страница 404' => array('footer_about', 'footer_place', 'footer_offer', 'notfound_title', 'notfound_text'),
	);
}

/**
 * @param string $key Text key.
 * @return bool
 */
function glitters_text_is_long($key) {
	return in_array($key, array('about_text', 'reviews_empty', 'masters_intro', 'form_consent', 'notfound_text', 'pillar_1_text', 'pillar_2_text', 'pillar_3_text', 'pillar_4_text', 'role_1_text', 'role_2_text', 'role_3_text'), true);
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
		'about'    => glitters_text('nav_about'),
		'interior' => glitters_text('nav_interior'),
		'services' => glitters_text('nav_services'),
		'masters'  => glitters_text('nav_masters'),
		'reviews'  => glitters_text('nav_reviews'),
		'contacts' => glitters_text('nav_contacts'),
	);
}

/**
 * Title of a seeded legal page, so the owner edits it with the page.
 *
 * @param string $key privacy|legal.
 * @return string
 */
function glitters_page_label($key) {
	$id = (int) get_option('glitters_page_' . $key);
	if ($id && get_post_status($id) === 'publish') {
		$title = get_the_title($id);
		if ($title !== '') {
			return $title;
		}
	}
	$fallbacks = array(
		'privacy' => 'Политика конфиденциальности',
		'legal'   => 'Правовая информация',
	);
	return $fallbacks[$key] ?? '';
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
	$cards = array();
	for ($i = 1; $i <= 3; $i++) {
		$cards[] = array(
			'role'  => glitters_text('role_' . $i . '_title'),
			'focus' => glitters_text('role_' . $i . '_focus'),
			'text'  => glitters_text('role_' . $i . '_text'),
		);
	}
	return $cards;
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
			'alt'     => glitters_text('caption_wash'),
			'caption' => glitters_text('caption_wash'),
			'class'   => 'look-wash',
		),
		array(
			'file'    => 'assets/images/salon-mirror.jpg',
			'alt'     => glitters_text('caption_mirror'),
			'caption' => glitters_text('caption_mirror'),
			'class'   => 'look-mirror',
		),
		array(
			'file'    => 'assets/images/salon-attente.jpg',
			'alt'     => glitters_text('caption_wait'),
			'caption' => glitters_text('caption_wait'),
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
