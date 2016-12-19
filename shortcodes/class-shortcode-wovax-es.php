<?php

abstract class Shortcode_WOVAX_Es {
	
	
	protected $slug;
	protected $default_atts = array();
	
	
	public function register(){
		
		add_shortcode( $this->slug, array( $this , 'do_shortcode' ) );
		
	} // end register
	
	
	public function do_shortcode( $atts, $content, $tag ){
		
		$a = shortcode_atts( $this->default_atts , $atts );
		
		return $this->the_shortcode( $a , $content, $tag );
		
	} // end do_shortcode
	
	
	
} // end Shortcode_WOVAX_Es