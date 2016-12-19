<?php

class Shortcode_WOVAX_Es_Explore_Sermons extends Shortcode_WOVAX_Es {
	
	protected $slug = 'explore_sermons';
	protected $default_atts = array(
		'show_popular' => 0,
	);
	
	
	public function the_shortcode( $atts, $content, $tag ){
		
		$active_section = ( $_GET['browse-by'] ) ? sanitize_text_field( $_GET['browse-by'] ) : 'all';
		
		$html = '';
		
		if ( $atts['show_popular'] ) {
			
			
			
		} else {
			
			$html .= $this->get_explore_nav( $active_section );
			$html .= $this->get_filters( $active_section );
			$html .= $this->get_results( $active_section );
			
		} // end if
		
		$html .= $this->get_css();
		$html .= $this->get_js();
		
		//$html .= $this->get_js();
		
		return '<form class="wovax-explore-sermons">' . $html . '</form>';
		
	} // end the_shortcode
	
	
	protected function get_explore_nav( $active_section ){
		
		ob_start();
		
		include WOVAXESPLUGINPATH . 'inc/inc-explore-bar.php';
		
		return ob_get_clean();
		
	} // end get_explore_nav
	
	
	public function get_filters( $active_section ){
		
		require_once WOVAXESPLUGINPATH . 'classes/class-wovax-sermon-filters.php';
		
		$sermon_filters = new WOVAX_Sermon_Filters();
		
		$html = $sermon_filters->get_filters( 'all' );
		$html .= $sermon_filters->get_filters( 'scripture' );
		$html .= $sermon_filters->get_filters( 'topic' );
		$html .= $sermon_filters->get_filters( 'series' );
		$html .= $sermon_filters->get_filters( 'pastor' );
		
		return $html;
		
	} // end get_filters


	public function get_results( $active_section ){
		
		require_once WOVAXESPLUGINPATH . 'classes/class-wovax-sermon-factory.php';
		
		$sermon_factory = new WOVAX_Sermon_Factory();
		
		$sermons = $sermon_factory->get_sermons(); 
		
		$results = '';
		
		foreach( $sermons as $sermon ){
			
			$results .= $sermon->get_card();
			
		} // end foreach
		
		ob_start();
		
		include WOVAXESPLUGINPATH . 'inc/inc-results.php';
		
		$html = ob_get_clean();
		
		return $html;
		
	} // end get_sections
	
	
	public function get_css(){
		
		ob_start();
		
		include WOVAXESPLUGINPATH . 'css/style.css';
		
		$css = ob_get_clean();
		
		return '<style>' . $css . '</style>';
		
	}
	
	
	public function get_js(){
		
		ob_start();
		
		include WOVAXESPLUGINPATH . 'js/script.js';
		
		$script = ob_get_clean();
		
		return '<script>var es_ajax = "' . rtrim( get_bloginfo('url') , '/' ) . '?es_ajax=true";' . $script . '</script>';
		
	}
	
	
	public function check_active( $value , $check_value ){
		
		if ( $value == $check_value ){
			
			return 'es-active';
			
		} else {
			
			return '';
			
		} // end if
		
	} // end check_active
	
	
} // end Shortcode_WOVAX_Es_Explore_Sermons