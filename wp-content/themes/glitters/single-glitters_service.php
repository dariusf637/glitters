<?php
/**
 * Single service.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
get_header();
?>
<main id="content" class="section page-main">
	<div class="wrap prose service-single">
		<?php
		while (have_posts()) :
			the_post();
			$price = glitters_format_price(get_post_meta(get_the_ID(), 'price_from', true));
			?>
			<p class="eyebrow"><a href="<?php echo esc_url(home_url('/#services')); ?>"><?php echo esc_html(glitters_text('nav_services')); ?></a></p>
			<h1><?php the_title(); ?></h1>
			<p class="price<?php echo $price ? '' : ' price-quiet'; ?>"><?php echo esc_html($price ? $price : glitters_text('price_note')); ?></p>
			<?php the_content(); ?>
			<div class="booking-actions">
				<a class="btn btn-primary" href="<?php echo esc_url(glitters_get('yandex_booking')); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html(glitters_text('btn_yandex')); ?></a>
				<a class="btn btn-secondary" href="<?php echo esc_url(glitters_get('dikidi')); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html(glitters_text('btn_dikidi')); ?></a>
			</div>
		<?php endwhile; ?>
	</div>
</main>
<?php
get_footer();
