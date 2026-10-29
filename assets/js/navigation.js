/**
 * Mobile navigation toggle. Vanilla JS, no dependencies.
 */
( function () {
	'use strict';

	var toggle = document.querySelector( '.nav-toggle' );
	var nav = document.getElementById( 'primary-nav' );

	if ( ! toggle || ! nav ) {
		return;
	}

	function setOpen( isOpen ) {
		nav.classList.toggle( 'is-open', isOpen );
		toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
	}

	toggle.addEventListener( 'click', function () {
		setOpen( toggle.getAttribute( 'aria-expanded' ) !== 'true' );
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Escape' === event.key && toggle.getAttribute( 'aria-expanded' ) === 'true' ) {
			setOpen( false );
			toggle.focus();
		}
	} );
}() );
