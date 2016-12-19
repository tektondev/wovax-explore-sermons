<?php

class WOVAX_Sermon {
	
	protected $title;
	protected $date;
	protected $image;
	
	
	public function get_title() { return $this->title; }
	public function get_date() { return $this->date; }
	public function get_image(){ return $this->image; }
	public function get_link() { return $this->link; }
	
	
	public function set_title( $title ){ $this->title = $title;}
	public function set_date( $date ) { $this->date = $date; }
	public function set_image( $image ) { $this->image = $image; }
	public function set_link( $link ) { $this->link = $link; }
	
	
	public function get_card(){
		
		ob_start();
		
		include WOVAXESPLUGINPATH . 'inc/inc-sermon-card.php';
		
		return ob_get_clean();
		
	} // end get_card
	
} // end WOVAX_Sermon