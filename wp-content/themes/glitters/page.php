<?php
/**
 * Inner pages: privacy and legal notes.
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
		<?php
		while (have_posts()) :
			the_post();
			?>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		<?php endwhile; ?>
	</div>
</main>
<?php
get_footer();
