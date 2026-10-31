/**
 * Rozwijane menu: na komputerze otwiera się po najechaniu myszką (CSS),
 * a na telefonie po dotknięciu pozycji z podmenu (ten skrypt).
 */
jQuery( function ( $ ) {
	var $rodzice = $( '.menu-glowne .menu-item-has-children' );

	$rodzice.children( 'a' ).on( 'click', function ( e ) {
		var $li = $( this ).parent();

		// Pozycja bez własnej strony (adres „#”) tylko rozwija podmenu.
		if ( $( this ).attr( 'href' ) === '#' || ! $li.hasClass( 'otwarte' ) ) {
			e.preventDefault();
			$rodzice.not( $li ).removeClass( 'otwarte' );
			$li.toggleClass( 'otwarte' );
		}
	} );

	// Kliknięcie poza menu zamyka podmenu.
	$( document ).on( 'click', function ( e ) {
		if ( ! $( e.target ).closest( '.menu-glowne' ).length ) {
			$rodzice.removeClass( 'otwarte' );
		}
	} );
} );
