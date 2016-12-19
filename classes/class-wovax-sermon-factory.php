<?php

require_once 'class-wovax-sermon.php';

class WOVAX_Sermon_Factory {
	
	
	protected $query_args = array(
		'post_type' 		=> 'sermon',
		'status' 			=> 'publish',
		'posts_per_page' 	=> 12,
	);
	
	
	public function get_sermon(){
		
		$sermon = new WOVAX_Sermon();
		
		return $sermon;
		
	} // end get_sermon
	
	
	public function get_sermons( $query_args = array() ){
		
		if ( empty( $query_args ) ) $query_args = $this->query_args;
		
		$sermons = array();
		
		$wp_query = new WP_Query( $query_args );
		
		if ( $wp_query->have_posts() ) {
			
			while ( $wp_query->have_posts() ) {
				
				$wp_query->the_post();
				
				$sermon = $this->get_sermon();
				
				$sermon->set_title( get_the_title() );
				$sermon->set_date( get_the_date() );
				$sermon->set_link( get_permalink() );
				
				if ( has_post_thumbnail() ){
					
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
					
					$sermon->set_image( $image[0] );
					
				} else {
					
					$sermon->set_image( WOVAXESPLUGINURL . 'images/sermon-placeholder.png' );
					
				} // end if
				
				$sermons[] = $sermon;
				
			} // end while
			
		} // end if
		
		return $sermons;
		
	} // end get_sermons
	
	
	public function get_sermons_from_form(){
		
		$add_query = array();
		
		$term = '';
		$taxonomy = '';
		
		if ( ! empty( $_GET['browse_by'] ) ){
			
			switch( $_GET['browse_by'] ){
				
				case 'scriptures':
					$term = ( ! empty( $_GET['es_scripture'] ) )? sanitize_text_field( $_GET['es_scripture'] ) : '';
					$taxonomy = 'scripture';
					break;
				case 'topics':
					$term = ( ! empty( $_GET['es_topic'] ) )? sanitize_text_field( $_GET['es_topic'] ) : '';
					$taxonomy = 'topic';
					break;
				case 'series':
					$term = ( ! empty( $_GET['es_series'] ) )? sanitize_text_field( $_GET['es_series'] ) : '';
					$taxonomy = 'series';
					break;
				case 'pastors':
					$term = ( ! empty( $_GET['es_pastors'] ) )? sanitize_text_field( $_GET['es_pastors'] ) : '';
					$taxonomy = 'pastor';
					break;
				
			} // end switch
			
		} // end if
		
		if ( ! empty( $term ) && ! empty( $taxonomy ) ){
			
			$tax_query = array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $term,
			);
			
			$add_query['tax_query'] = array( $tax_query );
			
		} // end if
		
		$general_args = $this->get_form_query_args();
		
		$query_args = array_merge( $general_args , $add_query );
		
		$sermons = $this->get_sermons( $query_args );
		
		return $sermons;
		
	}  // end get_sermons_from_form
	
	protected function get_form_query_args(){
		
		$query_args = $this->query_args;
		
		if ( ! empty( $_GET['offset'] ) ) $query_args['offset'] = sanitize_text_field( $_GET['offset'] );
		
		return $query_args;
		
	}
	
}