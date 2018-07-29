/**
 * File masterhead.js.
 *
 * Handles site header behavior on scroll
 */

const MASTHEAD = document.getElementById( 'masthead' ),
	threshold0 = 180,
	threshold1 = 300,
	SCROLLABLELINK = document.querySelectorAll( '.main-navigation-menu a' );

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

	window.addEventListener( 'scroll', function( event ) {
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


	
function activateInternalLinks () {

	var scrollTop;

	jQuery( '.main-navigation-menu a[href*=#]' ).on( "touchstart click" , function( e ) {
		
		var target = this.hash;

		if ( location.pathname.replace(/^\//,'') !== this.pathname.replace(/^\//,'') || location.hostname !== this.hostname ) {
			return;
		}
		
		e.preventDefault();

		var $target = jQuery( target );

		scrollTop = jQuery( target ).offset().top - 64;
		

		jQuery( 'html, body' )
			.stop()
			.animate( {
				'scrollTop': scrollTop
				}, 800, 'swing' );
			
	});

}
activateInternalLinks();

var aArray = jQuery.map( jQuery( "#primary-menu li.home-internal-link").children( "a" ), function( element ) {
	const hrefEl = jQuery( element ).attr( 'href' ).split( "#" )[1];
	if ( hrefEl ) {
		return "#" + hrefEl;
	}
});

function scrollHandler() {
	var windowPos = jQuery( window ).scrollTop();
	var windowHeight = jQuery( window ).height();
	var docHeight = jQuery( document ).height();

	if ( docHeight - windowPos - windowHeight < 24 ) {
		jQuery( "#primary-menu li.home-internal-link a[href*='" + aArray[aArray.length - 1] + "']" ).parent().addClass( "current-menu-item-inter" );
	} else {
		for ( var i = 0; i < aArray.length; i++ ) {
			var theID = aArray[i];
			var secPosition = jQuery( theID ).offset().top;

			secPosition = secPosition - jQuery( "#site-navigation" ).offset().top  + windowPos - 70;
			var divHeight = jQuery( theID ).height();
			jQuery( ".current-menu-item-inter" ).removeClass( "current-menu-item-inter" );
			if ( windowPos >= secPosition && windowPos < ( secPosition + divHeight ) ) {
				jQuery( "a[href*='" + theID + "']" ).parent().addClass( "current-menu-item-inter" );
				break;
			}
		}	
	}
}

if ( jQuery( "body" ).hasClass( "home" ) ) {
	scrollHandler();
	jQuery( window ).scroll( scrollHandler );
}

	

	

