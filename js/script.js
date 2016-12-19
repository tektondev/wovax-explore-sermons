var wovax_es = {
	init:function(){
		wovax_es.nav.init();
		wovax_es.filters.init();
		wovax_es.results.init();
	},
	nav:{
		init:function(){
			wovax_es.nav.events();
		},
		events:function(){
			jQuery('body').on(
				'change',
				'.wovax-es-nav input',
				function(){
					wovax_es.results.save_results( jQuery( this ).closest('.wovax-explore-sermons') );
					wovax_es.nav.change( jQuery( this ) );
					wovax_es.filters.change( jQuery( this ).closest('.wovax-explore-sermons'), jQuery( this ).parent().index() );
					wovax_es.results.update_results( jQuery( this ) , true );
				}
			);
		}, // end events
		change:function( ic ){
			ic.closest('li').addClass('es-active').siblings().removeClass('es-active');
		}, // end change
	}, // end nav
	filters:{
		init:function(){
			wovax_es.filters.events();
		},
		events:function(){
			jQuery('body').on(
				'change',
				'.wovax-es-filter input',
				function(){
					wovax_es.filters.close_filters( jQuery( this ).closest('.wovax-es-filter-wrap') );
					wovax_es.filters.apply_filter( jQuery( this ) );
					wovax_es.results.update_results( jQuery( this ) , false );
				}
			);
			jQuery('body').on(
				'click',
				'.wovax-es-filter-wrap-nav a',
				function( e ){
					e.preventDefault();
					if ( jQuery( this ).hasClass('es-closed') ){
						wovax_es.filters.open_filters( jQuery( this ).closest('.wovax-es-filter-wrap-nav').siblings('.wovax-es-filter-wrap') );
					} else {
						wovax_es.filters.close_filters( jQuery( this ).closest('.wovax-es-filter-wrap-nav').siblings('.wovax-es-filter-wrap') );
					}
				}
			);
			jQuery('body').on(
				'click',
				'.wovax-es-filter-wrap-nav i',
				function( e ){
					e.preventDefault();
					wovax_es.filters.remove_filter( jQuery( this ) , jQuery( this ).closest('.wovax-es-applied-filter').data('value') );
					wovax_es.results.update_results( jQuery( this ) , true );
				}
			);
		},
		change:function( wrap , index ){
			wrap.find( '.wovax-es-filters' ).eq( index ).addClass('es-active').siblings().removeClass('es-active'); 
		},
		close_filters:function( wrap ){
			wrap.slideUp('fast');
			wrap.siblings('.wovax-es-filter-wrap-nav').find('a').addClass('es-closed');
		},
		open_filters:function( wrap ){
			wrap.siblings('.wovax-es-filter-wrap-nav').find('a').removeClass('es-closed');
			wrap.slideDown('fast');
		},
		remove_filter:function( ic , value ){
			ic.closest('.wovax-es-applied-filter').removeClass('es-active');
			var wrap = ic.closest('.wovax-es-filter-wrap-nav').siblings('.wovax-es-filter-wrap');
			wrap.find('input[value="' + value + '"]').prop('checked', false);
			wovax_es.filters.open_filters( wrap );
		},
		apply_filter:function( ic ){
			if ( ic.is(':checked') ){
				var label = ic.siblings('label')
				var filter = ic.closest('.wovax-es-filter-wrap').siblings('.wovax-es-filter-wrap-nav').find('.wovax-es-applied-filter');
				filter.addClass('es-active');
				filter.find('span').html( label.text() );
				filter.attr( 'data-value' , ic.val() );
			} // end if
		},
	}, // end filters
	results:{
		results: [false,false,false,false,false],
		init:function(){
			wovax_es.results.events();
		},
		events:function(){
			jQuery('body').on(
				'click',
				'.wovax-es-results footer > a',
				function( e ){
					e.preventDefault();
					wovax_es.results.more( jQuery( this ) );
				}
			);
		},
		update_results:function( ic , use_existing ){
			var data = wovax_es.form.serialize( ic );
			var form = ic.closest( 'form' );
			var index = form.find('.wovax-es-nav li.es-active').index();
			if ( use_existing && wovax_es.results.results[ index ] ){
				wovax_es.results.insert_results( wovax_es.results.results[ index ] , form );
			} // end if
			wovax_es.ajax.get_results( data, ic.closest( 'form' ), wovax_es.results.insert_results );
		},
		insert_results:function( results , wrapper ){
			wrapper.find('.wovax-es-results-set').html( results );
			wovax_es.results.has_more( wrapper );
		},
		append_results:function( results , wrapper ){
			wrapper.find('.wovax-es-results-set').append( results );
			wovax_es.results.has_more( wrapper );
		},
		save_results:function( form ){
			var index = form.find('.wovax-es-nav li.es-active').index();
			var results = form.find('.wovax-es-results-set').html();
			wovax_es.results.results[ index ] = results;
		},
		more:function(ic){
			var data = wovax_es.form.serialize( ic );
			var offset = jQuery('.wovax-es-sermon-card').length;
			data += '&offset=' + offset;
			wovax_es.ajax.get_results( data, ic.closest( 'form' ), wovax_es.results.append_results );
		},
		has_more:function( wrapper ){
			if( wrapper.find('.wovax-es-results-end').length > 0 ) {
				wrapper.find('.es-more').addClass('es-inactive');
			} else {
				wrapper.find('.es-more').removeClass('es-inactive');
			}// end if
		},
	}, // end results
	form:{
		serialize:function( child_item ){
			var form = child_item.closest('form');
			var data = form.find('input').serialize();
			return data;
		}
	}, // end form
	ajax:{
		get_results:function( data, form, callback ){
			var url = es_ajax + '&service=results'; 
			console.log( data );
			jQuery.get(
				url,
				data,
				function( response ){
					console.log( response );
					callback( response , form );
				}
			);
		},
	}, // end ajax
}
wovax_es.init();