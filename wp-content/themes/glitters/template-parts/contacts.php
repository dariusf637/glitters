<?php
/**
 * Contacts, map and form.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
$notice  = function_exists('glitters_pull_form_notice') ? glitters_pull_form_notice() : null;
$old     = (is_array($notice) && isset($notice['old']) && is_array($notice['old'])) ? $notice['old'] : array();
$errors  = (is_array($notice) && isset($notice['errors']) && is_array($notice['errors'])) ? $notice['errors'] : array();
$success = (is_array($notice) && !empty($notice['success'])) ? (string) $notice['success'] : '';
$services = glitters_posts('glitters_service');
?>
<section class="section" id="contacts">
	<div class="wrap contacts-grid">
		<div>
			<p class="eyebrow">Контакты</p>
			<h2><?php echo esc_html(glitters_text('contacts_title')); ?></h2>
			<dl class="facts">
				<div>
					<dt>Адрес</dt>
					<dd>
						<?php echo esc_html(glitters_get('address')); ?><br>
						<?php echo esc_html(glitters_get('district')); ?>
					</dd>
				</div>
				<div>
					<dt>Телефон</dt>
					<dd><a href="tel:<?php echo esc_attr(glitters_tel()); ?>"><?php echo esc_html(glitters_get('phone_display')); ?></a></dd>
				</div>
				<div>
					<dt>Часы</dt>
					<dd><?php echo esc_html(glitters_get('hours')); ?></dd>
				</div>
			</dl>
			<div class="contact-actions">
				<a class="btn btn-primary" href="tel:<?php echo esc_attr(glitters_tel()); ?>">Позвонить</a>
				<?php if (glitters_get('whatsapp')) : ?>
					<a class="btn btn-secondary" href="<?php echo esc_url(glitters_get('whatsapp')); ?>" target="_blank" rel="noopener noreferrer">Написать в WhatsApp</a>
				<?php endif; ?>
				<?php if (glitters_get('telegram')) : ?>
					<a class="btn btn-secondary" href="<?php echo esc_url(glitters_get('telegram')); ?>" target="_blank" rel="noopener noreferrer">Написать в Telegram</a>
				<?php endif; ?>
			</div>

			<?php if ($success) : ?>
				<div class="form-success" role="status"><?php echo esc_html($success); ?></div>
			<?php endif; ?>
			<?php if ($errors) : ?>
				<div class="form-errors" role="alert">
					<?php foreach ($errors as $error) : ?>
						<p><?php echo esc_html($error); ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<form class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate>
				<input type="hidden" name="action" value="glitters_contact">
				<?php wp_nonce_field('glitters_contact'); ?>
				<p class="hp" aria-hidden="true">
					<label>Не заполняйте это поле<input tabindex="-1" autocomplete="off" name="glitters_company" value=""></label>
				</p>
				<p>
					<label for="guest_name">Имя</label>
					<input id="guest_name" name="guest_name" type="text" autocomplete="name" required value="<?php echo esc_attr($old['name'] ?? ''); ?>">
				</p>
				<p>
					<label for="guest_phone">Телефон</label>
					<input id="guest_phone" name="guest_phone" type="tel" autocomplete="tel" required value="<?php echo esc_attr($old['phone'] ?? ''); ?>">
				</p>
				<p>
					<label for="service_id">Услуга</label>
					<select id="service_id" name="service_id">
						<option value="">Выберите услугу</option>
						<?php foreach ($services as $service) : ?>
							<option value="<?php echo esc_attr((string) $service->ID); ?>" <?php selected((int) ($old['service_id'] ?? 0), (int) $service->ID); ?>><?php echo esc_html(get_the_title($service)); ?></option>
						<?php endforeach; ?>
					</select>
				</p>
				<p>
					<label for="guest_message">Сообщение</label>
					<textarea id="guest_message" name="guest_message" rows="4"><?php echo esc_textarea($old['message'] ?? ''); ?></textarea>
				</p>
				<p class="consent">
					<label>
						<input type="checkbox" name="consent" value="1" required>
						Я соглашаюсь на обработку персональных данных в соответствии с <a href="<?php echo esc_url(glitters_page_url('privacy')); ?>">политикой конфиденциальности</a>.
					</label>
				</p>
				<button class="btn btn-primary" type="submit">Отправить заявку</button>
			</form>
		</div>
		<div class="map-panel">
			<iframe title="Карта: салон Glitters, ул. Правды, 16" src="<?php echo esc_url(glitters_map_src()); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			<p><a href="<?php echo esc_url(glitters_get('yandex_map')); ?>" target="_blank" rel="noopener noreferrer">Открыть в Яндекс Картах</a></p>
		</div>
	</div>
</section>
