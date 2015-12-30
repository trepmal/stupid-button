(function($){

	var wp = window.wp;

	var stupidButtonIncrement = function( event ) {
		event.preventDefault();

		wp.ajax.send( 'stupid-button-increment', {
			data: {
			},
			success: stupidButtonSuccess,
			error: stupidButtonError
		} );
	}

	var stupidButtonReset = function( event ) {
		event.preventDefault();

		wp.ajax.send( 'stupid-button-reset', {
			data: {
			},
			success: stupidButtonSuccess,
			error: stupidButtonError
		} );
	}

	var stupidButtonSuccess = function( response ) {
		$( document.getElementById( 'stupid-button-status' ) ).html( response );
	}
	var stupidButtonError = function( response ) {
		alert( stupidButton.unknownError )
	}


	$( document.getElementById( 'stupid-button-increment' ) ).on( 'click', stupidButtonIncrement );
	$( document.getElementById( 'stupid-button-reset' ) ).on( 'click', stupidButtonReset );

})( jQuery );