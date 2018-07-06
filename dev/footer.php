<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wprig
 */

?>
</div><!-- #page -->
</div><!-- .grid-container -->
<footer id="colophon" class="site-footer">	
	<nav class="secondary-navigation">
		<?php if ( pehaarig_has_custom_logo( 'footer' ) ) {
			pehaarig_custom_logo_footer();
		} else { ?>
			<p><?php echo '&copy;' . date( 'Y' ) . ' ' . esc_html( get_bloginfo( 'name' ) ); ?></p>
		<?php }
		wp_nav_menu(
			array(
				'theme_location' => 'secondary',
				'menu_id'        => 'secondary-menu',
				'container'      => 'ul',
				'depth'          => 1,
			)
		);
		?>
	<nav><!-- .wrapper -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>
