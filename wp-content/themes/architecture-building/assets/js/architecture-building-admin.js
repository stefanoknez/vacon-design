( function ( $ ) {
	'use strict';

	// Handle notice dismiss button click
	$( document ).on( 'click', '.notice-info .notice-dismiss', function () {
		var type = $( this ).closest( '.notice-info' ).data( 'notice' );
		if ( ! type ) {
			return;
		}
		$.ajax( {
			type: 'POST',
			url: architecture_building_localize.ajax_url,
			data: {
				action: 'architecture_building_dismissed_notice_handler',
				type: type,
				wpnonce: architecture_building_localize.dismiss_nonce
			}
		} );
	} );

} )( jQuery );