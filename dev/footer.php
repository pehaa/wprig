<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pehaarig
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
				'menu_class'     => 'secondary-navigation-menu menu',
				'container'      => 'ul',
				'depth'          => 1,
			)
		);

		$linkedin_profile = get_theme_mod( 'pehaarig_linkedin' );
		if ( $linkedin_profile ) { ?>
			<ul class="footer-socials">
				<li>
					<a href="<?php echo esc_url( $linkedin_profile ); ?>" aria-label="<?php echo esc_html( 'Visit out Linkedin Profile', 'pehaarig' ); ?>">
						<svg class="pehaarig-svg">
							<use xlink:href="#linkedin" />
						</svg>
					</a>
				</li>
			</ul>
		<?php } ?>
		
	</nav><!-- .wrapper -->
	<a id="pehaarig-to-top" href="#body" aria-label="<?php esc_html_e( 'Back to top', 'pehaarig' ); ?>" class="pehaarig-to-top"><i class="icon arrow-up"></i></a>
</footer><!-- #colophon -->
<div class="u-visually-hidden">
	<?php echo file_get_contents( get_template_directory() . '/images/dest/images.svg' ); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
