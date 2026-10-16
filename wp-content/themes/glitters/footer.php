<?php
/**
 * Site footer and the mobile booking bar.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<footer class="site-footer">
	<div class="wrap footer-grid">
		<div>
			<p class="footer-brand">Glitters</p>
			<p>Женский салон красоты и студия ухода за волосами.</p>
		</div>
		<nav aria-label="Нижнее меню">
			<ul class="footer-nav">
				<?php foreach (glitters_nav_items() as $id => $label) : ?>
					<li><a href="<?php echo esc_url(glitters_anchor($id)); ?>"><?php echo esc_html($label); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<div>
			<p><?php echo esc_html(glitters_get('address')); ?></p>
			<p><a href="tel:<?php echo esc_attr(glitters_tel()); ?>"><?php echo esc_html(glitters_get('phone_display')); ?></a></p>
			<p><?php echo esc_html(glitters_get('hours')); ?></p>
		</div>
		<div class="footer-book">
			<a href="<?php echo esc_url(glitters_get('yandex_booking')); ?>" target="_blank" rel="noopener noreferrer">Записаться через Яндекс</a>
			<a href="<?php echo esc_url(glitters_get('dikidi')); ?>" target="_blank" rel="noopener noreferrer">Записаться через Dikidi</a>
		</div>
	</div>
	<div class="wrap footer-base">
		<p>© <?php echo esc_html(wp_date('Y')); ?> Glitters. Санкт-Петербург.</p>
		<p>
			<a href="<?php echo esc_url(glitters_page_url('legal')); ?>">Правовая информация</a>
			<a href="<?php echo esc_url(glitters_page_url('privacy')); ?>">Политика конфиденциальности</a>
		</p>
		<p>Информация на сайте не является публичной офертой.</p>
	</div>
</footer>

<div class="dock" role="navigation" aria-label="Быстрые действия">
	<a class="dock-call" href="tel:<?php echo esc_attr(glitters_tel()); ?>">Позвонить</a>
	<a class="dock-book" href="<?php echo esc_url(glitters_anchor('booking')); ?>">Записаться онлайн</a>
</div>
<?php wp_footer(); ?>
</body>
</html>
