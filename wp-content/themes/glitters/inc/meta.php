<?php
/**
 * Prices, specialties and ratings.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('add_meta_boxes', 'glitters_meta_boxes');
add_action('save_post', 'glitters_save_meta');
add_filter('manage_glitters_service_posts_columns', 'glitters_service_columns');
add_action('manage_glitters_service_posts_custom_column', 'glitters_service_column', 10, 2);
add_filter('manage_glitters_request_posts_columns', 'glitters_request_columns');
add_action('manage_glitters_request_posts_custom_column', 'glitters_request_column', 10, 2);

/**
 * Meta boxes.
 */
function glitters_meta_boxes() {
	add_meta_box('glitters_price', 'Цена', 'glitters_price_box', 'glitters_service', 'side', 'high');
	add_meta_box('glitters_service_help', 'Как заполнять', 'glitters_service_help_box', 'glitters_service', 'normal', 'high');
	add_meta_box('glitters_specialty', 'Специализация', 'glitters_specialty_box', 'glitters_master', 'side', 'high');
	add_meta_box('glitters_master_help', 'Как заполнять', 'glitters_master_help_box', 'glitters_master', 'normal', 'high');
	add_meta_box('glitters_rating', 'Оценка', 'glitters_rating_box', 'glitters_review', 'side', 'high');
	add_meta_box('glitters_review_help', 'Важно', 'glitters_review_help_box', 'glitters_review', 'normal', 'high');
	add_meta_box('glitters_photo_help', 'Фотография', 'glitters_photo_help_box', 'glitters_interior', 'side', 'high');
	add_meta_box('glitters_request_details', 'Данные заявки', 'glitters_request_box', 'glitters_request', 'side', 'high');
}

/**
 * @param WP_Post $post Post.
 */
function glitters_price_box($post) {
	wp_nonce_field('glitters_meta', 'glitters_meta_nonce');
	$price = get_post_meta($post->ID, 'price_from', true);
	echo '<p><label for="glitters_price_from">Цена от, ₽</label></p>';
	echo '<input type="number" min="0" step="100" class="widefat" id="glitters_price_from" name="glitters_price_from" value="' . esc_attr($price) . '" placeholder="Например 4500">';
	echo '<p class="description">Только число. На сайте будет «от 4 500 ₽». Пустое поле — «стоимость уточняется при записи».</p>';
}

/**
 * @param WP_Post $post Post.
 */
function glitters_service_help_box($post) {
	echo '<p>Краткое описание показывается на карточке. Основной текст — на отдельной странице услуги. Кнопка «Записаться» ведёт к Яндекс и Dikidi.</p>';
}

/**
 * @param WP_Post $post Post.
 */
function glitters_specialty_box($post) {
	wp_nonce_field('glitters_meta', 'glitters_meta_nonce');
	$value = get_post_meta($post->ID, 'specialty', true);
	$bio   = get_post_meta($post->ID, 'bio', true);
	echo '<p><label for="glitters_specialty">Специализация</label></p>';
	echo '<input type="text" class="widefat" id="glitters_specialty" name="glitters_specialty" value="' . esc_attr($value) . '" placeholder="Колорист">';
	echo '<p><label for="glitters_bio">Короткая биография</label></p>';
	echo '<textarea class="widefat" rows="5" id="glitters_bio" name="glitters_bio">' . esc_textarea($bio) . '</textarea>';
	echo '<p class="description">Портрет загружается как изображение записи.</p>';
}

/**
 * @param WP_Post $post Post.
 */
function glitters_master_help_box($post) {
	echo '<p>Укажите настоящее имя, специализацию и портрет. Пока ни один мастер не опубликован, на сайте показаны три карточки специализаций без имён.</p>';
}

/**
 * @param WP_Post $post Post.
 */
