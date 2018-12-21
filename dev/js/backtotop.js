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
	// Show/hide scroll to top button depending on the scroll position.
	window.addEventListener( 'scroll', function( event ) {
		if ( Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) > threshold ) {
			BACKTOTOP.classList.add( 'pehaarig-to-top-active' );
		} else {
			BACKTOTOP.classList.remove( 'pehaarig-to-top-active' );
		}
	});
}

initBackToTop();

let intervalId = 0; // Needed to cancel the scrolling when we're at the top of the page

function scrollStep() {
	// Check if we're at the top already. If so, stop scrolling by clearing the interval
	if ( window.pageYOffset === 0 ) {
		clearInterval( intervalId );
	}
	window.scroll( 0, window.pageYOffset - 50 );
}

function scrollToTop( e ) {
	e.preventDefault();
	// Call the function scrollStep() every 16.66 millisecons
	intervalId = setInterval( scrollStep, 16.66 );
}

// When the DOM is loaded, this click handler is added to our scroll button
BACKTOTOP.addEventListener( 'click', scrollToTop );
