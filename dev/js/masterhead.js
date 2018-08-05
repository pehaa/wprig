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
}
initMasterhead();

function activateInternalLinks() {

	var scrollTop;

	jQuery( '.main-navigation-menu a[href*=#]' ).on( 'touchstart click', function( e ) {

		var target = this.hash;
		var $target = jQuery( target );

		if ( location.pathname.replace( /^\//, '' ) !== this.pathname.replace( /^\//, '' ) || location.hostname !== this.hostname ) {
			return;
		}

		e.preventDefault();

		scrollTop = Math.round( jQuery( target ).offset().top - 64 );
		jQuery( 'html, body' )
			.stop()
			.animate({
				'scrollTop': scrollTop
				}, 800, 'swing', function(){
					if ( Math.round( jQuery( target ).offset().top - 64 ) !== scrollTop ) {
						jQuery( 'html, body' )
						.stop()
						.animate({
							'scrollTop': jQuery( target ).offset().top - 64
						}, 300 );
					}
				});
	});
}
activateInternalLinks();

var aArray = jQuery.map( jQuery( '#primary-menu li.home-internal-link' ).children( 'a' ), function( element ) {
	const hrefEl = jQuery( element ).attr( 'href' ).split( '#' )[1];
	if ( hrefEl ) {
		return '#' + hrefEl;
	}
});

function scrollHandler( windowPos ) {

	var windowHeight = jQuery( window ).height();
	var docHeight = jQuery( document ).height();

	if ( docHeight - windowPos - windowHeight < 24 ) {
		var lastSectionLi = jQuery( '#primary-menu li.home-internal-link a[href*="' + aArray[aArray.length - 1] + '"]' ).parent();
		if ( ! lastSectionLi.hasClass( 'current-menu-item-inter' ) ) {
			jQuery( '.current-menu-item-inter' ).removeClass( 'current-menu-item-inter' );
			lastSectionLi.addClass( 'current-menu-item-inter' );
		}
	} else {
		for ( var i = 0; i < aArray.length; i++ ) {
			var theID = aArray[i];
			var secPosition = jQuery( theID ).offset().top;
			var currentLi = jQuery( 'a[href*="' + theID + '"]' ).parent();
			secPosition = secPosition - jQuery( '#site-navigation' ).offset().top  + windowPos - 70;
			var divHeight = jQuery( theID ).height();
			console.log( "windowPos", secPosition );
			console.log( "secPosition", secPosition );
			console.log( "secPosition + divHeight", secPosition + divHeight );
			if ( windowPos >= secPosition && windowPos < ( secPosition + divHeight ) ) {
				if ( ! currentLi.hasClass( 'current-menu-item-inter' ) ) {
					jQuery( '.current-menu-item-inter' ).removeClass( 'current-menu-item-inter' );
					currentLi.addClass( 'current-menu-item-inter' );
				}
				break;
			}
		}
	}
}

if ( jQuery( 'body' ).hasClass( 'home' ) ) {
	scrollHandler( 0 );
	var lastKnownScrollPosition = 0;
	var ticking = false;

	window.addEventListener( 'scroll', function() {

		lastKnownScrollPosition = window.scrollY;

		if ( ! ticking ) {

			window.requestAnimationFrame( function() {
				scrollHandler( lastKnownScrollPosition );
				ticking = false;
			});
			ticking = true;
		}
	});
}

function initDonationButtonsEffect() {
	const DONATIONBUTTONS = document.querySelectorAll( '.donation-button' );
	if ( ! DONATIONBUTTONS.length ) {
		return;
	}
	for ( let i = 0; i < DONATIONBUTTONS.length; i++ ) {
		donationButton( DONATIONBUTTONS[i] );
	}
}

function donationButton( el ) {
	const DONATIONSVG = el.querySelector( '.circle' );
	const DONATIONCTNR = el.querySelector( '.circle_pos' );
	let hover = false;

	if ( ! DONATIONSVG || ! DONATIONCTNR ) {
		return;
	}

	el.onmouseleave = function( event ) {
		hover = false;
		setTimeout( function() {

			// don't remove if mouse re-entered
			if ( ! hover ) {
				DONATIONSVG.classList.remove( 'anim_ripple' );
			}
		}, 600 );
	};
	el.onmouseenter = function( event ) {
		hover = true;
		DONATIONSVG.classList.add( 'anim_ripple' );
	};
	el.onmousemove = function( event ) {
	    DONATIONCTNR.setAttribute( 'style',
	      'transform: translateY(' + ( ( event.pageY - window.scrollY - el.getBoundingClientRect().top ) - 100 ) +
	      'px) translateX(' + ( ( event.pageX - el.offsetLeft ) - 100 ) +
	      'px);' );
	};
}

initDonationButtonsEffect();
