<?php
/**
 *
 * @package   PeHaa Themes Library
 * @author    PeHaa THEMES <info@pehaa.com>
 * @license   GPL-2.0+
 * @copyright 2015 PeHaa THEMES
 */

/**
 *
 * @package PeHaa Themes Library
 * @author  PeHaa THEMES <info@pehaa.com>
 */

if ( ! class_exists( 'PeHaaThemes_Sanitization' ) ) :

	class PeHaaThemes_Sanitization {

		private static $instance = null;

		private function __construct() {}

		public static function get_instance() {

			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;

		}

		public static function sanitize_text( $input ) {
			
			return sanitize_text_field( $input );
		}

		public static function sanitize_media( $input ) {
			
			return absint( $input );
		}

		public static function sanitize_text_with_int( $input, $th ) {
		
			if ( (int) $input ) {
				return (int) sanitize_text_field( $input );
			}
				
			return $th->default;
		}

		public static function sanitize_checkbox( $input ) {

			if ( $input == 1 ) {
				return 1;
			} else {
				return '';
			}
		}

		public static function sanitize_radio( $input, $setting ) {

			$valid = $setting->manager->get_control( $setting->id )->choices;
		
			if ( !array_key_exists( $input, $valid ) )  {
				return $setting->default;
			}
			
			return $input;

		}

		public static function sanitize_select( $input, $setting ) {

			$valid = $setting->manager->get_control( $setting->id )->choices;
		
			if ( !array_key_exists( $input, $valid ) )  {
				return $setting->default;
			}
			
			return $input;

		}

		public static function sanitize_textarea( $input ) {
			
			global $allowedposttags;
			$output = wp_kses( $input, $allowedposttags );
			return $output;

		}

		public static function sanitize_image( $input, $setting ) {
			
			return self::sanitize_upload( $input, $setting );

		}

		public static function sanitize_upload( $input, $setting ) {

			$filetype = wp_check_filetype_and_ext( $input, $input );

			$mime_type = ''; 

			if ( isset( $setting->manager->get_control( $setting->id )->mime_type ) ){
				$mime_type = $setting->manager->get_control( $setting->id )->mime_type;
			}
				

			if ( !wp_match_mime_types( $mime_type, $filetype['type'] ) ) {
				return $setting->default;
			}
			
			return esc_url_raw( $input );

		}

		public static function sanitize_texarea_with_scripts( $input ) {

			global $allowedposttags;

			$custom_allowedtags = array();
			
			$custom_allowedtags['embed'] = array(
				'src' => array(),
				'type' => array(),
				'allowfullscreen' => array(),
				'allowscriptaccess' => array(),
				'height' => array(),
				'width' => array()
			);
		
			$custom_allowedtags['script'] = array();
		
			$custom_allowedtags = array_merge( $custom_allowedtags, $allowedposttags );
			
			return wp_kses( $input, $custom_allowedtags );

		}

	}

endif;

PeHaaThemes_Sanitization::get_instance();