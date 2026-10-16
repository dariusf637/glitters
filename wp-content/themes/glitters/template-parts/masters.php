<?php
/**
 * Masters. Role cards stand in until real profiles are published.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
$masters = glitters_posts('glitters_master');
?>
<section class="section" id="masters">
	<div class="wrap">
		<p class="eyebrow"><?php echo esc_html(glitters_text('eyebrow_masters')); ?></p>
		<h2><?php echo esc_html(glitters_text('masters_title')); ?></h2>
		<p class="section-intro"><?php echo esc_html(glitters_text('masters_intro')); ?></p>
		<div class="masters-grid">
			<?php if ($masters) : ?>
				<?php foreach ($masters as $master) : ?>
					<?php
					$specialty = (string) get_post_meta($master->ID, 'specialty', true);
					$bio       = (string) get_post_meta($master->ID, 'bio', true);
					if ($bio === '') {
						$bio = $master->post_excerpt;
					}
					$photo = (int) get_post_thumbnail_id($master);
					?>
					<article class="master">
						<div class="master-photo">
							<?php if ($photo) : ?>
								<?php
								echo wp_get_attachment_image(
									$photo,
									'glitters_portrait',
									false,
									array(
										'alt' => sprintf('Портрет: %s', get_the_title($master)),
									)
								);
								?>
							<?php else : ?>
								<span class="monogram" aria-hidden="true"><?php echo esc_html(glitters_monogram(get_the_title($master))); ?></span>
							<?php endif; ?>
						</div>
						<h3><?php echo esc_html(get_the_title($master)); ?></h3>
						<?php if ($specialty) : ?>
							<p class="master-role"><?php echo esc_html($specialty); ?></p>
						<?php endif; ?>
						<?php if ($bio) : ?>
							<p><?php echo esc_html($bio); ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			<?php else : ?>
				<?php foreach (glitters_role_cards() as $card) : ?>
					<article class="master">
						<div class="master-photo">
							<span class="monogram" aria-hidden="true"><?php echo esc_html(glitters_monogram($card['role'])); ?></span>
						</div>
						<h3><?php echo esc_html($card['role']); ?></h3>
						<p class="master-role"><?php echo esc_html($card['focus']); ?></p>
						<p><?php echo esc_html($card['text']); ?></p>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
