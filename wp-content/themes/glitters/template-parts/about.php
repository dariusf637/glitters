<?php
/**
 * About the salon.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
$icons   = array('room', 'person', 'scissor', 'drop');
$pillars = array();
foreach ($icons as $index => $icon) {
	$n         = $index + 1;
	$pillars[] = array($icon, glitters_text('pillar_' . $n . '_title'), glitters_text('pillar_' . $n . '_text'));
}
?>
<section class="section" id="about">
	<div class="wrap about-grid">
		<div>
			<p class="eyebrow"><?php echo esc_html(glitters_text('eyebrow_about')); ?></p>
			<h2><?php echo esc_html(glitters_text('about_title')); ?></h2>
			<div class="prose-lead"><?php echo glitters_paragraphs(glitters_text('about_text')); ?></div>
		</div>
		<ul class="pillars">
			<?php foreach ($pillars as $pillar) : ?>
				<li>
					<span class="pillar-icon"><?php echo glitters_icon($pillar[0]); ?></span>
					<h3><?php echo esc_html($pillar[1]); ?></h3>
					<p><?php echo esc_html($pillar[2]); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
