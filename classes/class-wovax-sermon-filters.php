<?php

class WOVAX_Sermon_Filters {
	
	
	public function get_filters( $set_type , $wrap = true , $active_id = false ){
		
		switch( $set_type ){
			
			case 'all':
				$html .= $this->get_all_filters();
				break;
			case 'scripture':
				$html .= $this->get_scripture_filters();
				break;
			case 'topic':
				$html .= $this->get_topic_filters();
				break;
			case 'series':
				$html .= $this->get_series_filters();
				break;
			case 'pastor':
				$html .= $this->get_pastor_filters();
				break;
			
		} // end switch
		
		if ( $wrap ){
			
			$html = $this->wrap_filters( $html, $set_type, $active_id );
			
		} // end if
		
		return $html;
		
	} // end get_filters
	
	
	public function get_all_filters(){
	} // end get_all_filters
	
	
	public function get_scripture_filters(){
		
		$filters = $this->get_filter_set_scripture();
		
		$old = $this->get_filter_set_scripture( 'old' );
		$new = $this->get_filter_set_scripture( 'new' );
		
		$old_filters = $this->make_filters( $old, 'es_scripture' );
		$new_filters = $this->make_filters( $new, 'es_scripture' );
		
		$html_old = $this->to_columns( $old_filters, 4 );
		$html_new = $this->to_columns( $new_filters, 4 );
		
		ob_start();
		
		include WOVAXESPLUGINPATH . 'inc/inc-filters-scripture.php';
		
		$html = ob_get_clean();
		
		$html = $this->wrap_filter_set( $html , 'Scriptures' );
		
		return $html;
		
	} // end 
	
	
	public function get_topic_filters(){
		
		$terms  = get_terms( 'topic', array( 'hide_empty' => false, ) );
		
		$filters = $this->get_taxonomy_filters( $terms );
		
		$filter_html = $this->make_filters( $filters, 'es_topic' );
		
		$html = $this->to_columns( $filter_html, 6 );
		
		$html = $this->wrap_filter_set( $html , 'Topics' );
		
		return $html;
		
	} // end 
	
	
	public function get_series_filters(){
		
		$terms  = get_terms( 'series', array( 'hide_empty' => false, ) );
		
		$filters = $this->get_taxonomy_filters( $terms );
		
		$filter_html = $this->make_filters( $filters, 'es_series' );
		
		$html = $this->to_columns( $filter_html, 6 );
		
		$html = $this->wrap_filter_set( $html , 'Series' );
		
		return $html;
		
	} // end
	 
	
	public function get_pastor_filters(){
		
		$terms  = get_terms( 'pastor', array( 'hide_empty' => false, ) );
		
		$filters = $this->get_taxonomy_filters( $terms );
		
		$filter_html = $this->make_filters( $filters, 'es_pastors' );
		
		$html = $this->to_columns( $filter_html, 6 );
		
		$html = $this->wrap_filter_set( $html , 'Pastors' );
		
		return $html;
		
	} // end
	
	
	public function wrap_filters( $filters, $set_id, $active_id = false  ){
		
		if ( ! $active_id ) $active_id = 'all';
		
		$active_class = ( $set_id == $active_id ) ? 'es-active ' : '';
		
		ob_start();
		
		include WOVAXESPLUGINPATH . 'inc/inc-filters.php';
		
		return ob_get_clean();
		
	} // end
	
