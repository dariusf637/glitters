<?php
/**
 * Real interior: stills and a short silent film.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

$photos = glitters_posts('glitters_interior');
$photos = array_values(
	array_filter(
		$photos,
		static function ($photo) {
			return (int) get_post_thumbnail_id($photo) > 0;
		}
	)
);
$show_film = (int) glitters_get('show_film') === 1;
$video     = GLITTERS_URI . '/assets/video/salon-interieur.mp4';
$poster    = GLITTERS_URI . '/assets/images/salon-wash.jpg';
?>
<section class="section section-interior" id="interior">
	<div class="wrap section-head">
		<p class="eyebrow"><?php echo esc_html(glitters_text('eyebrow_interior')); ?></p>
		<h2 class="interior-lead"><?php echo esc_html(glitters_text('interior_text')); ?></h2>
	</div>

	<div class="lookbook">
		<?php if ($show_film && file_exists(GLITTERS_DIR . '/assets/video/salon-interieur.mp4')) : ?>
			<figure class="look-item look-video">
				<div class="look-media">
					<video class="salon-film" muted loop playsinline preload="metadata" poster="<?php echo esc_url($poster); ?>" aria-label="<?php echo esc_attr(glitters_text('film_alt')); ?>">
						<source src="<?php echo esc_url($video); ?>" type="video/mp4">
					</video>
					<button class="film-toggle" type="button" aria-pressed="true" data-pause="<?php echo esc_attr(glitters_text('film_pause')); ?>" data-play="<?php echo esc_attr(glitters_text('film_play')); ?>"><?php echo esc_html(glitters_text('film_pause')); ?></button>
				</div>
				<figcaption><?php echo esc_html(glitters_text('film_caption')); ?></figcaption>
			</figure>
		<?php endif; ?>

		<?php if ($photos) : ?>
			<?php foreach ($photos as $index => $photo) : ?>
				<figure class="look-item <?php echo $index === 0 ? 'look-wash' : ($index === 1 ? 'look-mirror' : 'look-wait'); ?>">
					<div class="look-media">
						<div class="look-parallax" data-parallax>
							<?php
							echo wp_get_attachment_image(
								(int) get_post_thumbnail_id($photo),
								'large',
								false,
								array(
									'alt' => $photo->post_title ? $photo->post_title : 'Интерьер салона Glitters',
								)
							);
							?>
						</div>
					</div>
					<?php if ($photo->post_excerpt) : ?>
						<figcaption><?php echo esc_html($photo->post_excerpt); ?></figcaption>
					<?php endif; ?>
				</figure>
			<?php endforeach; ?>
		<?php else : ?>
			<?php foreach (glitters_bundled_gallery() as $item) : ?>
				<figure class="look-item <?php echo esc_attr($item['class']); ?>">
					<div class="look-media">
						<div class="look-parallax" data-parallax>
							<?php echo glitters_theme_image($item['file'], $item['alt']); ?>
						</div>
					</div>
					<figcaption><?php echo esc_html($item['caption']); ?></figcaption>
				</figure>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<?php if (current_user_can('edit_posts') && !$photos) : ?>
		<p class="wrap admin-inline"><a href="<?php echo esc_url(admin_url('post-new.php?post_type=glitters_interior')); ?>">Добавить свои фотографии</a> — они заменят эти кадры.</p>
	<?php endif; ?>
</section>
