<?php
/**
 * Salon content types.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('init', 'glitters_register_content_types');
add_action('init', 'glitters_grant_request_caps', 11);
add_filter('enter_title_here', 'glitters_title_placeholder', 10, 2);

/**
 * @param string  $title Placeholder.
 * @param WP_Post $post  Post.
 * @return string
 */
function glitters_title_placeholder($title, $post) {
	$map = array(
		'glitters_service'  => 'Название услуги',
		'glitters_master'   => 'Имя мастера',
		'glitters_review'   => 'Имя гостя',
		'glitters_interior' => 'Подпись к фотографии',
		'glitters_request'  => 'Имя гостя',
	);
	return $map[$post->post_type] ?? $title;
}

/**
 * Register post types under the Glitters menu.
 */
function glitters_register_content_types() {
	register_post_type(
		'glitters_service',
		array(
			'labels'       => glitters_labels('Услуга', 'Услуги', 'Добавить услугу'),
			'public'       => true,
			'show_ui'      => true,
			'show_in_menu' => 'glitters',
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-scissors',
			'supports'     => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
			'has_archive'  => false,
			'rewrite'      => array(
				'slug'       => 'uslugi',
				'with_front' => false,
			),
		)
	);

	register_post_type(
		'glitters_master',
		array(
			'labels'             => glitters_labels('Мастер', 'Мастера', 'Добавить мастера'),
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => 'glitters',
			'exclude_from_search'=> true,
			'supports'           => array('title', 'excerpt', 'thumbnail', 'page-attributes'),
		)
	);

	register_post_type(
		'glitters_review',
		array(
			'labels'             => glitters_labels('Отзыв', 'Отзывы', 'Добавить отзыв'),
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => 'glitters',
			'exclude_from_search'=> true,
			'supports'           => array('title', 'editor', 'page-attributes'),
		)
	);

	register_post_type(
		'glitters_interior',
		array(
			'labels'             => glitters_labels('Фото интерьера', 'Интерьер', 'Добавить фото'),
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => 'glitters',
			'exclude_from_search'=> true,
			'supports'           => array('title', 'excerpt', 'thumbnail', 'page-attributes'),
		)
	);

	register_post_type(
		'glitters_request',
		array(
			'labels'          => glitters_labels('Заявка', 'Заявки', 'Добавить заявку'),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => 'glitters',
			'capability_type' => 'glitters_request',
			'map_meta_cap'    => true,
			'supports'        => array('title', 'editor'),
		)
	);
}

/**
 * @param string $singular Singular label.
 * @param string $plural   Plural label.
 * @param string $add      Add label.
 * @return array<string, string>
 */
function glitters_labels($singular, $plural, $add) {
	return array(
		'name'          => $plural,
		'singular_name' => $singular,
		'add_new'       => 'Добавить',
		'add_new_item'  => $add,
		'edit_item'     => 'Редактировать',
		'new_item'      => $singular,
		'view_item'     => 'Смотреть',
		'search_items'  => 'Искать',
		'not_found'     => 'Пока пусто',
		'not_found_in_trash' => 'В корзине пусто',
		'all_items'     => $plural,
		'menu_name'     => $plural,
	);
}

/**
 * Keep booking requests visible only to administrators.
 */
function glitters_grant_request_caps() {
	$role = get_role('administrator');
	if (!$role) {
		return;
	}
	$caps = array(
		'edit_glitters_request',
		'read_glitters_request',
		'delete_glitters_request',
		'edit_glitters_requests',
		'edit_others_glitters_requests',
		'publish_glitters_requests',
		'read_private_glitters_requests',
		'delete_glitters_requests',
		'delete_private_glitters_requests',
		'delete_published_glitters_requests',
		'delete_others_glitters_requests',
		'edit_private_glitters_requests',
		'edit_published_glitters_requests',
		'create_glitters_requests',
	);
	foreach ($caps as $cap) {
		if (!$role->has_cap($cap)) {
			$role->add_cap($cap);
		}
	}
}
