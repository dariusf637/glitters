<?php
/**
 * Front page.
 *
 * @package Glitters
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<main id="content">
	<?php
	get_template_part('template-parts/hero');
	get_template_part('template-parts/about');
	get_template_part('template-parts/interior');
	get_template_part('template-parts/services');
	get_template_part('template-parts/booking');
	get_template_part('template-parts/masters');
	get_template_part('template-parts/reviews');
	get_template_part('template-parts/contacts');
	?>
</main>
<?php
get_footer();
