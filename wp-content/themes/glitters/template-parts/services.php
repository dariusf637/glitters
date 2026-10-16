<?php
/**
 * Services.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
$services = glitters_posts('glitters_service');
?>
<section class="section" id="services">
	<div class="wrap">
		<p class="eyebrow"><?php echo esc_html(glitters_text('eyebrow_services')); ?></p>
		<h2><?php echo esc_html(glitters_text('services_title')); ?></h2>
		<div class="service-grid">
			<?php if ($services) : ?>
				<?php foreach ($services as $index => $service) : ?>
					<?php $price = glitters_format_price(get_post_meta($service->ID, 'price_from', true)); ?>
					<article class="service-card">
						<p class="service-index"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></p>
						<h3><a href="<?php echo esc_url(get_permalink($service)); ?>"><?php echo esc_html(get_the_title($service)); ?></a></h3>
						<p><?php echo esc_html(get_the_excerpt($service)); ?></p>
						<div class="service-foot">
							<p class="price<?php echo $price ? '' : ' price-quiet'; ?>">
								<?php echo esc_html($price ? $price : glitters_text('price_note')); ?>
							</p>
							<a class="text-link" href="<?php echo esc_url(glitters_anchor('booking')); ?>"><?php echo esc_html(glitters_text('btn_book_short')); ?></a>
						</div>
					</article>
				<?php endforeach; ?>
			<?php else : ?>
				<p><?php echo esc_html(glitters_text('services_empty')); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
