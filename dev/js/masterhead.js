/**
 * File masterhead.js.
 *
 * Handles site header behavior on scroll
 */

const MASTHEAD = document.getElementById( 'masthead' ),
	threshold0 = 180,
	threshold1 = 300;

/**
 * Initiate the main navigation script.
 */
function initMasterhead() {

	// No point if no site nav.
	if ( undefined === MASTHEAD ) {
		return;
	}

	// Get the submenus.
	const NAV = document.getElementById( 'site-navigation' );

	// Toggle the submenu when we click the dropdown button.
	window.addEventListener( 'scroll', function( event ) {
		console.log( window.scrollY );
		if ( window.scrollY > threshold0 ) {
			MASTHEAD.classList.add( 'masthead-pre-fixed' );
		} else {
			MASTHEAD.classList.remove( 'masthead-pre-fixed' );
		}
		if ( window.scrollY > threshold1 ) {
			MASTHEAD.classList.add( 'masthead-fixed' );
		} else {
			MASTHEAD.classList.remove( 'masthead-fixed' );
		}
	});
}

initMasterhead();
