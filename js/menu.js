/**
 * Rozwijane menu: otwiera się po najechaniu myszką (CSS). Pozycja z własną stroną
 * (np. Gospodarstwo) po kliknięciu prowadzi na nią; pozycja z adresem „#” tylko rozwija podmenu.
 */
jQuery( function ( $ ) {
	var $rodzice = $( '.menu-glowne .menu-item-has-children' );

	$rodzice.children( 'a[href="#"]' ).on( 'click', function ( e ) {
		var $li = $( this ).parent();
		e.preventDefault();
		$rodzice.not( $li ).removeClass( 'otwarte' );
		$li.toggleClass( 'otwarte' );
	} );

	// Formularz „Dodaj aktualność”: pytanie przed usunięciem wpisu.
	$( '.moje-wpisy .usun' ).on( 'click', function ( e ) {
		if ( ! window.confirm( 'Na pewno usunąć aktualność „' + $( this ).data( 'tytul' ) + '”?' ) ) {
			e.preventDefault();
		}
	} );

	// Kliknięcie poza menu zamyka podmenu.
	$( document ).on( 'click', function ( e ) {
		if ( ! $( e.target ).closest( '.menu-glowne' ).length ) {
			$rodzice.removeClass( 'otwarte' );
		}
	} );
} );
