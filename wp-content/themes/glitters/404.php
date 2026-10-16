<?php
/**
 * Missing page.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}
get_header();
?>
<main id="content" class="section page-main">
	<div class="wrap prose">
		<p class="eyebrow">404</p>
		<h1>Такой страницы нет</h1>
		<p>Возможно, ссылка устарела. Вернитесь на главную или запишитесь онлайн.</p>
		<p>
			<a class="btn btn-primary" href="<?php echo esc_url(home_url('/')); ?>">На главную</a>
			<a class="btn btn-secondary" href="<?php echo esc_url(home_url('/#booking')); ?>">Записаться онлайн</a>
		</p>
	</div>
</main>
<?php
get_footer();
