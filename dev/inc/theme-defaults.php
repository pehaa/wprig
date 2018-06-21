<?php
/**
 *
 * @package   Yaga
 * @subpackage   Yaga/includes
 * @author    PeHaa THEMES <info@pehaa.com>
 * @since Yaga 1.0.0
 */

/**
 * Theme configuration class.
 *
 * @package Yaga
 * @author  PeHaa THEMES <info@pehaa.com>
 */

if ( ! class_exists( 'PeHaaThemes_Theme_Config' ) ) :

	class PeHaaThemes_Theme_Config {

		public static $id = 0;

		private static $custom_width = 1140;

		private static $alt_custom_width = 752;

		private static $instance = null;

		public static $navigation = 'default';

		public $megamenu = true;

		public static $navigation_breakpoint = 1280;

		public static $body_font = 'Merriweather';

		public static $body_normal_weight = '400';

		public static $body_bold_weight = '700';

		public static $body_font_family = 'serif';

		public static $headings_font = 'Unica One';

		public static $headings_font_family = 'sans-serif';

		public static $headings_weight = '400';

		public static $logo_height = 48;

		public static $mini_logo_height = 32;

		public static $html_bg = '#f6f6f6';

		public static $main_nav_drop_bg = '#ffffff';

		public static $footer_bg = '#e0e1e2';

		public static $footer_copy_bg = '#d9dadb';

		public static $box_bg = '#ffffff';

		public static $link_color = '#818181';

		public static $link_color_1 = '#a7bec9';

		public static $hover_overlay_opacity = 0.85;

		public static $overlay_bg = '#f6f6f6';

		public static $color = '#303030';

		public static $footer_color = '#303030';

		public static $entry_bottom_meta = array(

			'date' => false,

			'author' => '1',

			'categories' => '1',
			
			'comments' => '1'
		);

		public static $search_in_nav = true;


		private function __construct() {

		}

		public static function get_instance() {

			if ( null == self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;

		}

		public function theme_child_ready() {

			$to_apply_filters = get_class_vars( __CLASS__ );

			foreach ( $to_apply_filters as $key => $array ) {

				if ( in_array( $key, array( 'phtpb', 'instance', 'sidebar', 'load_more_nonce' ) ) ) {
					continue;
				}

				if ( isset( $this->$key ) ) {

					$this->$key = apply_filters( 'yaga_' . $key, $this->$key );

				} elseif ( isset( self::$$key ) ) {

					self::$$key = apply_filters( 'yaga_' . $key, self::$$key );

				}

			}

		}

		private function load_classes_and_template_tags() {
		}

		public static function yaga_extend_library() {
		}

		

	}

endif;