function glitters_rating_box($post) {
	wp_nonce_field('glitters_meta', 'glitters_meta_nonce');
	$rating = (int) get_post_meta($post->ID, 'rating', true);
	if ($rating < 1) {
		$rating = 5;
	}
	echo '<label for="glitters_rating">Звёзды</label> ';
	echo '<input type="number" min="1" max="5" id="glitters_rating" name="glitters_rating" value="' . esc_attr((string) $rating) . '">';
	echo '<p class="description">Заголовок — имя гостя. Текст отзыва — в редакторе. Публикуйте только реальные отзывы.</p>';
}

/**
 * @param WP_Post $post Post.
 */
function glitters_review_help_box($post) {
	echo '<p>Не публикуйте выдуманные отзывы. Пример формулировки, который нельзя выдавать за слова гостя: «Тихий салон, цвет совпал с тем, о чём договорились».</p>';
}

/**
 * @param WP_Post $post Post.
 */
function glitters_photo_help_box($post) {
	echo '<p>Загрузите изображение записи. Оно заменит встроенные фотографии салона. Порядок задаётся полем «Порядок».</p>';
}

/**
 * @param WP_Post $post Post.
 */
function glitters_request_box($post) {
	$phone   = get_post_meta($post->ID, 'phone', true);
	$service = get_post_meta($post->ID, 'service', true);
	$mail    = get_post_meta($post->ID, '_mail_sent', true);
	echo '<p><strong>Телефон:</strong><br>' . esc_html($phone) . '</p>';
	echo '<p><strong>Услуга:</strong><br>' . esc_html($service) . '</p>';
	echo '<p><strong>Письмо:</strong><br>' . ($mail === '1' ? 'отправлено' : 'не отправлено — откройте заявку и перезвоните') . '</p>';
}

/**
 * @param int $post_id Post ID.
 */
function glitters_save_meta($post_id) {
	if (!isset($_POST['glitters_meta_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['glitters_meta_nonce'])), 'glitters_meta')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}
	if (isset($_POST['glitters_price_from'])) {
		$price = preg_replace('/\D/', '', (string) wp_unslash($_POST['glitters_price_from']));
		if ($price === '' || (int) $price === 0) {
			delete_post_meta($post_id, 'price_from');
		} else {
			update_post_meta($post_id, 'price_from', (int) $price);
		}
	}
	if (isset($_POST['glitters_specialty'])) {
		update_post_meta($post_id, 'specialty', sanitize_text_field(wp_unslash($_POST['glitters_specialty'])));
	}
	if (isset($_POST['glitters_bio'])) {
		update_post_meta($post_id, 'bio', sanitize_textarea_field(wp_unslash($_POST['glitters_bio'])));
	}
	if (isset($_POST['glitters_rating'])) {
		$rating = max(1, min(5, (int) $_POST['glitters_rating']));
		update_post_meta($post_id, 'rating', $rating);
	}
}

/**
 * @param array<string, string> $columns Columns.
 * @return array<string, string>
 */
function glitters_service_columns($columns) {
	$columns['price_from'] = 'Цена от';
	return $columns;
}

/**
 * @param string $column Column.
 * @param int    $post_id Post ID.
 */
function glitters_service_column($column, $post_id) {
	if ($column === 'price_from') {
		$price = glitters_format_price(get_post_meta($post_id, 'price_from', true));
		echo $price ? esc_html($price) : 'уточняется';
	}
}

/**
 * @param array<string, string> $columns Columns.
 * @return array<string, string>
 */
function glitters_request_columns($columns) {
	$columns['phone']   = 'Телефон';
	$columns['service'] = 'Услуга';
	$columns['mail']    = 'Письмо';
	return $columns;
}

/**
 * @param string $column Column.
 * @param int    $post_id Post ID.
 */
function glitters_request_column($column, $post_id) {
	if ($column === 'phone') {
		echo esc_html((string) get_post_meta($post_id, 'phone', true));
	}
	if ($column === 'service') {
		echo esc_html((string) get_post_meta($post_id, 'service', true));
	}
	if ($column === 'mail') {
		echo get_post_meta($post_id, '_mail_sent', true) === '1' ? 'да' : 'нет';
	}
}
