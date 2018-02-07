jQuery( function( $ ) {

	$( document ).on( 'click', '.ac-notice [data-dismiss], .ac-notice button.notice-dismiss', function() {
		let $notice = $( this ).parents( '.ac-notice' );
		let name = $notice.data( 'name' );

		if ( !name ) {
			return false;
		}

		setTimeout( function() {
			"use strict";
			$notice.fadeOut().remove();
		}, 3000 );

		$.get( ajaxurl, {
			action : 'ac_notices',
			name : name,
			_ajax_nonce : $notice.data( 'nonce' )
		}, function() {
			$notice.fadeOut().remove();
		} );

	} );

} );
