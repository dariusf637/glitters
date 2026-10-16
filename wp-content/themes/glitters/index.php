<?php
/**
 * Fallback index.
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
		<?php if (have_posts()) : ?>
			<?php
			while (have_posts()) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<h1>Ничего не найдено</h1>
			<p>Вернитесь на главную или запишитесь онлайн.</p>
			<p><a class="btn btn-primary" href="<?php echo esc_url(home_url('/')); ?>">На главную</a></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
