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
					'alt'           => 'Интерьер салона Glitters на улице Правды',
				)
			);
		} else {
			echo glitters_theme_image(
				'assets/images/salon-hero.jpg',
				'Интерьер салона Glitters: витрина средств и зона укладки',
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
			<a class="btn btn-light" href="<?php echo esc_url(glitters_anchor('booking')); ?>">Записаться онлайн</a>
			<a class="btn btn-ghost" href="<?php echo esc_url(glitters_anchor('services')); ?>">Посмотреть услуги</a>
		</div>
	</div>
</section>
