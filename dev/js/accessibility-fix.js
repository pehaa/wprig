/**
 * File masterhead.js.
 *
 * Handles site header behavior on scroll
 */


/**
 * Initiate the main navigation script.
 */
function initAccessFix() {
	let lastKey = new Date();
	let lastClick = new Date();

	// Toggle the submenu when we click the dropdown button.
	window.addEventListener( 'focusin', function( event ) {

		const OUTLINED = document.querySelector( '.pehaarig-keyboard-outline' );
		if ( OUTLINED ) {
			OUTLINED.classList.remove( 'pehaarig-keyboard-outline' );
		}
		if ( lastClick < lastKey ) {
			console.log( event );
			event.target.classList.add( 'pehaarig-keyboard-outline' );
		}
	});
	window.addEventListener( 'mousedown', function() {
		lastClick = new Date();
	});
	window.addEventListener( 'keydown', function() {
		lastKey = new Date();
	});
}

initAccessFix();
