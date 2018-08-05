<?php
/**
 * WP Rig functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wprig
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wprig_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on wprig, use a find and replace
		* to change 'wprig' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'wprig', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary', 'wprig' ),
			'secondary' => esc_html__( 'Secondary', 'wprig' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => false,
			'flex-height' => false,
		)
	);

	/**
	 * Add support for wide aligments.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
	 */
	add_theme_support( 'align-wide' );

	/**
	 * Optional: Disable custom colors in block color palettes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
	 *
	 * add_theme_support( 'disable-custom-colors' );
	 */

	/**
	 * Optional: Add AMP support.
	 *
	 * Add built-in support for the AMP plugin and specific AMP features.
	 * Control how the plugin, when activated, impacts the theme.
	 *
	 * @link https://wordpress.org/plugins/amp/
	 */
	add_theme_support( 'amp', array(
		'comments_live_list' => true,
	) );

}
add_action( 'after_setup_theme', 'wprig_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wprig_content_width() {

	if ( isset( $GLOBALS['content_width'] ) ) {
		$content_width = $GLOBALS['content_width'];
	}

	$content_width = 720;

	/**
	 * Filter content width of the theme.
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'wprig_content_width', $content_width );
}
add_action( 'template_redirect', 'wprig_content_width', 0 );

/**
 * Register Google Fonts
 */
function wprig_fonts_url() {
	$fonts_url = '';
	/**
	 * Translator: If Open Sans does not support characters in your language, translate this to 'off'.
	 */
	$font_families[] = 'Open Sans:400,400i,700,700i';
	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	return esc_url_raw( $fonts_url );

}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function wprig_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'wprig-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'wprig_resource_hints', 10, 2 );

/**
 * Enqueue WordPress theme styles within Gutenberg.
 */
function wprig_gutenberg_styles() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'wprig-fonts', wprig_fonts_url(), array(), null );

	// Enqueue main stylesheet.
	wp_enqueue_style( 'wprig-base-style', get_theme_file_uri( '/css/editor-styles.css' ), array(), '20180514' );
}
add_action( 'enqueue_block_editor_assets', 'wprig_gutenberg_styles' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wprig_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wprig' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wprig' ),
		'before_widget' => '<section id="%1$s" class="widget maintenant-deco %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	/* register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'wprig' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'wprig' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) ); */
}
add_action( 'widgets_init', 'wprig_widgets_init' );

/**
 * Enqueue styles.
 */
function wprig_styles() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'wprig-fonts', wprig_fonts_url(), array(), null );

	// Enqueue main stylesheet.
	wp_enqueue_style( 'wprig-base-style', get_stylesheet_uri(), array(), '20180805' );

	// Register component styles that are printed as needed.
	wp_register_style( 'wprig-comments', get_theme_file_uri( '/css/comments.css' ), array(), '20180514' );
	wp_register_style( 'wprig-content', get_theme_file_uri( '/css/content.css' ), array(), '20180514' );
	wp_register_style( 'wprig-sidebar', get_theme_file_uri( '/css/sidebar.css' ), array(), '20180514' );
	wp_register_style( 'wprig-widgets', get_theme_file_uri( '/css/widgets.css' ), array(), '20180514' );
	wp_register_style( 'wprig-front-page', get_theme_file_uri( '/css/front-page.css' ), array(), '20180514' );
	wp_register_style( 'wprig-search', get_theme_file_uri( '/css/search.css' ), array(), '20180514' );

	if ( is_404() ) {
		wp_enqueue_style( 'wprig-404-page', get_theme_file_uri( '/css/404.css' ), array(), '20180514' );
	}
}
add_action( 'wp_enqueue_scripts', 'wprig_styles' );

/**
 * Enqueue scripts.
 */
