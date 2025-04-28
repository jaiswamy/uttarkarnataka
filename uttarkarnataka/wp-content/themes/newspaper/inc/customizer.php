<?php
/**
 * Mystery Theme Customizer.
 *
 * @package    Newspaper
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2015, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @since      1.0.0
 */

/**
 * Load textarea control for the customizer.
 *
 * @since  1.0.0
 */
function newspaper_textarea_customize_control() {
	require trailingslashit( get_template_directory() ) . 'inc/classes/customize-control-textarea.php';
}
add_action( 'customize_register', 'newspaper_textarea_customize_control', 1 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since 1.0.0
 */
function newspaper_customize_preview_js() {
	wp_enqueue_script( 'newspaper_customizer', trailingslashit( get_template_directory_uri() ) . 'assets/js/customizer.js', array( 'customize-preview' ), null, true );
}
add_action( 'customize_preview_init', 'newspaper_customize_preview_js' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since  1.0.0
 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function newspaper_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport            = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport     = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport    = 'postMessage';

	// Get the theme settings value.
	$options = optionsframework_options();

	// ==== Logo Setting ==== //
	$wp_customize->add_section(
		'newspaper_logo_section',
		array(
			'title'       => esc_html__( 'Logo', 'newspaper' ),
			'description' => __( 'If you use logo, the title and tagline will be replaced with the logo you uploaded.', 'newspaper' ),
			'priority'    => 25,
		)
	);

		$wp_customize->add_setting(
			'newspaper[newspaper_logo]',
			array(
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

			$wp_customize->add_control(
				new WP_Customize_Image_Control( $wp_customize, 'newspaper_logo_control',
				array(
					'label'    => $options['newspaper_logo']['name'],
					'section'  => 'newspaper_logo_section',
					'settings' => 'newspaper[newspaper_logo]'
				)
			) );

		$wp_customize->add_setting(
			'newspaper[newspaper_logo_retina]',
			array(
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

			$wp_customize->add_control(
				new WP_Customize_Image_Control( $wp_customize, 'newspaper_logo_retina_control',
				array(
					'label'    => $options['newspaper_logo_retina']['name'],
					'section'  => 'newspaper_logo_section',
					'settings' => 'newspaper[newspaper_logo_retina]'
				)
			) );

	// ==== Favicon Setting ==== //
	$wp_customize->add_section(
		'newspaper_favicon_settings',
		array(
			'title'       => esc_html__( 'Favicon', 'newspaper' ),
			'description' => $options['newspaper_favicon']['desc'],
			'priority'    => 28,
		)
	);

		$wp_customize->add_setting(
			'newspaper[newspaper_favicon]',
			array(
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

			$wp_customize->add_control(
				new WP_Customize_Image_Control( $wp_customize, 'newspaper_favicon_control',
				array(
					'label'    => $options['newspaper_favicon']['name'],
					'section'  => 'newspaper_favicon_settings',
					'settings' => 'newspaper[newspaper_favicon]'
				)
			) );

		$wp_customize->add_setting(
			'newspaper[newspaper_mobile_icon]',
			array(
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

			$wp_customize->add_control(
				new WP_Customize_Image_Control( $wp_customize, 'newspaper_mobile_icon_control',
				array(
					'label'    => $options['newspaper_mobile_icon']['name'],
					'section'  => 'newspaper_favicon_settings',
					'settings' => 'newspaper[newspaper_mobile_icon]'
				)
			) );

	// ==== Single Post Setting ==== //
	$wp_customize->add_section(
		'newspaper_post_setting',
		array(
			'title'    => esc_html__( 'Single Post', 'newspaper' ),
			'priority' => 190,
		)
	);

		$wp_customize->add_setting(
			'newspaper[newspaper_ad_single_before]',
			array(
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'newspaper_sanitize_customizer_textarea'
			)
		);

			$wp_customize->add_control( 
				new Newspaper_Customize_Control_Textarea( $wp_customize, 'newspaper_ad_before_control',
				array(
					'label'    => $options['newspaper_ad_single_before']['name'],
					'section'  => 'newspaper_post_setting',
					'settings' => 'newspaper[newspaper_ad_single_before]'
				)
			) );

		$wp_customize->add_setting(
			'newspaper[newspaper_ad_single_after]',
			array(
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'newspaper_sanitize_customizer_textarea'
			)
		);

			$wp_customize->add_control( 
				new Newspaper_Customize_Control_Textarea( $wp_customize, 'newspaper_ad_after_control',
				array(
					'label'    => $options['newspaper_ad_single_after']['name'],
					'section'  => 'newspaper_post_setting',
					'settings' => 'newspaper[newspaper_ad_single_after]'
				)
			) );

	// ==== Advertisement Setting ==== //
	$wp_customize->add_section(
		'newspaper_ad_setting',
		array(
			'title'       => esc_html__( 'Advertisement', 'newspaper' ),
			'priority'    => 195,
		)
	);

		$wp_customize->add_setting(
			'newspaper[newspaper_header_ad]',
			array(
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'newspaper_sanitize_customizer_textarea'
			)
		);

			$wp_customize->add_control( 
				new Newspaper_Customize_Control_Textarea( $wp_customize, 'newspaper_header_ad_control',
				array(
					'label'    => $options['newspaper_header_ad']['name'],
					'section'  => 'newspaper_ad_setting',
					'settings' => 'newspaper[newspaper_header_ad]'
				)
			) );

	// ==== Footer Text Setting ==== //
	$wp_customize->add_section(
		'newspaper_footer_settings',
		array(
			'title'       => $options['newspaper_footer_text']['name'],
			'description' => $options['newspaper_footer_text']['desc'],
			'priority'    => 200,
		)
	);

		$wp_customize->add_setting(
			'newspaper[newspaper_footer_text]',
			array(
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'newspaper_sanitize_customizer_textarea'
			)
		);

			$wp_customize->add_control( 
				new Newspaper_Customize_Control_Textarea( $wp_customize, 'newspaper_footer_control',
				array(
					'label'    => $options['newspaper_footer_text']['name'],
					'section'  => 'newspaper_footer_settings',
					'settings' => 'newspaper[newspaper_footer_text]'
				)
			) );

}
add_action( 'customize_register', 'newspaper_customize_register' );

if ( ! function_exists( 'newspaper_sanitize_customizer_textarea' ) ) {
	/**
	 * Sanitize chooser.
	 *
	 * @since  1.0.1
	 */
	function newspaper_sanitize_customizer_textarea( $string ) {
		return stripslashes( $string );
	}
}

if ( ! function_exists( 'newspaper_sanitize_checkbox' ) ) {
	/**
	 * Sanitize a checkbox to only allow 0 or 1
	 *
	 * @since  1.0.0.
	 *
	 * @param  boolean    $value    The unsanitized value.
	 * @return boolean				The sanitized boolean.
	 */
	function newspaper_sanitize_checkbox( $value ) {
		if ( $value == 1 ) {
			return 1;
		} else {
			return 0;
		}
	}
}

if ( ! function_exists( 'newspaper_sanitize_chooser' ) ) {
	/**
	 * Sanitize chooser.
	 *
	 * @since  1.0.1
	 */
	function newspaper_sanitize_chooser( $input ) {
		global $wp_customize;
	 
		$control = $wp_customize->get_control( $setting->id );
	 
		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}
}