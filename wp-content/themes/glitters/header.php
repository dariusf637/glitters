<?php
/**
 * Site header.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta name="theme-color" content="#F6F3EE" media="(prefers-color-scheme: light)">
	<meta name="theme-color" content="#141210" media="(prefers-color-scheme: dark)">
	<meta name="referrer" content="strict-origin-when-cross-origin">
	<script src="<?php echo esc_url(GLITTERS_URI . '/assets/js/theme.js?ver=' . GLITTERS_VERSION); ?>"></script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content">К содержанию</a>
<header class="site-header">
	<div class="wrap header-bar">
		<?php if (has_custom_logo()) : ?>
			<div class="logo logo-image"><?php the_custom_logo(); ?></div>
		<?php else : ?>
			<a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
				<span class="logo-mark" aria-hidden="true">G</span>
				<span class="logo-text">
					<span class="logo-name">Glitters</span>
					<span class="logo-sub"><?php echo esc_html(glitters_text('logo_sub')); ?></span>
				</span>
			</a>
		<?php endif; ?>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="Открыть меню" data-open="Открыть меню" data-close="Закрыть меню">
			<span></span><span></span><span></span>
		</button>

		<nav class="site-nav" id="site-nav" aria-label="Разделы сайта">
			<?php if (has_nav_menu('primary')) : ?>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'nav-list',
						'fallback_cb'    => false,
					)
				);
				?>
			<?php else : ?>
				<ul class="nav-list">
					<?php foreach (glitters_nav_items() as $id => $label) : ?>
						<li><a href="<?php echo esc_url(glitters_anchor($id)); ?>"><?php echo esc_html($label); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<a class="btn btn-primary nav-book" href="<?php echo esc_url(glitters_anchor('booking')); ?>"><?php echo esc_html(glitters_text('btn_book')); ?></a>
		</nav>

		<a class="header-phone" href="tel:<?php echo esc_attr(glitters_tel()); ?>"><?php echo esc_html(glitters_get('phone_display')); ?></a>
		<button class="theme-toggle" type="button" aria-pressed="false" aria-label="Включить ночной режим">
			<svg class="icon-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M15.5 3.5a8.5 8.5 0 1 0 5 14.5A8.2 8.2 0 0 1 15.5 3.5z" fill="none" stroke="currentColor" stroke-width="1.4"/></svg>
			<svg class="icon-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3.2" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M12 3.5v2.2M12 18.3v2.2M3.5 12h2.2M18.3 12h2.2M6 6l1.6 1.6M16.4 16.4 18 18M18 6l-1.6 1.6M7.6 16.4 6 18" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
		</button>
		<a class="btn btn-small header-book" href="<?php echo esc_url(glitters_anchor('booking')); ?>"><?php echo esc_html(glitters_text('btn_book')); ?></a>
	</div>
</header>
