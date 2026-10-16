<?php
/**
 * Reviews. Empty until the salon publishes real ones.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
$reviews = glitters_posts('glitters_review');
?>
<section class="section" id="reviews">
	<div class="wrap">
		<div class="section-head section-head-row">
			<div>
				<p class="eyebrow">Отзывы</p>
				<h2><?php echo esc_html(glitters_text('reviews_title')); ?></h2>
			</div>
			<?php if (count($reviews) > 1) : ?>
				<div class="review-nav">
					<button class="reviews-prev" type="button" aria-label="Предыдущий отзыв">←</button>
					<button class="reviews-next" type="button" aria-label="Следующий отзыв">→</button>
				</div>
			<?php endif; ?>
		</div>

		<?php if ($reviews) : ?>
			<div class="reviews-track" tabindex="0">
				<?php foreach ($reviews as $review) : ?>
					<?php $rating = max(1, min(5, (int) get_post_meta($review->ID, 'rating', true) ?: 5)); ?>
					<article class="review">
						<p class="stars" aria-label="<?php echo esc_attr(sprintf('Оценка: %d из 5', $rating)); ?>">
							<?php for ($i = 1; $i <= 5; $i++) : ?>
								<span class="star<?php echo $i <= $rating ? ' is-on' : ''; ?>">★</span>
							<?php endfor; ?>
						</p>
						<p class="review-text"><?php echo esc_html(wp_strip_all_tags($review->post_content)); ?></p>
						<p class="review-name"><?php echo esc_html(get_the_title($review)); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="review review-empty">
				<p class="review-text">После визита нам важно услышать, как вы себя чувствуете. Здесь появятся отзывы гостей — позже их можно дополнить отзывами с Яндекс Карт и Google.</p>
			</div>
		<?php endif; ?>
	</div>
</section>
