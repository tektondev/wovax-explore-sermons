<?php

class WOVAX_ES_Ajax {
	
	public function add_actions(){
		
		if ( ! empty( $_GET['es_ajax'] ) ){
			
			add_filter( 'template_include', array( $this , 'filter_template_include' ), 9999 );
			
		} // end if
		
	} // end add_actions
	
	
	public function filter_template_include( $template ){
		
		$template = WOVAXESPLUGINPATH . 'ajax.php';
		
		return $template;
		
	} // end filter_template_include
	
	
	public function do_request(){
		
		if ( ! empty( $_GET['service'] ) ){
			
			switch( $_GET['service'] ){
				
				case 'results':
					$this->do_results_request();
					break;
				
			} // end switch
			
		} // end if
		
	} // end do_request
	
	
	protected function do_results_request(){
		
		require_once WOVAXESPLUGINPATH . 'classes/class-wovax-sermon-factory.php';
		
		$sermon_factory = new WOVAX_Sermon_Factory();
		
		$sermons = $sermon_factory->get_sermons_from_form();
		
		foreach( $sermons as $sermon ){
			
			echo $sermon->get_card();
			
		} // end foreach
		
		if ( count( $sermons ) < 12 ){
			
			echo '<div class="wovax-es-results-end"></div>';
			
		} // end if
		
	} // end do_results_request
	
}