	public function wrap_filter_set( $filters, $title, $selected = false ){
		
		ob_start();
		
		include WOVAXESPLUGINPATH . 'inc/inc-filters-wrap.php';
		
		return ob_get_clean();
		
	} // end
	
	
	protected function make_filters( $filter_array , $name ){
		
		$filters = array();
		
		foreach( $filter_array as $value => $filter ){
			
			$id = uniqid( 'filter_' );
			
			$html = '<label for="' . $id . '">'  . $filter['label'] . '</label>';
			
			$html .= '<input id="' . $id . '" type="radio" name="' . $name . '" value="' . $value . '" />';
			
			$filters[] = $html;
			
		} // end foreach
		
		return $filters;
		
	} // end make_filters
	
	
	public function to_columns( $filters , $columns , $to_html = true ){
		
		$size = ( count( $filters ) / $columns ) + 1;
		
		$filter_sets = array_chunk( $filters , $size );
		
		if ( ! $to_html ){
			
			return $filter_sets;
			
		} else {
			
			$html = '';
		
			foreach( $filter_sets as $index => $filter_set ){
				
				$html .= '<ul class="wovax-es-column-set-' . $columns . ' wovax-es-column  wovax-es-column-' . $index . '">';
				
				foreach( $filter_set as $filter ){
					
					$html .= '<li class="wovax-es-filter">' . $filter . '</li>';
					
				} // end foreach
				
				$html .= '</ul>';
				
			} // end foreach
			
			return $html;
		
		} // end if
		
	} // end to_columns
	
	
	protected function get_taxonomy_filters( $terms ){
		
		$filters = array();
		
		foreach( $terms as $term ){
			
			$filters[ $term->slug ] = array(
				'label' => $term->name,
				);
			
		} // end foreach
		
		return $filters;
		
	} // end get_taxonomy_filters
	
	
	public function get_filter_set_scripture( $set = false ){
		
		$books = array(
			'genesis' 			=> array( 'label' => 'Genesis', 'set' => 'old' ),
			'exodus' 			=> array( 'label' => 'Exodus', 'set' => 'old' ),
			'leviticus' 		=> array( 'label' => 'Leviticus', 'set' => 'old' ),
			'numbers' 			=> array( 'label' => 'Numbers', 'set' => 'old' ),
			'deuteronomy' 		=> array( 'label' => 'Deuteronomy', 'set' => 'old' ),
			'joshua' 			=> array( 'label' => 'Joshua', 'set' => 'old' ),
			'judges' 			=> array( 'label' => 'Judges', 'set' => 'old' ),
			'ruth' 				=> array( 'label' => 'Ruth', 'set' => 'old' ),
			'1-samuel' 			=> array( 'label' => '1 Samuel', 'set' => 'old' ),
			'2-samuel' 			=> array( 'label' => '2 Samuel', 'set' => 'old' ),
			'1-kings' 			=> array( 'label' => '1 Kings', 'set' => 'old' ),
			'2-kings' 			=> array( 'label' => '2 Kings', 'set' => 'old' ),
			'1-chronicles' 		=> array( 'label' => '1 Chronicles', 'set' => 'old' ),
			'2-chronicles' 		=> array( 'label' => '2 Chronicles', 'set' => 'old' ),
			'ezra' 				=> array( 'label' => 'Ezra', 'set' => 'old' ),
			'nehemiah' 			=> array( 'label' => 'Nehemiah', 'set' => 'old' ),
			'ester' 			=> array( 'label' => 'Esther', 'set' => 'old' ),
			'job' 				=> array( 'label' => 'Job', 'set' => 'old' ),
			'psalms' 			=> array( 'label' => 'Psalms', 'set' => 'old' ),
			'proverbs' 			=> array( 'label' => 'Proverbs', 'set' => 'old' ),
			'ecclesiastes' 		=> array( 'label' => 'Ecclesiastes', 'set' => 'old' ),
			'song-of-solomon' 	=> array( 'label' => 'Song of Solomon', 'set' => 'old' ),
			'isaiah' 			=> array( 'label' => 'Isaiah', 'set' => 'old' ),
			'jeremiah' 			=> array( 'label' => 'Jeremiah', 'set' => 'old' ),
			'lamentations' 		=> array( 'label' => 'Lamentations', 'set' => 'old' ),
			'ezekiel' 			=> array( 'label' => 'Ezekiel', 'set' => 'old' ),
			'daniel' 			=> array( 'label' => 'Daniel', 'set' => 'old' ),
			'hosea' 			=> array( 'label' => 'Hosea', 'set' => 'old' ),
			'joel' 				=> array( 'label' => 'Joel', 'set' => 'old' ),
			'amos' 				=> array( 'label' => 'Amos', 'set' => 'old' ),
			'obadiah' 			=> array( 'label' => 'Obadiah', 'set' => 'old' ),
			'jonah' 			=> array( 'label' => 'Jonah', 'set' => 'old' ),
			'micah' 			=> array( 'label' => 'Micah', 'set' => 'old' ),
			'nahum' 			=> array( 'label' => 'Nahum', 'set' => 'old' ),
			'habakkuk' 			=> array( 'label' => 'Habakkuk', 'set' => 'old' ),
			'zephaniah' 		=> array( 'label' => 'Zephaniah', 'set' => 'old' ),
			'haggai' 			=> array( 'label' => 'Haggai', 'set' => 'old' ),
			'zechariah' 		=> array( 'label' => 'Zechariah', 'set' => 'old' ),
			'malachi' 			=> array( 'label' => 'Malachi', 'set' => 'old' ),
			'matthew' 			=> array( 'label' => 'Matthew', 'set' => 'new' ),
			'mark' 				=> array( 'label' => 'Mark', 'set' => 'new' ),
			'luke' 				=> array( 'label' => 'Luke', 'set' => 'new' ),
			'john' 				=> array( 'label' => 'John', 'set' => 'new' ),
			'acts' 				=> array( 'label' => 'Acts (of the Apostles)', 'set' => 'new' ),
			'romans' 			=> array( 'label' => 'Romans', 'set' => 'new' ),
			'1-corinthians' 	=> array( 'label' => '1 Corinthians', 'set' => 'new' ),
			'2-corinthians' 	=> array( 'label' => '2 Corinthians', 'set' => 'new' ),
			'galations' 		=> array( 'label' => 'Galatians', 'set' => 'new' ),
			'ephesians' 		=> array( 'label' => 'Ephesians', 'set' => 'new' ),
			'philippians' 		=> array( 'label' => 'Philippians', 'set' => 'new' ),
			'colossians' 		=> array( 'label' => 'Colossians', 'set' => 'new' ),
			'1-thessalonians' 	=> array( 'label' => '1 Thessalonians', 'set' => 'new' ),
			'2-thessalonians' 	=> array( 'label' => '2 Thessalonians', 'set' => 'new' ),
			'1-timothy' 		=> array( 'label' => '1 Timothy', 'set' => 'new' ),
			'2-timothy' 		=> array( 'label' => '2 Timothy', 'set' => 'new' ),
			'titus' 			=> array( 'label' => 'Titus', 'set' => 'new' ),
			'philemon' 			=> array( 'label' => 'Philemon', 'set' => 'new' ),
			'hebrews' 			=> array( 'label' => 'Hebrews', 'set' => 'new' ),
			'james' 			=> array( 'label' => 'James', 'set' => 'new' ),
			'1-peter' 			=> array( 'label' => '1 Peter', 'set' => 'new' ),
			'2-peter' 			=> array( 'label' => '2 Peter', 'set' => 'new' ),
			'1-john' 			=> array( 'label' => '1 John', 'set' => 'new' ),
			'2-john' 			=> array( 'label' => '2 John', 'set' => 'new' ),
			'3-john' 			=> array( 'label' => '3 John', 'set' => 'new' ),
			'jude' 				=> array( 'label' => 'Jude', 'set' => 'new' ),
			'revelation' 		=> array( 'label' => 'Revelation', 'set' => 'new' ),
		);
		
		if ( $set ){
			
			foreach( $books as $key => $info ){
				
				if ( $info['set'] != $set ) unset( $books[ $key ] );
				
			} // end foreach
			
		} // end if
		
		return $books;
		
	} // end 
	
}