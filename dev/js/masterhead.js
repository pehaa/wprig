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
		if ( document.documentElement.scrollTop > threshold0 ) {
			MASTHEAD.classList.add( 'masthead-pre-fixed' );
		} else {
			MASTHEAD.classList.remove( 'masthead-pre-fixed' );
		}
		if ( document.documentElement.scrollTop > threshold1 ) {
			MASTHEAD.classList.add( 'masthead-fixed' );
		} else {
			MASTHEAD.classList.remove( 'masthead-fixed' );
		}
	});
}
initMasterhead();

function activateInternalLinks() {

	var scrollTop;
	const MENUTOGGLE = jQuery( '.menu-toggle' );
	const SITENAV = jQuery( '#site-navigation' );

	jQuery( '.main-navigation-menu a[href*=#]' ).on( 'click', function( e ) {

		var target = this.hash;
		var $target = jQuery( target );
		var verticalGap = 64;

		if ( location.pathname.replace( /^\//, '' ) !== this.pathname.replace( /^\//, '' ) || location.hostname !== this.hostname ) {
			return;
		}

		e.preventDefault();

		if ( SITENAV.hasClass( 'toggled-on') ) {
			MENUTOGGLE.trigger( 'click' );
			verticalGap = 0;
		}

		scrollTop = Math.round( jQuery( target ).offset().top - verticalGap );
		jQuery( 'html, body' )
			.stop()
			.animate({
				'scrollTop': scrollTop
				}, 800, 'swing', function(){
					if ( Math.round( jQuery( target ).offset().top - verticalGap ) !== scrollTop ) {
						jQuery( 'html, body' )
						.stop()
						.animate({
							'scrollTop': jQuery( target ).offset().top - verticalGap
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

		lastKnownScrollPosition = document.documentElement.scrollTop;

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
				DONATIONCTNR.classList.remove( 'anim_ripple' );
			}
		}, 600 );
	};
	el.onmouseenter = function( event ) {
		hover = true;
		DONATIONCTNR.classList.add( 'anim_ripple' );
	};
	el.onmousemove = function( event ) {
	    DONATIONCTNR.setAttribute( 'style',
	      'transform: translateY(' + ( ( event.pageY - document.documentElement.scrollTop - el.getBoundingClientRect().top ) - 100 ) +
	      'px) translateX(' + ( ( event.pageX - el.getBoundingClientRect().left ) - 100 ) +
	      'px);' );
	};
}

initDonationButtonsEffect();

function initShareButton() {
	const SHAREBUTTONS = document.querySelectorAll( '.pehaarig-trigger-share' );
	if ( !SHAREBUTTONS.length ) {
		return;
	}
	for ( let i = 0; i < SHAREBUTTONS.length; i++ ) {
		shareButton( SHAREBUTTONS[i] );
	}
}

function shareButton( el ) {
	el.onclick = function() {
		el.parentNode.parentNode.classList.toggle( 'share-toggled-in' );
	}
}

initShareButton();
