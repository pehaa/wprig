<?php
/**
 * WP Rig Theme Customizer
 *
 * @package wprig
 */

$pehaarig_customizer_fields = array(
	'yaga_logo_title_tagline' => array(
		'section' => array(
			'title' => esc_html__( 'Logo Settings', 'wprig' ),
			'panel' => 'pehaarig',
		),
		'settings' => array(
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
					'description' => esc_html__( 'Enable custom logo animation', 'wprig' ),
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
	'pehaarig_blog' => array(
		'section' => array(
			'title' => esc_html__( 'Blog functionality (optional)', 'wprig' ),
			'panel' => 'pehaarig',
		),	
		'settings' => array(
			'pehaarig_archives_redirection' => array(
				'setting_array' => array(
					'default' => '1',
				),
				'control_array' => array(
					'label' => esc_html__( 'Redirect all archives to homepage', 'wprig' ),
					'description' => esc_html__( 'This setting should probably be deactivated when the blog functionality is uses. You can still disable some type of archives via Yoast SEO settings.', 'wprig' ),
					'type' => 'checkbox',
				),
			),
			'pehaarig_sidebar' => array(
				'setting_array' => array(
					'default' => '',
				),
				'control_array' => array(
					'label' => esc_html__( 'Enable sidebar', 'wprig' ),
					'description' => esc_html__( 'Right widgets area will be addes to single posts and archives pages.', 'wprig' ),
					'type' => 'checkbox',
				),
			),
		),
	),
);
