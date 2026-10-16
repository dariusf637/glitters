<?php
/**
 * About the salon.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
$pillars = array(
	array('room', 'Приватность', 'Камерный зал и запись по времени. Визит проходит без суеты и постороннего внимания.'),
	array('person', 'Персональное внимание', 'Форма, оттенок и уход подбираются лично. Решение объясняем спокойно и по существу.'),
	array('scissor', 'Опыт мастеров', 'Точная техника, аккуратная работа с цветом и уважение к качеству волоса.'),
	array('drop', 'Комфорт', 'Продуманное пространство, профессиональные средства и деликатное отношение к вашему времени.'),
);
?>
<section class="section" id="about">
	<div class="wrap about-grid">
		<div>
			<p class="eyebrow">О салоне</p>
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
