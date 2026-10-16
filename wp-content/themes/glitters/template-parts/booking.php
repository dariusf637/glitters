<?php
/**
 * Online booking.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<section class="section booking" id="booking">
	<div class="wrap booking-inner">
		<p class="eyebrow">Онлайн-запись</p>
		<h2><?php echo esc_html(glitters_text('booking_title')); ?></h2>
		<p class="booking-note"><?php echo esc_html(glitters_text('booking_text')); ?></p>
		<div class="booking-actions">
			<a class="btn btn-primary" href="<?php echo esc_url(glitters_get('yandex_booking')); ?>" target="_blank" rel="noopener noreferrer">Записаться через Яндекс</a>
			<a class="btn btn-secondary" href="<?php echo esc_url(glitters_get('dikidi')); ?>" target="_blank" rel="noopener noreferrer">Записаться через Dikidi</a>
		</div>
		<p class="booking-phone">Или позвоните: <a href="tel:<?php echo esc_attr(glitters_tel()); ?>"><?php echo esc_html(glitters_get('phone_display')); ?></a></p>
	</div>
</section>
