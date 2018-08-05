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
			'pehaarig_hide_title' => array(
				'setting_array' => array(),
				'control_array' => array(
					'label'       => esc_html__( 'Hide Site Title', 'wprig' ),
					'type'        => 'checkbox',
					'description' => esc_html__( 'If checked the site title will not be displayed in the site header area.', 'wprig' ),
				),
			),
			'pehaarig_hide_tagline' => array(
				'setting_array' => array(),
				'control_array' => array(
					'label'       => esc_html__( 'Hide Site Tagline', 'wprig' ),
					'type'        => 'checkbox',
					'description' => esc_html__( 'If checked the site tagline will not be displayed in the site header area.', 'wprig' ),
				),
			),
			'pehaarig_logo_main' => array(
				'setting_array' => array(
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_media',
				),
				'control_array' => array(
					'type'        => 'media',
					'label'       => esc_html__( 'Logo', 'wprig' ),
					'description' => esc_html__( 'Upload your logo.', 'wprig' ),
					'mime_type'   => 'image',
				),
			),
			'pehaarig_logo_height' => array(
				'setting_array' => array(
					'default'           => PeHaaThemes_Theme_Config::$logo_height,
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_text_with_int',
				),
				'control_array' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Logo display height', 'wprig' ),
				),
			),
			'pehaarig_logo_footer' => array(
				'setting_array' => array(
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_media',
				),
				'control_array' => array(
					'type'        => 'media',
					'label'       => esc_html__( 'Logo - version footer', 'wprig' ),
					'description' => esc_html__( 'Upload your footer logo.', 'wprig' ),
					'mime_type'   => 'image',
				),
			),
			'pehaarig_animate_logo' => array(
				'setting_array' => array(
					'default' => '',
				),
				'control_array' => array(
					'label' => esc_html__( 'Animated Logo', 'wprig' ),
					'description' => esc_html__( 'Enable animated logo', 'wprig' ),
					'type' => 'checkbox',
				),
			),
		),
	),
	'pehaarig_affiliation' => array(
		'section' => array(
			'title' => esc_html__( 'Affiliation', 'wprig' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
			'pehaarig_logo_affiliate' => array(
				'setting_array' => array(
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_media',
				),
				'control_array' => array(
					'type'        => 'media',
					'label'       => esc_html__( 'Affiliate Logo', 'wprig' ),
					'description' => esc_html__( 'Upload your affiliate logo.', 'wprig' ),
					'mime_type'   => 'image',
				),
			),
			'pehaarig_link_affiliate' => array(
				'setting_array' => array(
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_url',
				),
				'control_array' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Affiliate Link', 'wprig' ),
					'description' => esc_html__( 'Paste the url of your affiliate organisation.', 'wprig' ),
				),
			),
		),
	),
	'pehaarig_donation_button' => array(
		'section' => array(
			'title' => esc_html__( 'Donation', 'wprig' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
			'pehaarig_link_donate' => array(
				'setting_array' => array(
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_url',
				),
				'control_array' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Donation Link', 'wprig' ),
					'description' => esc_html__( 'Paste the url of your donation organisation.', 'wprig' ),
				),
			),
			'pehaarig_link_donate_new_tab' => array(
				'setting_array' => array(
					'default' => '1',
				),
				'control_array' => array(
					'label' => esc_html__( 'Open in new tab', 'wprig' ),
					'type' => 'checkbox',
				),
			),
		),
	),
	'pehaarig_social' => array(
		'section' => array(
			'title' => esc_html__( 'Follow us footer buttons', 'wprig' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
			'pehaarig_linkedin' => array(
				'setting_array' => array(
					'sanitize_callback' => 'PeHaaThemes_Sanitization::sanitize_url',
				),
				'control_array' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Linkedin URL', 'wprig' ),
					'description' => esc_html__( 'Paste the url of your linkedin profile.', 'wprig' ),
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
);
