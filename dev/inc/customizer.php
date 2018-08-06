<?php
/**
 * WP Rig Theme Customizer
 *
 * @package wprig
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! class_exists( 'Pehaarig_Customizer' ) ) {

	class Pehaarig_Customizer {

		private static $instance = null;

		private $fields = array();

		private $plugin_screen_hook_suffix = array( '' );

		private $template_name;

		private function __construct() {

		require_once get_template_directory() . '/inc/customizer-fields.php';
		require_once get_template_directory() . '/inc/customizer-sanitize.php';
		
		$this->fields = $pehaarig_customizer_fields;

		add_action( 'customize_register', array( $this, 'custom_customize_register' ), 11 );
	}

	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function custom_customize_register( $wp_customize ) {

		$wp_customize->add_panel( 'pehaarig', array(
			'priority'       => 10,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => esc_html__( 'Theme Settings', 'pehaarig' )
		) );
		self::fields_from_array( $wp_customize, $this->fields );
	}

	public static function fields_from_array( $wp_customize, $fields ) {

		foreach( $fields as $section => $section_fields ) {

			if ( ! isset( $section_fields['section'] ) ) {
				continue;
			}
			$wp_customize->add_section(
				$section,
				$section_fields['section']
			);

			foreach ( $section_fields['settings'] as $setting => $setting_fields ) {

				if ( !isset( $setting_fields['setting_array'] ) || !isset(  $setting_fields['control_array'] ) ) {
					continue;
				}
				$settings_array = $setting_fields['setting_array'];

 				if ( ! isset( $settings_array['sanitize_callback'] ) ) {
					if ( method_exists( 'PeHaaThemes_Sanitization', 'sanitize_' . $setting_fields['control_array']['type'] ) ) {
						$settings_array['sanitize_callback'] = 'PeHaaThemes_Sanitization::sanitize_' . $setting_fields['control_array']['type'];
					} else {
						$settings_array['sanitize_callback'] = 'PeHaaThemes_Sanitization::sanitize_text';
					}
				}

				$wp_customize_method = 'add_setting';
				
				$wp_customize->$wp_customize_method(
					$setting,
					$settings_array
				);

				$control_array = $setting_fields['control_array'];
				$control_array['section'] = $section;

 				if ( 'color' === $setting_fields['control_array']['type'] ) {

					$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting, $control_array ) );

				} elseif ( 'image' === $setting_fields['control_array']['type'] ) {

					$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting, $control_array ) );

				} elseif ( 'media' === $setting_fields['control_array']['type'] ) {

					unset($control_array['type']);
					$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $setting, $control_array ) );

				} else {
					 $wp_customize->add_control(
						$setting,
						$control_array
					);
				}
				
			}

		}
	}

	/**
		 * Check if viewing one of this plugin's admin pages.
		 *
		 * @since   1.0.0
		 *
		 * @return  bool
		 */
	private function viewing_this_plugin() {		
			
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return false;
		}

		$screen = get_current_screen();

		if ( in_array( $screen->id, $this->plugin_screen_hook_suffix ) ) {
			return true;
		} else {
			return false;
		}
			
	}

}

}

Pehaarig_Customizer::get_instance();
