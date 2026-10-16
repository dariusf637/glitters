<?php
/**
 * Thin line icons.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * @param string $name Icon name.
 * @return string
 */
function glitters_icon($name) {
	$icons = array(
		'room'    => '<svg viewBox="0 0 32 32" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M6 26V10l10-5 10 5v16"/><path d="M13 26v-7h6v7"/></svg>',
		'person'  => '<svg viewBox="0 0 32 32" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="16" cy="11" r="3.2"/><path d="M8.5 24c1.2-3.4 4-5 7.5-5s6.3 1.6 7.5 5"/></svg>',
		'scissor' => '<svg viewBox="0 0 32 32" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="9" cy="23" r="2.2"/><circle cx="23" cy="23" r="2.2"/><path d="M11 21.5 21 8M21 21.5 11 8"/></svg>',
		'drop'    => '<svg viewBox="0 0 32 32" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M16 6c4 5 7 8.2 7 12a7 7 0 1 1-14 0c0-3.8 3-7 7-12z"/></svg>',
		'phone'   => '<svg viewBox="0 0 32 32" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M11 7h3l1.5 4-2 1.5a12 12 0 0 0 6 6L21 17l4 1.5V22a2 2 0 0 1-2 2A16 16 0 0 1 8 9a2 2 0 0 1 2-2z"/></svg>',
	);
	return $icons[$name] ?? '';
}
