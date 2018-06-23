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

			$weights = array(
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'500' => '500',
				'600' => '600',
				'700' => '700',
				'800' => '800',
				'900' => '900',
			);

			require_once get_template_directory() . '/inc/customizer-fields.php';
			require_once get_template_directory() . '/inc/customizer-sanitize.php';
		
			$this->fields = $pehaarig_customizer_fields;

			$this->template_name = 'pehaarig_customizer_css';

			add_action( 'customize_register', array( $this, 'custom_customize_register'), 11 );
		//add_action( 'customize_preview_init', array( $this, 'preview_enqueue_scripts' ) );
		//add_action( 'customize_controls_print_footer_scripts', array( $this, 'customizer_css_template' ) );
		//add_action( 'customize_controls_enqueue_scripts', array( $this, 'controls_enqueue_scripts' ) );
		//add_action( 'customize_controls_print_styles', array( $this, 'enqueue_customizer_stylesheet' ) );

		//add_action( 'wp_enqueue_scripts', array( $this, 'custom_styles' ), 11 );

	}

	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;

	}

	public function controls_enqueue_scripts() {
		wp_enqueue_script( 'yaga-color-controls', get_template_directory_uri() . '/js/min.yaga-color-controls.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '0.0.1', true );
		$settings = array(
			'yaga_text_color',
			'yaga_html_bg',
			'yaga_main_nav_drop_bg',
			'yaga_main_nav_drop_color',
			'yaga_footer_bg',
			'yaga_footer_color',
			'yaga_footer_copy_bg',
			'yaga_footer_copy_color',
			'yaga_box_bg',
			'yaga_border_bg',
			'yaga_link_color',
			'yaga_link_color_1',
			'yaga_caps',
			'yaga_custom_css'
		);
		wp_localize_script( 'yaga-color-controls', 'yaga_Settings', array( 'settings' => $settings, 'template' => $this->template_name ) );
	}

	/**
	 * Register the js.
	 *
	 * @since    1.0.0
	 */
	public function preview_enqueue_scripts() {

		wp_enqueue_script( 'yaga-customize-preview', get_template_directory_uri() . '/js/min.yaga-customizer.js', array( 'customize-preview' ), '0.0.1', true );
		
	}

	public function enqueue_customizer_stylesheet() {
		wp_enqueue_style( 'yaga-customize-css', get_template_directory_uri() . '/css/customizer.css', array(), '0.0.1' );
	}

	public function custom_customize_register( $wp_customize ) {

		//$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		//$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		$wp_customize->add_panel( 'pehaarig', array(
			'priority'       => 10,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => sprintf( esc_html__( '%s Settings', 'yaga'), 'pehaarig' ),
			'description'    => esc_html__( 'This theme specific settings', 'yaga' )
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

	public function should_comments_display() {
		return is_single() && ( comments_open() || get_comments_number() );
	}

	public function front_and_home() {
		return is_home() && is_front_page();
	}

	/**
	 * Output an Underscore template for generating CSS from the customizer settings
	 *
	 * The template generates the css dynamically for instant display in the Customizer
	 * preview.
	 *
	 * @since 1.0
	 */
	public function customizer_css_template() {


		$settings = array(
			'yaga_text_color'  => '{{ data.yaga_text_color }}',
			'yaga_html_bg'            => '{{ data.yaga_html_bg }}',
			'yaga_main_nav_drop_bg' => '{{ data.yaga_main_nav_drop_bg }}',
			'yaga_main_nav_drop_color' => '{{ data.yaga_main_nav_drop_color }}',
			'yaga_footer_bg'=> '{{ data.yaga_footer_bg }}',
			'yaga_footer_color'=> '{{ data.yaga_footer_color }}',
			'yaga_footer_copy_bg' => '{{ data.yaga_footer_copy_bg }}',
			'yaga_footer_copy_color' => '{{ data.yaga_footer_copy_color }}',
			'yaga_box_bg' => '{{ data.yaga_box_bg }}',
			'yaga_border_bg' => '{{ data.yaga_border_bg }}',
			'yaga_link_color' => '{{ data.yaga_link_color }}',
			'yaga_link_color_1' => '{{ data.yaga_link_color_1 }}',
			'yaga_link_color_1r' => '{{ (parseInt(data.yaga_link_color_1.replace("#", ""), 16) >> 16) & 255 }}',
			'yaga_link_color_1g' => '{{ (parseInt(data.yaga_link_color_1.replace("#", ""), 16) >> 8) & 255 }}',
			'yaga_link_color_1b' => '{{ parseInt(data.yaga_link_color_1.replace("#", ""), 16) & 255 }}',
			'yaga_text_transform' => '{{ data.yaga_caps == "1" ? "uppercase" : "none" }}',
			'yaga_custom_css' => '{{ data.yaga_custom_css }}'
		);
		?>
		<script type="text/html" id="tmpl-<?php echo esc_attr( $this->template_name ); ?>">
			<?php $this->customizer_css( $settings ); ?>
		</script>
		<?php
	}

	private	function customizer_css( $settings = NULL ) {
		
		$settings = wp_parse_args( $settings, array(
			'yaga_text_color' => pehaathemes_get_theme_mod_not_empty('yaga_text-color', PeHaaThemes_Theme_Config::$color ),
			'yaga_html_bg' => pehaathemes_get_theme_mod_not_empty('yaga_html_bg', PeHaaThemes_Theme_Config::$html_bg ),
			'yaga_main_nav_drop_bg' => pehaathemes_get_theme_mod_not_empty( 'yaga_main_nav_drop_bg', PeHaaThemes_Theme_Config::$main_nav_drop_bg ),
			'yaga_main_nav_drop_color' => pehaathemes_get_theme_mod_not_empty( 'yaga_main_nav_drop_color', PeHaaThemes_Theme_Config::$color ),
			'yaga_footer_bg' => pehaathemes_get_theme_mod_not_empty( 'yaga_footer_bg', PeHaaThemes_Theme_Config::$footer_bg ),
			'yaga_footer_color' => pehaathemes_get_theme_mod_not_empty( 'yaga_footer_color', PeHaaThemes_Theme_Config::$footer_color ),
			'yaga_footer_copy_bg' => pehaathemes_get_theme_mod_not_empty( 'yaga_footer_copy_bg', PeHaaThemes_Theme_Config::$footer_copy_bg ),
			'yaga_footer_copy_color' => pehaathemes_get_theme_mod_not_empty( 'yaga_footer_color', PeHaaThemes_Theme_Config::$footer_color ),
			'yaga_box_bg' => pehaathemes_get_theme_mod_not_empty( 'yaga_box_bg', PeHaaThemes_Theme_Config::$box_bg ),
			'yaga_border_bg' => pehaathemes_get_theme_mod_not_empty( 'yaga_border_bg', PeHaaThemes_Theme_Config::$box_bg ),
			'yaga_link_color' => pehaathemes_get_theme_mod_not_empty( 'yaga_link_color', PeHaaThemes_Theme_Config::$link_color ),
			'yaga_link_color_1' => pehaathemes_get_theme_mod_not_empty( 'yaga_link_color_1', PeHaaThemes_Theme_Config::$link_color_1 ),
			'yaga_link_color_1r' => '',
			'yaga_link_color_1g' => '',
			'yaga_link_color_1b' => '',
			'opacity' => PeHaaThemes_Theme_Config::$hover_overlay_opacity,
			'yaga_text_transform' => 'none',
			'yaga_custom_css' => ''
		) );
		echo <<<CSS
		html {
			background-color: {$settings['yaga_html_bg']};
			color:{$settings['yaga_text_color']};
			border-color:{$settings['yaga_border_bg']};

		}
		.phtpb_section {background-color: {$settings['yaga_html_bg']};}
		.pht-gallery {
			color: {$settings['yaga_html_bg']};
		}
		.pht-full-menu .main-nav__ctnr .sub-menu {
			background: {$settings['yaga_main_nav_drop_bg']};
			color: {$settings['yaga_main_nav_drop_color']};
		}
		.site-footer {
			background-color: {$settings['yaga_footer_bg']};
		}
		.site-footer__sidebar {
			color: {$settings['yaga_footer_color']};
		}
		.site-footer__info {
			background:{$settings['yaga_footer_copy_bg']};
			color:{$settings['yaga_footer_copy_color']};
		}
		.pht-box--highlight,.bypostauthor,.woocommerce-account .order-info,.woocommerce-cart .cart-collaterals .cart_totals, .pht-sidebar >:nth-child(n) {
			 background:{$settings['yaga_box_bg']};
		}
		.pht--top-fixed-navigation .site-header, .pht--top_fixed_fixed-navigation .site-header {
			 background:{$settings['yaga_border_bg']};
		}
		a {
			color:{$settings['yaga_link_color']};
		}
		a:hover,.container-a--h a:hover, .a-a--h:hover{
			color:{$settings['yaga_link_color_1']};
		}
		.pht-fig__link--hoverdir{
			background:rgba({$settings['yaga_link_color_1r']},{$settings['yaga_link_color_1g']},{$settings['yaga_link_color_1b']},{$settings['opacity']});
		}
		h1, h2, h3, h4, h5, h6, .pht-secondfont {
			text-transform:{$settings['yaga_text_transform']};
		}
		.subtitle, .pht-subtitle {text-transform:none}

		{$settings['yaga_custom_css']} 
CSS;
	}

	public function custom_styles() {

		$custom_css = '';
		
		if ( '' !== $custom_css ) {
			$deps = apply_filters( 'pehaathemes_load_stylesheet_css', true ) ? 'pehaathemes-s-style' : 'pehaathemes-t-style';
			wp_add_inline_style( $deps, $custom_css );
		}

	}
	
}

}

Pehaarig_Customizer::get_instance();