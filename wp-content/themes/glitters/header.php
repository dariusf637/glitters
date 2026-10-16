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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#F6F3EE">
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
					<span class="logo-sub">салон красоты</span>
				</span>
			</a>
		<?php endif; ?>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="Открыть меню">
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
		</nav>

		<a class="header-phone" href="tel:<?php echo esc_attr(glitters_tel()); ?>"><?php echo esc_html(glitters_get('phone_display')); ?></a>
		<a class="btn btn-small header-book" href="<?php echo esc_url(glitters_anchor('booking')); ?>">Записаться онлайн</a>
	</div>
</header>
