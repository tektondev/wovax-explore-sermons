<?php
/*
Plugin Name: Wovax Explore Sermons
Plugin URI: https://www.wovax.com/
Description: This is the Wovax plugin for browsing sermons.
Version: 0.0.1
Author: Wovax, Danial Bleile.
Author URI: https://www.wovax.com/
*/


class WOVAX_Explore_Sermons {
	
	// @var string Version
	public static $version = '0.0.1';
	
	// @var object|null Instance WOVAX_Explore_Sermons
	public static $instance;
	

	/**
	 * Get the current instance or set it and return
	 * @return object current instance of WOVAX_Explore_Sermons
	 */
	 public static function get_instance(){
		 
		 if ( null == self::$instance ) {
			 
            self::$instance = new self;
			self::$instance->init();
			
        } // end if
 
        return self::$instance;
		 
	 } // end get_instance
	 
	 
	 /**
	  * Method called when plugin is initialized for hooks & filters
	  */
	 public function init(){
		 
		 define( 'WOVAXESPLUGINPATH', plugin_dir_path( __FILE__ ) );
		 define( 'WOVAXESPLUGINURL', plugin_dir_url( __FILE__ ) );
		 
		 add_action( 'wp_enqueue_scripts' , array( $this , 'wp_enqueue_scripts' ), 99 );
		 
		 require_once 'shortcodes/class-shortcode-wovax-es.php';
		 require_once 'shortcodes/class-shortcode-wovax-es-explore-sermons.php';
		 
		 $explore_sermons = new Shortcode_WOVAX_Es_Explore_Sermons();
		 $explore_sermons->register();
		 
		 require_once 'classes/class-wovax-es-ajax.php';
		 $ajax = new WOVAX_ES_Ajax();
		 $ajax->add_actions();
		 
	 } // end init
	 
	 
	 public function wp_enqueue_scripts(){
		 
		 wp_enqueue_style( 'fontAwesome' , WOVAXESPLUGINURL . 'font-awesome/css/font-awesome.min.css' , array(), WOVAX_Explore_Sermons::$version );
		 
	 } // end wp_enqueue_scripts
	  
	
} // end WOVAX_Explore_Sermons

$wovax_explore_sermons = WOVAX_Explore_Sermons::get_instance();