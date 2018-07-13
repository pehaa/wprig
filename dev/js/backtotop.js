/**
 * File backtotop.js.
 *
 * Handles site header backtotop on scroll
 */

const BACKTOTOP = document.getElementById( 'pehaarig-to-top' ),
	threshold = 600;

/**
 * Initiate the main navigation script.
 */
function initBackToTop() {

	// No point if no back to top.
	if ( undefined === BACKTOTOP ) {
		return;
	}

	// Toggle the submenu when we click the dropdown button.
	window.addEventListener( 'scroll', function( event ) {
				console.log( window.scrollY );
		if ( window.scrollY > threshold ) {
			BACKTOTOP.classList.add( 'pehaarig-to-top-active' );
		} else {
			BACKTOTOP.classList.remove( 'pehaarig-to-top-active' );
		}
	});
}

initBackToTop();
