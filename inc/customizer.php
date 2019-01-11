<?php
/**
 * Twenty Seventeen: Customizer
 *
 * @package WordPress
 * @subpackage SkyWarp2
 * @since 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function sketchy_customize_register( $wp_customize ) {

	$wp_customize->remove_control( 'header_textcolor' );
    $wp_customize->remove_control( 'display_header_text' );
    $wp_customize->remove_control( 'blogname' );
    $wp_customize->remove_control( 'blogdescription' );
	$wp_customize->remove_section( 'custom_css' ); //删除 Additinal CSS
	$wp_customize->remove_section( 'static_front_page' );

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'sketchy_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'sketchy_customize_partial_blogdescription',
	) );

}
add_action( 'customize_register', 'sketchy_customize_register' );

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function sketchy_customize_preview_js() {
	wp_enqueue_script( 'sketchy-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'sketchy_customize_preview_js' );