function wprig_scripts() {

	// If the AMP plugin is not active, enqueue custom scripts.
	if ( ! wprig_is_amp() ) {

		// Enqueue the navigation script.
		wp_enqueue_script( 'wprig-navigation', get_theme_file_uri( '/js/navigation.js' ), array(), '20180514', true );
		wp_script_add_data( 'wprig-navigation', 'async', true );
		wp_localize_script( 'wprig-navigation', 'wprigScreenReaderText', array(
			'expand'   => __( 'Expand child menu', 'wprig' ),
			'collapse' => __( 'Collapse child menu', 'wprig' ),
		));

		// Enqueue the masterhead script.
		wp_enqueue_script( 'wprig-webfont', get_theme_file_uri( 'pluggable/webfonts/MyFontsWebfontsKit.js' ), array(), '20180805', true );
		wp_script_add_data( 'wprig-webfont', 'async', false );

		

		// Enqueue the masterhead script.
		if ( apply_filters( 'pehaarig_enable_back_to_top', true ) ) {
			wp_enqueue_script( 'pehaarig-backtotop', get_theme_file_uri( '/js/backtotop.js' ), array(), '20180514', true );
			wp_script_add_data( 'pehaarig-backtotop', 'async', true );
		}

		//Enqueue accessibility fix id divi builder is enabled
		if ( class_exists( 'ET_Builder_Plugin' ) ) {
			wp_enqueue_script( 'pehaarig-access', get_theme_file_uri( '/js/accessibility-fix.js' ), array(), '20180514', true );
			wp_script_add_data( 'pehaarig-access', 'async', true );
		}
		// Enqueue skip-link-focus script.
		wp_enqueue_script( 'wprig-skip-link-focus-fix', get_theme_file_uri( '/js/skip-link-focus-fix.js' ), array(), '20180514', false );
		wp_script_add_data( 'wprig-skip-link-focus-fix', 'defer', true );

		// Enqueue comment script on singular post/page views only.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'wprig_scripts' );

/**
 * Enqueue late scripts.
 */
function wprig_scripts_late() {
	// Enqueue the masterhead script.
	wp_enqueue_script( 'wprig-masterhead', get_theme_file_uri( '/js/masterhead.js' ), array(), '20180729', true );
	wp_script_add_data( 'wprig-masterhead', 'async', true );
}
add_action( 'wp_enqueue_scripts', 'wprig_scripts_late', 999 );
/**
 * Enqueue scripts.
 */
function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

/**
 * Custom responsive image sizes.
 */
require get_template_directory() . '/inc/image-sizes.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/theme-defaults.php';
require get_template_directory() . '/inc/customizer.php';

/**
 * Optional: Add theme support for lazyloading images.
 *
 * @link https://developers.google.com/web/fundamentals/performance/lazy-loading-guidance/images-and-video/
 */
require get_template_directory() . '/pluggable/lazyload/lazyload.php';

/**
 * Optional: Disable emoji.
 *
 * @link https://kinsta.com/knowledgebase/disable-emojis-wordpress/
 */
require_once get_template_directory() . '/pluggable/disable-emoji.php';



/**
 * projects slug rewritten to projet
 */
function pehaarig_project_posttype_rewrite_args( $rewrite ) {
	$rewrite['slug'] = 'projet';
	return $rewrite;
}
add_filter( 'et_project_posttype_rewrite_args', 'pehaarig_project_posttype_rewrite_args' );

/**
 * Disable dashicons for non logged-in users
 */
function pehaarig_dequeue_dashicons() {

	if ( ! is_user_logged_in() ) {
        wp_deregister_style( 'dashicons' );
    }
}
add_action( 'wp_enqueue_scripts', 'pehaarig_dequeue_dashicons', 999999 );

function et_pb_register_posttypes() {
	$labels = array(
		'name'               => esc_html__( 'Projects', 'et_builder' ),
		'singular_name'      => esc_html__( 'Project', 'et_builder' ),
		'add_new'            => esc_html__( 'Add New', 'et_builder' ),
		'add_new_item'       => esc_html__( 'Add New Project', 'et_builder' ),
		'edit_item'          => esc_html__( 'Edit Project', 'et_builder' ),
		'new_item'           => esc_html__( 'New Project', 'et_builder' ),
		'all_items'          => esc_html__( 'All Projects', 'et_builder' ),
		'view_item'          => esc_html__( 'View Project', 'et_builder' ),
		'search_items'       => esc_html__( 'Search Projects', 'et_builder' ),
		'not_found'          => esc_html__( 'Nothing found', 'et_builder' ),
		'not_found_in_trash' => esc_html__( 'Nothing found in Trash', 'et_builder' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'can_export'         => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'has_archive'        => false,
		'rewrite'            => apply_filters( 'et_project_posttype_rewrite_args', array(
			'feeds'      => true,
			'slug'       => 'project',
			'with_front' => false,
		) ),
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'author', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ),
	);

	register_post_type( 'project', apply_filters( 'et_project_posttype_args', $args ) );

	$labels = array(
		'name'              => esc_html__( 'Project Categories', 'et_builder' ),
		'singular_name'     => esc_html__( 'Project Category', 'et_builder' ),
		'search_items'      => esc_html__( 'Search Categories', 'et_builder' ),
		'all_items'         => esc_html__( 'All Categories', 'et_builder' ),
		'parent_item'       => esc_html__( 'Parent Category', 'et_builder' ),
		'parent_item_colon' => esc_html__( 'Parent Category:', 'et_builder' ),
		'edit_item'         => esc_html__( 'Edit Category', 'et_builder' ),
		'update_item'       => esc_html__( 'Update Category', 'et_builder' ),
		'add_new_item'      => esc_html__( 'Add New Category', 'et_builder' ),
		'new_item_name'     => esc_html__( 'New Category Name', 'et_builder' ),
		'menu_name'         => esc_html__( 'Categories', 'et_builder' ),
		'not_found'         => esc_html__( "You currently don't have any project categories.", 'et_builder' ),
	);

	register_taxonomy( 'project_category', array( 'project' ), array(
		'publicly_queryable' => false,
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	) );

	register_taxonomy( 'project_tag', array( 'project' ), array(
		'public' => false,
	) );

}
function pehaarig_query_vars( $qvars ) {
	if ( is_admin() ) {
		return $qvars;
	}
	if ( isset( $qvars['post_type'] ) && !isset( $qvars['name'] ) ) {
		unset( $qvars['post_type'] );
	}  
  return $qvars;
}
add_filter( 'request', 'pehaarig_query_vars' );