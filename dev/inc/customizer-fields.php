<?php
/**
 * WP Rig Theme Customizer
 *
 * @package wprig
 */

$pehaarig_customizer_fields = array(
	'yaga_logo_title_tagline' => array(
		'section' => array(
			'title' => esc_html__( 'Logo, Title and Tagline', 'wprig' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
			'yaga_hide_title' => array(
				'setting_array' => array(),
				'control_array' => array(
					'label' => esc_html__( 'Hide Site Title', 'wprig' ),
					'type' => 'checkbox',
					'description' => esc_html__( 'If checked the site title will not be displayed in the site header area.', 'wprig' ),
				),
			),
			'yaga_hide_tagline' => array(
				'setting_array' => array(),
				'control_array' => array(
					'label' => esc_html__( 'Hide Site Tagline', 'wprig' ),
					'type' => 'checkbox',
					'description' => esc_html__( 'If checked the site tagline will not be displayed in the site header area.', 'wprig' ),
				),
			),
			'yaga_logo' => array(
				'setting_array' => array(
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_image',
				),
				'control_array' => array(
					'type' => 'image',
					'label' => esc_html__( 'Logo (Standard)', 'wprig' ),
					'description' => sprintf( esc_html__( 'Upload your logo. The default display height is %s px. We recommend to create it two times bigger (%s) than you want it to be displayed (for retina screens).', 'wprig' ), PeHaaThemes_Theme_Config::$logo_height, 2 * PeHaaThemes_Theme_Config::$logo_height ),
				),
			),
			'yaga_logo_alt' => array(
				'setting_array' => array(
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_image',
				),
				'control_array' => array(
					'type' => 'image',
					'label' => esc_html__( 'Logo (Alternative)', 'wprig' ),
					'description' => sprintf( esc_html__( 'Upload an alternative version of your logo. Your image should have the same dimensions as the standard logo.', 'wprig' ), PeHaaThemes_Theme_Config::$logo_height, 2 * PeHaaThemes_Theme_Config::$logo_height ),
				),
			),
			'yaga_logo_height' => array(
				'setting_array' => array(
					'default'           => PeHaaThemes_Theme_Config::$logo_height,
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_text_with_int',
				),
				'control_array' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Logo display height', 'wprig' ),
					'description' => esc_html__( 'Type your logo display height here (your logo should be twice as high for a crispy look on retina screens).', 'wprig' ),
				),
			),
			'yaga_mini_logo' => array(
				'setting_array' => array(
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_image',
				),
				'control_array' => array(
					'type' => 'image',
					'label' => esc_html__( 'Mini Logo', 'wprig' ),
					'description' => sprintf( __( 'Upload your reduced logo version, the default height is %s px. It will be used <strong>only</strong> if you choose the Sticky or Fixed Bar navigation option (see the "Border & Navigation" panel).', 'wprig' ), 2 * PeHaaThemes_Theme_Config::$mini_logo_height ),
				),
			),
		),
	),
	'yaga_misc' => array(
		'section' => array(
			'title' => esc_html__( 'Border & Navigation', 'wprig' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
			'yaga_ml' => array(
				'setting_array' => array(
					'default' => 'normal',
				),
				'control_array' => array(
					'label' => esc_html__( 'Pages Border', 'wprig' ),
					'type' => 'select',
					'choices' => array(
						'normal' => esc_html__( 'Default, 32px on large screens.', 'wprig' ),
						'tiny' => esc_html__( 'Tiny, 12px.', 'wprig' ),
						'no' => esc_html__( 'None.', 'wprig' ),
					),
					'description' => esc_html__( 'You can set the width of the pages border here.', 'wprig' ),
				),
			),
			'yaga_navigation' => array(
				'setting_array' => array(
					'default' => 'default',
				),
				'control_array' => array(
					'label' => esc_html__( 'Type of Navigation', 'wprig' ),
					'type' => 'select',
					'choices' => array(
						'default' => esc_html__( 'Default', 'wprig' ),
						'sticky_full' => esc_html__( 'Sticky, full', 'wprig' ),
						'sticky_center' => esc_html__( 'Sticky, center', 'wprig' ),
						'top_fixed_fixed' => esc_html__( 'Fixed Bar, no scrolling effect', 'wprig' ),
						'top_fixed_center' => esc_html__( 'Fixed Bar with centered navigation', 'wprig' ),
					),
					'description' => esc_html__( 'Choose the type of navigation. "Sticky, full" will display the navigation aligned to the right and logo in the left corner.', 'wprig' ),
				),
			),
			'yaga_search_in_nav' => array(
				'setting_array' => array(
					'default' => '1',
				),
				'control_array' => array(
					'label' => esc_html__( 'Search in the Site Header', 'wprig' ),
					'description' => esc_html__( 'Add search to the main navigation menu.', 'wprig' ),
					'type' => 'checkbox',
				),
			),
		),
	),
	'yaga_preloader' => array(
		'section' => array(
			'title' => esc_html__( 'Preloader', 'wprig' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
			'yaga_preloader_in' => array(
				'setting_array' => array(
					'default' => 'on_check_and_archives',
				),
				'control_array' => array(
					'label' => esc_html__( 'Default Behavior', 'wprig' ),
					'type' => 'select',
					'description' => esc_html__( 'Choose on which pages you want to use a preloader.', 'wprig' ),
					'choices' => array(
						'on_check_and_archives' => esc_html__( 'Archive pages and Check-in/out for custom pages and posts.', 'wprig' ),
						'on_check' => esc_html__( 'Check-in/out for custom pages and posts.', 'wprig' ),
						'always' => esc_html__( 'Always', 'wprig' ),
						'never' => esc_html__( 'Never', 'wprig' ),
					),
				),
			),
		),
	),
	'yaga_footer_and_scripts' => array(
		'section' => array(
			'title' => esc_html__( 'Custom Scripts and Footer', 'wprig' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
			'yaga_header_script' => array(
				'setting_array' => array(
					'transport' => 'postMessage',
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_texarea_with_scripts',
				),
				'control_array' => array(
					'label' => esc_html__( 'Header Tracking Code', 'wprig' ),
					'description' => esc_html__( 'Paste your header-destined tracking code here (e.g. Google Analytics).', 'wprig' ),
					'type' => 'textarea',
				),
			),
			'yaga_footer_script' => array(
				'setting_array' => array(
					'transport' => 'postMessage',
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_texarea_with_scripts',
				),
				'control_array' => array(
					'label' => esc_html__( 'Footer Tracking Code', 'wprig' ),
					'description' => esc_html__( 'Paste your footer-destined tracking code here.', 'wprig' ),
					'type' => 'textarea',
				),
			),
			'yaga_footer_copy' => array(
				'setting_array' => array(),
				'control_array' => array(
					'label' => esc_html__( 'Custom copyright text (left)', 'wprig' ),
					'description' => esc_html__( 'You can modify the text displayed in the left footer copyright area.', 'wprig' ),
					'type' => 'textarea',
				),
			),
			'yaga_footer_copy_right' => array(
				'setting_array' => array(),
				'control_array' => array(
					'label' => esc_html__( 'Custom copyright text (right)', 'wprig' ),
					'description' => esc_html__( 'You can modify the text displayed in the right footer copyright area.', 'wprig' ),
					'type' => 'textarea',
				),
			),
			'yaga_fixed_footer' => array(
				'setting_array' => array(
					'default' => '1',
				),
				'control_array' => array(
					'label' => esc_html__( 'Fixed footer', 'wprig' ),
					'description' => esc_html__( 'Enable fixed (parallax) footer behavior applied on wide screens over 1280px.', 'wprig' ),
					'type' => 'checkbox',
				),
			),
		),
	),
	'yaga_login' => array(
		'section' => array(
			'title' => esc_html__( 'Dashboard Login', 'wprig' ),
			'panel' => 'pehaarig',
			'description' => sprintf( wp_kses( __( 'These settings concern the login screen and cannot be previewed within this customizer screen. To see the changes you need to Save and Publish first, then go to the <a href="%s" target="_blank">login screen.</a>', 'wprig' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( wp_login_url() ) ),
		),
		'settings' => array(
			'yaga_login_logo' => array(
				'setting_array' => array(
					'transport' => 'postMessage',
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_image',
				),
				'control_array' => array(
					'type' => 'image',
					'label' => esc_html__( 'Login Logo', 'wprig' ),
					'description' => sprintf( esc_html__( 'Upload your logo, the default height is %s px', 'wprig' ), 2 * 84 ),
				),
			),
		),
	),
	'yaga_sidebar' => array(
		'section' => array(
			'title'       => esc_html__( 'Sidebar', 'wprig' ),
			'description' => esc_html__( 'The sidebar widgets are only displayed if there are widgets associated with the Sidebar Widgets Area.', 'wprig' ),
			'panel'       => 'pehaarig',
		),
		'settings' => array(
			'yaga_sidebar_position' => array(
				'setting_array' => array(
					'default' => 'right',
				),
				'control_array' => array(
					'label' => esc_html__( 'Sidebar position', 'wprig' ),
					'description' => esc_html__( 'Choose the sidebar position.', 'wprig' ),
					'type' => 'radio',
					'choices' => array(
						'left' => esc_html__( 'Left', 'wprig' ),
						'right' => esc_html__( 'Right', 'wprig' ),
					),
				),
			),
			'yaga_blog_sidebar' => array(
				'setting_array' => array(
					'default' => '1',
				),
				'control_array' => array(
					'label'           => esc_html__( 'Sidebar on blog page', 'wprig' ),
					'description'     => esc_html__( 'Choose your blog layout.', 'wprig' ),
					'type'            => 'checkbox',
					'active_callback' => array( $this, 'front_and_home' ),
				),
			),
		),
	),
	'yaga_blog' => array(
		'section' => array(
			'title'       => esc_html__( 'Blog', 'wprig' ),
			'description' => esc_html__( 'Customize the way the blog pages (index, categories) are displayed', 'wprig' ),
			'panel'       => 'pehaarig',
		),
		'settings' => array(
			'yaga_pagination' => array(
				'setting_array' => array(
					'default' => 'standard',
				),
				'control_array' => array(
					'label' => esc_html__( 'Pagination', 'wprig' ),
					'description' => esc_html__( 'Choose your pagination option.', 'wprig' ),
					'type' => 'radio',
					'choices' => array(
						'standard' => esc_html__( 'Standard Pagination', 'wprig' ),
						'loadmore' => esc_html__( 'Load More Button', 'wprig' ),
					),
				),
			),
			'yaga_blog_option' => array(
				'setting_array' => array(
					'default' => 'grid',
				),
				'control_array' => array(
					'label' => esc_html__( 'Blog Layout', 'wprig' ),
					'description' => esc_html__( 'Choose your blog layout.', 'wprig' ),
					'type' => 'radio',
					'choices' => array(
						'grid' => esc_html__( 'Grid View', 'wprig' ),
						'classic' => esc_html__( 'One Column View', 'wprig' ),
					),
				),
			),
			'yaga_truncate_title' => array(
				'setting_array' => array(
					'default' => '',
				),
				'control_array' => array(
					'label' => esc_html__( 'Truncate title', 'wprig' ),
					'description' => esc_html__( 'Truncate the post title (...) so that it does not take more than one line.', 'wprig' ),
					'type' => 'checkbox',
				),
			),
			'yaga_top_meta' => array(
				'setting_array' => array(
					'default' => 'date',
				),
				'control_array' => array(
					'label' => esc_html__( 'Above the post title', 'wprig' ),
					'description' => esc_html__( 'Choose what to display above the post title', 'wprig' ),
					'type' => 'radio',
					'choices' => array(
						'date' => esc_html__( 'Date', 'wprig' ),
						'categories' => esc_html__( 'Category', 'wprig' ),
						'author' => esc_html__( 'Author', 'wprig' ),
						'empty' => esc_html__( 'Empty', 'wprig' ),
					),
				),
			),
			'yaga_date_in_bottom_meta' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$entry_bottom_meta['date'],
				),
				'control_array' => array(
					'label' => esc_html__( 'Date', 'wprig' ),
					'description' => esc_html__( 'Display date in bottom meta area', 'wprig' ),
					'type' => 'checkbox',
				),
			),
			'yaga_author_in_bottom_meta' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$entry_bottom_meta['author'],
				),
				'control_array' => array(
					'label' => esc_html__( 'Author', 'wprig' ),
					'description' => esc_html__( 'Display author in bottom meta area', 'wprig' ),
					'type' => 'checkbox',
				),
			),
			'yaga_categories_in_bottom_meta' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$entry_bottom_meta['categories'],
				),
				'control_array' => array(
					'label' => esc_html__( 'Categories', 'wprig' ),
					'description' => esc_html__( 'Display categories in bottom meta area', 'wprig' ),
					'type' => 'checkbox',
				),
			),
			'yaga_comments_in_bottom_meta' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$entry_bottom_meta['comments'],
				),
				'control_array' => array(
					'label' => esc_html__( 'Comments', 'wprig' ),
					'description' => esc_html__( 'Display comments link in bottom meta area', 'wprig' ),
					'type' => 'checkbox',
				),
			),
		),
	),
	'yaga_comments' => array(
		'section' => array(
			'title' => esc_html__( 'Comments', 'wprig' ),
			'description' => esc_html__( 'Customize the way the comments are displayed', 'wprig' ),
			'active_callback' => array( $this, 'should_comments_display' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
			'yaga_comments_display' => array(
				'setting_array' => array(
					'default' => 'toggle_closed',
				),
				'control_array' => array(
					'label' => esc_html__( 'Comments display', 'wprig' ),
					'type' => 'radio',
					'choices' => array(
						'show' => esc_html__( 'Always show', 'wprig' ),
						'toggle_closed' => esc_html__( 'Toggle (closed on page load)', 'wprig' ),
						'toggle_opened' => esc_html__( 'Toggle (opened on page load)', 'wprig' ),
					),
				),
			),
			'yaga_comments_area_title' => array(
				'setting_array' => array(
					'default' => esc_html__( 'Discussion', 'wprig' ),
				),
				'control_array' => array(
					'label' => esc_html__( 'Comments area title', 'wprig' ),
					'type' => 'text',
				),
			),
			'yaga_comments_area_subtitle' => array(
				'setting_array' => array(
					'default' => esc_html__( 'Leave a reply', 'wprig' ),
				),
				'control_array' => array(
					'label' => esc_html__( 'Comments area subtitle', 'wprig' ),
					'type' => 'text',
				),
			),
			'yaga_avatar_display' => array(
				'setting_array' => array(
					'default' => 'visible_round',
				),
				'control_array' => array(
					'label' => esc_html__( 'Avatars display', 'wprig' ),
					'type' => 'radio',
					'choices' => array(
						'visible_round' => esc_html__( 'Visible, circle', 'wprig' ),
						'visible_square' => esc_html__( 'Visible, square', 'wprig' ),
						'hidden' => esc_html__( 'Not displayed', 'wprig' ),
					),
				),
			),
			'yaga_comment_notes_before' => array(
				'setting_array' => array(
					'default' => esc_html__( 'Your email address will not be published. Required fields are marked *', 'wprig' ),
				),
				'control_array' => array(
					'label' => esc_html__( 'Note before form', 'wprig' ),
					'type' => 'textarea',
				),
			),
		),
	),
	'yaga_fonts' => array(
		'section' => array(
			'title' => esc_html__( 'Fonts', 'wprig' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
			'yaga_body_font_face' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$body_font,
				),
				'control_array' => array(
					'label' => esc_html__( 'Body Font', 'wprig' ),
					'description'  => sprintf( wp_kses( __( 'Quickly add a custom Google Font for body from <a href="%s" target="_blank">Google Font Directory.</a> Make sure that the italic, bold and bold italic styles exist. Set the normal and bold weights in the fields below.', 'wprig' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'www.google.com/webfonts/' ) ),
					'type' => 'text',
				),
			),
			'yaga_body_font_family' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$body_font_family,
				),
				'control_array' => array(
					'label' => esc_html__( 'Body Font Family', 'wprig' ),
					'description' => esc_html__( 'Generic font family for font subsitution.', 'wprig' ),
					'type' => 'select',
					'choices' => array(
						'serif' => esc_html__( 'Serif', 'wprig' ),
						'sans-serif' => esc_html__( 'Sans Serif', 'wprig' ),
						'monospace' => esc_html__( 'Monospace', 'wprig' ),
						'cursive' => esc_html__( 'Cursive', 'wprig' ),
						'fantasy' => esc_html__( 'Fantasy', 'wprig' ),
					),
				),
			),
			'yaga_body_normal_font_face_weight' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$body_normal_weight,
				),
				'control_array' => array(
					'label' => esc_html__( 'Base body font-face weight', 'wprig' ),
					'type' => 'select',
					'choices' => $weights,
				),
			),
			'yaga_body_bold_font_face_weight' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$body_bold_weight,
				),
				'control_array' => array(
					'label' => esc_html__( 'Bold body font-face weight', 'wprig' ),
					'type' => 'select',
					'choices' => $weights,
				),
			),
			'yaga_headings_font_face' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$headings_font,
				),
				'control_array' => array(
					'label' => esc_html__( 'Headings Font', 'wprig' ),
					'type' => 'text',
				),
			),
			'yaga_headings_font_family' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$headings_font_family,
				),
				'control_array' => array(
					'label' => esc_html__( 'Headings Font Family', 'wprig' ),
					'description' => esc_html__( 'Generic font family for font subsitution.', 'wprig' ),
					'type' => 'select',
					'choices' => array(
						'serif' => esc_html__( 'Serif', 'wprig' ),
						'sans-serif' => esc_html__( 'Sans Serif', 'wprig' ),
						'monospace' => esc_html__( 'Monospace', 'wprig' ),
						'cursive' => esc_html__( 'Cursive', 'wprig' ),
						'fantasy' => esc_html__( 'Fantasy', 'wprig' ),
					),
				),
			),
			'yaga_headings_font_face_weight' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$headings_weight,
				),
				'control_array' => array(
					'label' => esc_html__( 'Base body font-face weight', 'wprig' ),
					'type' => 'select',
					'choices' => $weights,
				),
			),
			'yaga_caps' => array(
				'setting_array' => array(
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Caps', 'wprig' ),
					'description' => esc_html__( 'Check here to capitalize all headings.', 'wprig' ),
					'type' => 'checkbox',
				),
			),
			'yaga_headings_in_navbar' => array(
				'setting_array' => array(
					'default' => 'sans-serif' === PeHaaThemes_Theme_Config::$headings_font_family ? '1' : '',
				),
				'control_array' => array(
					'label' => esc_html__( 'Navigation and Buttons', 'wprig' ),
					'description' => esc_html__( 'Check here to use the headings font family for the navigation and buttons.', 'wprig' ),
					'type' => 'checkbox',
				),
			),
		),
	),
	'colors' => array(
		'section' => array(
			'title' => esc_html__( 'Colors', 'wprig' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
			'yaga_link_color' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$link_color,
					'sanitize_callback'    => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Link', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_link_color_1' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$link_color_1,
					'sanitize_callback'    => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Link on Hover', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_html_bg' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$html_bg,
					'sanitize_callback'    => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Body Background', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_text_color' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$color,
					'sanitize_callback'    => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Body Text', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_main_nav_drop_bg' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$main_nav_drop_bg,
					'sanitize_callback' => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Menu Drop-downs Background', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_main_nav_drop_color' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$color,
					'sanitize_callback' => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Menu Drop-downs Text', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_footer_bg' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$footer_bg,
					'sanitize_callback' => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Footer Background', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_footer_color' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$footer_color,
					'sanitize_callback' => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Footer Text', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_footer_copy_bg' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$footer_copy_bg,
					'sanitize_callback' => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Footer Copyright Background', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_footer_copy_color' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$footer_color,
					'sanitize_callback' => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Footer Copyright Text', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_box_bg' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$box_bg,
					'sanitize_callback'    => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Boxes Background', 'wprig' ),
					'description'  => esc_html__( 'Sidebar widgets, post content in index view, ...', 'wprig' ),
					'type' => 'color',
				),
			),
			'yaga_border_bg' => array(
				'setting_array' => array(
					'default' => PeHaaThemes_Theme_Config::$box_bg,
					'sanitize_callback'    => 'sanitize_hex_color',
					'transport' => 'postMessage',
				),
				'control_array' => array(
					'label' => esc_html__( 'Site Border Color', 'wprig' ),
					'type' => 'color',
				),
			),
		),
	),
);