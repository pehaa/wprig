<?php
/**
 * The project template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wprig
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			/*
			 * Include the component stylesheet for the content.
			 * This call runs only once on index and archive pages.
			 * At some point, override functionality should be built in similar to the template part below.
			 */

			get_template_part( 'template-parts/content', 'page-full' );

		endwhile; // End of the loop.
		?>

	</main><!-- #primary -->

<?php
get_footer();