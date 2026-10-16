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
		<h1><?php echo esc_html(glitters_text('notfound_title')); ?></h1>
		<p><?php echo esc_html(glitters_text('notfound_text')); ?></p>
		<p>
			<a class="btn btn-primary" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(glitters_text('btn_home')); ?></a>
			<a class="btn btn-secondary" href="<?php echo esc_url(home_url('/#booking')); ?>"><?php echo esc_html(glitters_text('btn_book')); ?></a>
		</p>
	</div>
</main>
<?php
get_footer();
