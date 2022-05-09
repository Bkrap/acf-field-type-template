<?php

/*
Plugin Name: Advanced Custom Fields: FIELD_LABEL
Plugin URI: PLUGIN_URL
Description: SHORT_DESCRIPTION
Version: 1.0.0
Author: AUTHOR_NAME
Author URI: AUTHOR_URL
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

define( 'ROOT_PATH', plugin_dir_url( __FILE__ ) );

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if( !class_exists('NAMESPACE_acf_plugin_FIELD_NAME') ) :

class NAMESPACE_acf_plugin_FIELD_NAME {
	
	// vars
	var $settings;
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	void
	*  @return	voidd
	*/
	
	function __construct() {
		
		// settings
		// - these will be passed into the field class.
		$this->settings = array(
			'version'	=> '1.0.0',
			'url'		=> plugin_dir_url( __FILE__ ),
			'path'		=> plugin_dir_path( __FILE__ )
		);
		
		
		// include field
		add_action('acf/include_field_types', 	array($this, 'include_field')); // v5
		add_action('acf/register_fields', 		array($this, 'include_field')); // v4

		function q_front_theme_enqueue_styles() {
			$the_theme = wp_get_theme();
	
			wp_enqueue_style( 'custom-theme-styles', plugin_dir_url(__FILE__) . '/assets/css/front.css', array(), $the_theme->get( 'Version' ) );
			wp_enqueue_style('bootstrap5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
			
			wp_enqueue_script( 'jquery' );
	
			wp_enqueue_script( 'custom-theme-scripts__video-play-dynamic', plugin_dir_url(__FILE__) . '/assets/js/video-play-dynamic.js', array(), $the_theme->get( 'Version' ) );
			wp_enqueue_script( 'custom-theme-scripts', plugin_dir_url(__FILE__) . '/assets/js/front.js', array(), $the_theme->get( 'Version' ) );
			wp_enqueue_script( 'bootstrapbundle','https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array( 'jquery' ),'',true );
			wp_enqueue_script( 'popper','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ),'',true );
		}
		
		add_action( 'wp_enqueue_scripts', 'q_front_theme_enqueue_styles' );
		
	}
	
	
	/*
	*  include_field
	*
	*  This function will include the field type class
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	$version (int) major ACF version. Defaults to false
	*  @return	void
	*/
	
	function include_field( $version = false ) {
		
		// support empty $version
		if( !$version ) $version = 4;
		
		
		// load textdomain
		load_plugin_textdomain( 'TEXTDOMAIN', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' ); 
		
		
		// include
		include_once('fields/class-NAMESPACE-acf-field-FIELD-NAME-v' . $version . '.php');

		echo "";
	}
	
}


// initialize
new NAMESPACE_acf_plugin_FIELD_NAME();


// class_exists check
endif;
	


?>