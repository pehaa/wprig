<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wprig
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php if ( ! wprig_is_amp() ) : ?>
		<script>document.documentElement.classList.remove("no-js");</script>
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body id="body" <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'wprig' ); ?></a>
	<header id="masthead" class="site-header">
		
		<div class="site-branding">
			<div class="donation-ctnr">
				<?php pehaarig_custom_logo_affiliate(); ?>
				<?php pehaarig_donation_button(); ?>
			</div>
			<div class="custom-logo-link-ctnr">
				<?php pehaarig_custom_logo_main( true, true ); ?>
			</div>
			
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Main menu', 'wprig' ); ?>"
			<?php if ( wprig_is_amp() ) : ?>
				[class]=" siteNavigationMenu.expanded ? 'main-navigation toggled-on' : 'main-navigation' "
			<?php endif; ?>
		>
			<?php if ( wprig_is_amp() ) : ?>
				<amp-state id="siteNavigationMenu">
					<script type="application/json">
						{
							"expanded": false
						}
					</script>
				</amp-state>
			<?php endif; ?>

			<button class="menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'wprig' ); ?>" aria-controls="primary-menu" aria-expanded="false"
				<?php if ( wprig_is_amp() ) : ?>
					on="tap:AMP.setState( { siteNavigationMenu: { expanded: ! siteNavigationMenu.expanded } } )"
					[aria-expanded]="siteNavigationMenu.expanded ? 'true' : 'false'"
				<?php endif; ?>
			>
				<span class="menu-toggle__span"></span>
			</button>
			<?php $menu_class = pehaarig_has_custom_logo( 'mini' ) ? ' u-flex-spacebetween' : ' u-flex-center'; ?>
			<?php pehaarig_custom_logo_main(); ?>
			<div class="primary-menu-container <?php echo esc_attr( $menu_class ); ?>">
				<?php
				
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'main-navigation-menu menu',
						'container'      => 'ul',
					)
				);

				?>
			</div>
			<?php pehaarig_donation_button(); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
	<div class="grid-container wrapper">