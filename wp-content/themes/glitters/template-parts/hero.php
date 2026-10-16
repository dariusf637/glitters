<?php
/**
 * Opening view. Uses the salon's own room unless a photo is chosen in settings.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
$hero_id = glitters_hero_attachment_id();
?>
<section class="hero" id="top">
	<div class="hero-media">
		<?php
		if ($hero_id) {
			echo wp_get_attachment_image(
				$hero_id,
				'full',
				false,
				array(
					'class'         => 'hero-img',
					'loading'       => 'eager',
					'fetchpriority' => 'high',
					'alt'           => glitters_text('hero_alt'),
				)
			);
		} else {
			echo glitters_theme_image(
				'assets/images/salon-hero.jpg',
				glitters_text('hero_alt'),
				array(
					'class'         => 'hero-img',
					'loading'       => 'eager',
					'fetchpriority' => 'high',
				)
			);
		}
		?>
	</div>
	<div class="hero-shade" aria-hidden="true"></div>
	<div class="wrap hero-copy">
		<p class="eyebrow eyebrow-light"><?php echo esc_html(glitters_text('hero_kicker')); ?></p>
		<h1><?php echo esc_html(glitters_text('hero_title')); ?></h1>
		<p class="lede"><?php echo esc_html(glitters_text('hero_subtitle')); ?></p>
		<div class="hero-actions">
			<a class="btn btn-light" href="<?php echo esc_url(glitters_anchor('booking')); ?>"><?php echo esc_html(glitters_text('btn_book')); ?></a>
			<a class="btn btn-ghost" href="<?php echo esc_url(glitters_anchor('services')); ?>"><?php echo esc_html(glitters_text('btn_services')); ?></a>
		</div>
	</div>
</section>
