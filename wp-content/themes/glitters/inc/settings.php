<?php
/**
 * Salon settings and a short owner dashboard.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('admin_menu', 'glitters_admin_menu');
add_action('admin_post_glitters_save_settings', 'glitters_save_settings');
add_action('admin_enqueue_scripts', 'glitters_admin_assets');

/**
 * Glitters menu.
 */
function glitters_admin_menu() {
	add_menu_page('Glitters', 'Glitters', 'edit_posts', 'glitters', 'glitters_dashboard_page', 'dashicons-store', 26);
	add_submenu_page('glitters', 'Обзор', 'Обзор', 'edit_posts', 'glitters', 'glitters_dashboard_page');
	add_submenu_page('glitters', 'Настройки сайта', 'Настройки', 'manage_options', 'glitters-settings', 'glitters_settings_page');
}

/**
 * @param string $hook Current admin page.
 */
function glitters_admin_assets($hook) {
	if ($hook !== 'glitters_page_glitters-settings') {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script('glitters-admin', GLITTERS_URI . '/assets/js/admin.js', array('jquery'), GLITTERS_VERSION, true);
}

/**
 * Owner checklist in Russian.
 */
function glitters_dashboard_page() {
	if (!current_user_can('edit_posts')) {
		return;
	}
	echo '<div class="wrap">';
	echo '<h1>Glitters</h1>';
	echo '<p>Светлая и тёмная тема переключаются сами: сайт повторяет режим телефона или компьютера. Менять её вручную не нужно.</p>';
	echo '<p>Всё, что видит гость, правится здесь, без правки файлов темы.</p>';
	echo '<ol>';
	echo '<li><a href="' . esc_url(admin_url('edit.php?post_type=glitters_service')) . '">Услуги</a> — название, описание и цена «от» числом. Пустая цена показывает фразу из настроек.</li>';
	echo '<li><a href="' . esc_url(admin_url('edit.php?post_type=glitters_master')) . '">Мастера</a> — имя, специализация, биография и портрет. Пока список пуст, на сайте три карточки из настроек, без вымышленных имён.</li>';
	echo '<li><a href="' . esc_url(admin_url('edit.php?post_type=glitters_review')) . '">Отзывы</a> — только реальные. Имя гостя — заголовок записи, текст отзыва — содержимое, оценка — поле под редактором.</li>';
	echo '<li><a href="' . esc_url(admin_url('edit.php?post_type=glitters_interior')) . '">Интерьер</a> — фотография и подпись. Опубликованные снимки заменяют встроенные кадры.</li>';
	echo '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '">Меню</a> — назначьте меню на «Главное меню», если нужны другие пункты. Пока меню не назначено, подписи берутся из настроек.</li>';
	echo '<li><a href="' . esc_url(admin_url('edit.php?post_type=page')) . '">Страницы</a> — политика и правовая информация редактируются как обычные страницы. Метки {{phone}}, {{address}} и {{hours}} подставляют телефон, адрес и часы из настроек.</li>';
	echo '<li><a href="' . esc_url(admin_url('customize.php')) . '">Логотип</a> — Внешний вид → Настроить → Свойства сайта.</li>';
	echo '<li><a href="' . esc_url(admin_url('edit.php?post_type=glitters_request')) . '">Заявки</a> — сообщения формы хранятся здесь, даже если письмо не ушло.</li>';
	if (current_user_can('manage_options')) {
		echo '<li><a href="' . esc_url(admin_url('admin.php?page=glitters-settings')) . '">Настройки</a> — телефон, запись, карта и все тексты главной.</li>';
	}
	echo '</ol>';
	echo '</div>';
}

/**
 * Settings form.
 */
function glitters_settings_page() {
	if (!current_user_can('manage_options')) {
		return;
	}
	$hero_id = (int) glitters_get('hero_id');
	$preview = $hero_id ? wp_get_attachment_image($hero_id, 'medium') : '';
	echo '<div class="wrap"><h1>Настройки Glitters</h1>';
	if (isset($_GET['updated'])) {
		echo '<div class="notice notice-success"><p>Настройки сохранены.</p></div>';
	}
	echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
	echo '<input type="hidden" name="action" value="glitters_save_settings">';
	wp_nonce_field('glitters_save_settings');

	echo '<h2>Контакты</h2><table class="form-table">';
	glitters_settings_field('phone_display', 'Телефон', 'text');
	glitters_settings_field('phone_href', 'Телефон для ссылки', 'text');
	glitters_settings_field('email_form', 'Почта для заявок', 'email');
	glitters_settings_field('address', 'Адрес', 'text');
	glitters_settings_field('district', 'Ориентир', 'text');
	glitters_settings_field('hours', 'Часы работы', 'text');
	glitters_settings_field('opens', 'Открытие для микроразметки', 'time');
	glitters_settings_field('closes', 'Закрытие для микроразметки', 'time');
	glitters_settings_field('whatsapp', 'Ссылка WhatsApp', 'url');
	glitters_settings_field('telegram', 'Ссылка Telegram', 'url');
	echo '</table>';

	echo '<h2>Онлайн-запись</h2><table class="form-table">';
	glitters_settings_field('yandex_booking', 'Ссылка Яндекс', 'url');
	glitters_settings_field('dikidi', 'Ссылка Dikidi', 'url');
	glitters_settings_field('yandex_map', 'Карточка на Яндекс Картах', 'url');
	glitters_settings_field('map_oid', 'Идентификатор организации Яндекса', 'text');
	glitters_settings_field('lat', 'Широта', 'text');
	glitters_settings_field('lng', 'Долгота', 'text');
	echo '</table>';

	echo '<h2>Главное фото</h2>';
	echo '<p>Если фото не выбрано, сайт показывает встроенный кадр зала. Новые снимки из раздела «Интерьер» тоже могут занять этот экран: берётся первое фото по порядку.</p>';
	echo '<input type="hidden" id="glitters_hero_id" name="hero_id" value="' . esc_attr((string) $hero_id) . '">';
	echo '<div class="glitters-hero-preview">' . $preview . '</div>';
	echo '<p><button type="button" class="button glitters-pick-hero">Выбрать фото</button> <button type="button" class="button glitters-clear-hero">Вернуть встроенное фото</button></p>';
	$film = (int) glitters_get('show_film') === 1;
	echo '<p><label><input type="checkbox" name="show_film" value="1" ' . checked($film, true, false) . '> Показывать короткий фильм об интерьере</label></p>';

	echo '<h2>Тексты</h2>';
	echo '<p>Услуги, мастера, отзывы, фотографии интерьера и юридические страницы правятся в своих разделах меню слева. Здесь — остальные фразы главной. Пустое поле возвращает исходный текст.</p>';
	$labels = glitters_text_labels();
	foreach (glitters_text_groups() as $group => $keys) {
		echo '<h3>' . esc_html($group) . '</h3><table class="form-table">';
		foreach ($keys as $key) {
			$label = $labels[$key] ?? $key;
			echo '<tr><th scope="row"><label for="tx_' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
			if (glitters_text_is_long($key)) {
				echo '<textarea class="large-text" rows="5" id="tx_' . esc_attr($key) . '" name="tx_' . esc_attr($key) . '">' . esc_textarea(glitters_text($key)) . '</textarea>';
			} else {
				echo '<input class="large-text" type="text" id="tx_' . esc_attr($key) . '" name="tx_' . esc_attr($key) . '" value="' . esc_attr(glitters_text($key)) . '">';
			}
			echo '</td></tr>';
		}
		echo '</table>';
	}

	echo '<h2>Проверка сайта</h2><table class="form-table">';
	glitters_settings_field('yandex_verification', 'Код Яндекс.Вебмастер', 'text');
	glitters_settings_field('google_verification', 'Код Google Search Console', 'text');
	$force = (int) glitters_get('force_schema') === 1;
	echo '<tr><th scope="row">Микроразметка</th><td><label><input type="checkbox" name="force_schema" value="1" ' . checked($force, true, false) . '> Дублировать микроразметку темы, даже если установлен SEO-плагин</label><p class="description">По умолчанию тема сама выводит LocalBusiness и уступает, если установлены Rank Math, Yoast, AIOSEO или SEOPress.</p></td></tr>';
	echo '</table>';

	submit_button('Сохранить');
	echo '</form></div>';
}

/**
 * @param string $key  Setting key.
 * @param string $label Label.
 * @param string $type Input type.
 */
function glitters_settings_field($key, $label, $type) {
	$value = (string) glitters_get($key);
	echo '<tr><th scope="row"><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
	echo '<input class="regular-text" type="' . esc_attr($type) . '" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
	echo '</td></tr>';
}

/**
 * Save settings.
 */
function glitters_save_settings() {
	if (!current_user_can('manage_options')) {
		wp_die('Недостаточно прав.');
	}
	check_admin_referer('glitters_save_settings');

	$clean = array();
	$text_keys = array('phone_display', 'phone_href', 'address', 'district', 'hours', 'opens', 'closes', 'map_oid', 'lat', 'lng', 'yandex_verification', 'google_verification');
	foreach ($text_keys as $key) {
		$clean[$key] = isset($_POST[$key]) ? sanitize_text_field(wp_unslash($_POST[$key])) : '';
	}
	$url_keys = array('email_form' => 'email', 'yandex_booking' => 'url', 'dikidi' => 'url', 'yandex_map' => 'url', 'whatsapp' => 'url', 'telegram' => 'url');
	foreach ($url_keys as $key => $kind) {
		$raw = isset($_POST[$key]) ? wp_unslash($_POST[$key]) : '';
		if ($kind === 'email') {
			$clean[$key] = sanitize_email($raw);
		} else {
			$clean[$key] = esc_url_raw($raw);
		}
	}
	$clean['hero_id']      = isset($_POST['hero_id']) ? absint($_POST['hero_id']) : 0;
	$clean['show_film']    = isset($_POST['show_film']) ? 1 : 0;
	$clean['force_schema'] = isset($_POST['force_schema']) ? 1 : 0;

	foreach (glitters_default_texts() as $key => $default) {
		$raw = isset($_POST['tx_' . $key]) ? sanitize_textarea_field(wp_unslash($_POST['tx_' . $key])) : '';
		$clean['tx_' . $key] = trim($raw) === trim($default) ? '' : $raw;
	}

	update_option('glitters_settings', $clean);
	wp_safe_redirect(admin_url('admin.php?page=glitters-settings&updated=1'));
	exit;
}
