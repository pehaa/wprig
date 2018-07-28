<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wprig
 */

/**
 * Determine whether this is an AMP response.
 *
 * Note that this must only be called after the parse_query action.
 *
 * @link https://github.com/Automattic/amp-wp
 * @return bool Is AMP endpoint (and AMP plugin is active).
 */
function wprig_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

/**
 * Determine whether amp-live-list should be used for the comment list.
 *
 * @return bool Whether to use amp-live-list.
 */
function wprig_using_amp_live_list_comments() {
	if ( ! wprig_is_amp() ) {
		return false;
	}
	$amp_theme_support = get_theme_support( 'amp' );
	return ! empty( $amp_theme_support[0]['comments_live_list'] );
}

/**
 * Add pagination reference point attribute for amp-live-list when theme supports AMP.
 *
 * This is used by the navigation_markup_template filter in the comments template.
 *
 * @link https://www.ampproject.org/docs/reference/components/amp-live-list#pagination
 *
 * @param string $markup Navigation markup.
 * @return string Markup.
 */
function wprig_add_amp_live_list_pagination_attribute( $markup ) {
	return preg_replace( '/(\s*<[a-z0-9_-]+)/i', '$1 pagination ', $markup, 1 );
}

/**
 * Prints the header of the current displayed page based on its contents.
 */
function wprig_index_header() {
	if ( is_home() && ! is_front_page() ) {
		?>
		<header>
			<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
		</header>
		<?php
	} elseif ( is_search() ) {
		?>
		<header class="page-header">
			<h1 class="page-title">
			<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'wprig' ), '<span>' . get_search_query() . '</span>' );
			?>
			</h1>
		</header><!-- .page-header -->
		<?php
	} elseif ( is_archive() ) {
		?>
		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->
		<?php
	}
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
function wprig_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date. */
		esc_html_x( 'Posted on %s', 'post date', 'wprig' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . ' </span>'; // WPCS: XSS OK.

}

/**
 * Prints HTML with meta information for the current author.
 */
function wprig_posted_by() {
	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( 'by %s', 'post author', 'wprig' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . ' </span>'; // WPCS: XSS OK.
}

/**
 * Prints a link list of the current categories for the post.
 *
 * If additional post types should display categories, add them to the conditional statement at the top.
 */
function wprig_post_categories() {
	// Only show categories on post types that have categories.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'wprig' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'wprig' ) . ' </span>', $categories_list ); // WPCS: XSS OK.
		}
	}
}

/**
 * Prints a link list of the current tags for the post.
 *
 * If additional post types should display tags, add them to the conditional statement at the top.
 */
function wprig_post_tags() {
	// Only show tags on post types that have categories.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'wprig' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'wprig' ) . ' </span>', $tags_list ); // WPCS: XSS OK.
		}
	}
}

/**
 * Prints comments link when comments are enabled.
 */
function wprig_comments_link() {
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'wprig' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo ' </span>';
	}
}

/**
 * Prints edit post/page link when a user with sufficient priveleges is logged in.
 */
function wprig_edit_post_link() {
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'wprig' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		' </span>'
	);
}

/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function wprig_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>

		<div class="post-thumbnail">
			<?php the_post_thumbnail( 'full', array( 'class' => 'skip-lazy' ) ); ?>
		</div><!-- .post-thumbnail -->

		<?php
	else :
		?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
			global $wp_query;
			if ( 0 === $wp_query->current_post ) {
				the_post_thumbnail(
					'full',
					array(
						'class' => 'skip-lazy',
						'alt'   => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
			} else {
				the_post_thumbnail(
					'post-thumbnail', array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
			}
			?>
		</a>

		<?php
	endif; // End is_singular().
}

/**
 * Prints HTML with title and link to original post where attachment was added.
 *
 * @param object $post object.
 */
function wprig_attachment_in( $post ) {
	if ( ! empty( $post->post_parent ) ) :
		$postlink = sprintf(
			/* translators: %s: original post where attachment was added. */
			esc_html_x( 'in %s', 'original post', 'wprig' ),
			'<a href="' . esc_url( get_permalink( $post->post_parent ) ) . '">' . esc_html( get_the_title( $post->post_parent ) ) . '</a>'
		);

		echo '<span class="attachment-in"> ' . $postlink . ' </span>'; // WPCS: XSS OK.

	endif;

}

/**
 * Prints HTML with for navigation to previous and next attachment if available.
 */
function wprig_the_attachment_navigation() {
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php echo esc_html__( 'Post navigation', 'wprig' ); ?></h2>
		<div class="nav-links">
			<div class="nav-previous">
				<div class="post-navigation-sub">
					<?php echo esc_html__( 'Previous attachment:', 'wprig' ); ?>
				</div>
				<?php previous_image_link( false ); ?>
			</div><!-- .nav-previous -->
			<div class="nav-next">
				<div class="post-navigation-sub">
					<?php echo esc_html__( 'Next attachment:', 'wprig' ); ?>
				</div>
				<?php next_image_link( false ); ?>
			</div><!-- .nav-next -->
		</div><!-- .nav-links -->
	</nav><!-- .navigation .attachment-navigation -->
	<?php
}


if ( ! function_exists( 'pehaarig_custom_logo' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
	function pehaarig_custom_logo( $id, $height ) {
		$html = '';
		if ( $id ) {
			$custom_logo_attr = array(
				'class'    => 'custom-logo height-set skip-lazy',
				'itemprop' => 'logo',
				'height' => max( $height, 48 )
			);

			$image_alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
			if ( empty( $image_alt ) ) {
				$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
			}
			$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $id, 'full', false, $custom_logo_attr )
			);
		}
		return $html;
	}
endif;

/**
 * Checks is custom logo is available.
 *
 * @params $version - version of the logo: main, mini or footer
 */
function pehaarig_has_custom_logo( $version = 'main' ) {
	return get_theme_mod( "pehaarig_logo_$version" ) > 0;
}

if ( ! function_exists( 'pehaarig_custom_logo_main' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function pehaarig_custom_logo_main( $echo = true, $animated = false ) {
		$custom_logo_id = get_theme_mod( 'pehaarig_logo_main' );
		$custom_logo_height = intval( get_theme_mod( 'pehaarig_logo_height' ) );
		$logo = pehaarig_custom_logo( $custom_logo_id, $custom_logo_height );
		$svg = '<?xml version="1.0" encoding="UTF-8"?>';
		$svg .= '<svg class="animated-logo custom-logo" width="606px" height="116px" viewBox="0 0 606 116" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
		<g id="logo_maintenant">
		<g transform="translate(0.000000, 0.209000)">
		<polygon class="normal" id="Fill-1" fill="#25397B" color="#25397B" points="87.6738 25.7339 89.1168 29.2099 82.2698 45.9929 96.1148 45.9929 97.2418 48.8079 81.1058 48.8079 74.1208 65.7819 70.9208 65.7819"></polygon>
		<polygon class="color" id="Fill-2" fill="#2597D4" color="#2597D4" points="141.276 65.78 157.26 65.78 157.26 1.76 141.276 1.76" stroke-dasharray="161" stroke-dashoffset="161"></polygon>
		<path d="M178.1299,31.8764 L181.1749,34.6804 L181.2359,65.7804 L178.1299,65.7804 L178.1299,31.8764 Z M223.3929,31.6574 L223.3329,1.7604 L226.4379,1.7604 L226.4379,34.4104 L223.3929,31.6574 Z" id="Fill-3" fill="#25397B" color="#25397B"></path>
		<polygon id="Fill-4" fill="#25397B" color="#25397B" points="265.244 65.78 268.348 65.78 268.348 23.821 265.244 23.821"></polygon>
		<path d="M305.0547,1.7602 L308.1587,1.7602 L308.1587,4.5732 L308.1587,62.9682 L308.2787,62.9682 L308.2787,65.7822 L305.0547,65.7822 L305.0547,1.7602 Z M313.3967,32.3152 L336.6767,32.3152 L336.6767,29.5022 L313.3967,29.5022 L313.3967,32.3152 Z" id="Fill-5" fill="#25397B"></path>
		<polygon class="color" id="Fill-6" fill="#007873" color="#007873" points="98.082 0.7918 90.609 18.7888 110.131 65.7828 126.697 65.7828 99.536 0.7918" stroke-dasharray="159" stroke-dashoffset="159"></polygon>
		<path d="M52.7688,38.1652 L52.7688,65.7802 L55.8748,65.7802 L55.8748,33.6062 L52.7688,38.1652 Z M-0.0002,65.7802 L3.1038,65.7802 L3.1038,38.1652 L-0.0002,33.6062 L-0.0002,65.7802 Z" id="Fill-7" fill="#25397B"></path>
		<polygon class="color" id="Fill-8" fill="#007873" color="#007873" points="313.524 16.57 344.615 16.57 344.615 1.752 313.524 1.752" stroke-dasharray="92" stroke-dashoffset="92"></polygon>
		<polygon class="color" id="Fill-9" fill="#EDAD38" color="#EDAD38" points="313.524 65.876 344.615 65.876 344.615 51.06 313.524 51.06" stroke-dasharray="92" stroke-dashoffset="92"></polygon>
		<polygon id="Fill-10" fill="#25397B" color="#25397B" points="577.925 65.78 581.029 65.78 581.029 23.821 577.925 23.821"></polygon>
		<polygon id="Fill-11" fill="#25397B" color="#25397B" points="439.1875 26.2182 440.6305 29.6942 433.7835 46.4772 447.6295 46.4772 448.7565 49.2922 432.6195 49.2922 425.6355 66.2662 422.4345 66.2662"></polygon>
		<polygon class="color" id="Fill-12" fill="#EC644E" color="#EC644E" points="442.1231 19.2739 449.5951 1.2759 451.0501 1.2759 478.2101 66.2669 461.6441 66.2669" stroke-dasharray="159" stroke-dashoffset="159"></polygon>
		<polygon class="color" id="Fill-13" fill="#EDAD38" color="#EDAD38" points="54.4194 0.7909 27.9374 39.7839 1.4564 0.7909 0.0004 0.7909 0.0004 24.4889 27.2594 64.3589 28.7134 64.3589 55.8734 24.4889 55.8734 0.7909" stroke-dasharray="243" stroke-dashoffset="243"></polygon>
		<polygon class="color" id="Fill-14" fill="#EDAD38" color="#EDAD38" points="178.1298 0.7909 178.1298 23.2939 224.9818 66.7509 226.4378 66.7509 226.4378 43.2449 179.5848 0.7909" stroke-dasharray="176" stroke-dashoffset="176"></polygon>
		<path d="M359.7354,31.8764 L362.7804,34.6804 L362.8404,65.7804 L359.7354,65.7804 L359.7354,31.8764 Z M404.9974,31.6574 L404.9384,1.7604 L408.0424,1.7604 L408.0424,34.4104 L404.9974,31.6574 Z" id="Fill-15" fill="#25397B" color="#25397B"></path>
		<polygon class="color" id="Fill-16" fill="#2597D4" color="#2597D4" points="359.7354 0.7909 359.7354 23.2939 406.5864 66.7509 408.0424 66.7509 408.0424 43.2449 361.1904 0.7909" stroke-dasharray="176" stroke-dashoffset="176"></polygon>
		<path d="M490.8116,31.8764 L493.8566,34.6804 L493.9156,65.7804 L490.8116,65.7804 L490.8116,31.8764 Z M536.0736,31.6574 L536.0146,1.7604 L539.1186,1.7604 L539.1186,34.4104 L536.0736,31.6574 Z" id="Fill-17" fill="#25397B"></path>
		<polygon class="color" id="Fill-18" fill="#007873" color="#007873" points="490.8114 0.7909 490.8114 23.2939 537.6624 66.7509 539.1184 66.7509 539.1184 43.2449 492.2664 0.7909" stroke-dasharray="176" stroke-dashoffset="176"></polygon>
		<polygon class="color" id="Fill-19" fill="#2597D4" color="#2597D4" points="553.772 18.582 605.182 18.582 605.182 1.76 553.772 1.76" stroke-dasharray="136" stroke-dashoffset="136"></polygon>
		<polygon class="color" id="Fill-20" fill="#EC644E" color="#EC644E" points="241.088 18.582 292.498 18.582 292.498 1.76 241.088 1.76" stroke-dasharray="136" stroke-dashoffset="136"></polygon>
		<path d="M177.7851,87.7183 L177.7851,114.5523 L180.9571,114.5523 L180.9571,90.5643 L194.5781,90.5643 L194.5781,87.7183 L177.7851,87.7183 Z M182.9491,102.7203 L192.2601,102.7203 L192.2601,99.7923 L182.9491,99.7923 L182.9491,102.7203 Z" id="Fill-21" fill="#25397B"></path>
		<path d="M228.6504,101.2578 C228.6504,104.8358 227.3904,107.8848 225.3974,109.9978 L225.3974,101.2578 C225.3974,94.9138 220.7614,90.1968 214.7454,90.1968 C211.0454,90.1968 207.9964,91.9868 206.1274,94.0198 L206.1274,90.2788 C208.3214,88.4098 211.3304,87.2718 214.7054,87.2718 C222.4294,87.2718 228.6504,93.2068 228.6504,101.2578 Z M204.0934,101.0138 C204.0934,107.3168 208.6864,112.0718 214.7054,112.0718 C218.3634,112.0718 221.4534,110.2828 223.3644,108.2498 L223.3644,111.9898 C221.1284,113.8618 218.1204,114.9998 214.7454,114.9998 C207.0214,114.9998 200.8004,109.0628 200.8004,101.0138 C200.8004,97.4358 202.1004,94.3848 204.0934,92.2738 L204.0934,101.0138 Z" id="Fill-22" fill="#25397B"></path>
		<path d="M256.1768,104.7129 L256.1768,87.7189 L259.3478,87.7189 L259.3478,108.4549 L256.1768,104.7129 Z M237.9628,93.7749 L241.1328,97.5979 L241.1328,114.5529 L237.9628,114.5529 L237.9628,93.7749 Z M237.9628,90.5649 L237.9628,87.2719 L239.1008,87.2719 L259.3478,111.6659 L259.3478,114.9999 L258.2098,114.9999 L237.9628,90.5649 Z" id="Fill-24" fill="#25397B"></path>
		<path d="M292.9727,101.0527 C292.9727,108.8207 287.4857,114.5527 278.3767,114.5527 L275.5727,114.5527 L275.5727,111.7067 L278.3767,111.7067 C285.5337,111.7067 289.7207,107.1117 289.7207,101.0527 C289.7207,94.9957 285.5337,90.5647 278.3767,90.5647 L275.5727,90.5647 L275.5727,87.7187 L278.3767,87.7187 C287.4857,87.7187 292.9727,93.2887 292.9727,101.0527 Z M270.4087,114.5527 L273.5797,114.5527 L273.5797,87.7187 L270.4087,87.7187 L270.4087,114.5527 Z" id="Fill-26" fill="#25397B"></path>
		<path d="M309.6045,89.832 L310.7425,87.271 L311.9205,87.271 L323.5485,114.553 L320.1735,114.553 L309.6045,89.832 Z M308.5475,92.395 L310.2125,96.338 L305.9455,106.258 L314.4825,106.258 L315.7035,109.105 L304.7255,109.105 L302.4495,114.553 L299.1145,114.553 L308.5475,92.395 Z" id="Fill-28" fill="#25397B"></path>
		<path d="M335.627,114.553 L338.798,114.553 L338.798,92.557 L335.627,92.557 L335.627,114.553 Z M326.193,90.565 L348.271,90.565 L348.271,87.719 L326.193,87.719 L326.193,90.565 Z" id="Fill-30" fill="#25397B"></path>
		<polygon id="Fill-32" fill="#25397B" color="#25397B" points="356.403 114.553 359.575 114.553 359.575 87.719 356.403 87.719"></polygon>
		<path d="M396.6973,101.2578 C396.6973,104.8358 395.4363,107.8848 393.4433,109.9978 L393.4433,101.2578 C393.4433,94.9138 388.8083,90.1968 382.7923,90.1968 C379.0923,90.1968 376.0423,91.9868 374.1733,94.0198 L374.1733,90.2788 C376.3673,88.4098 379.3773,87.2718 382.7503,87.2718 C390.4763,87.2718 396.6973,93.2068 396.6973,101.2578 Z M372.1393,101.0138 C372.1393,107.3168 376.7323,112.0718 382.7503,112.0718 C386.4103,112.0718 389.5003,110.2828 391.4113,108.2498 L391.4113,111.9898 C389.1743,113.8618 386.1673,114.9998 382.7923,114.9998 C375.0653,114.9998 368.8463,109.0628 368.8463,101.0138 C368.8463,97.4358 370.1463,94.3848 372.1393,92.2738 L372.1393,101.0138 Z" id="Fill-33" fill="#25397B"></path>
		<path d="M424.2217,104.7129 L424.2217,87.7189 L427.3927,87.7189 L427.3927,108.4549 L424.2217,104.7129 Z M406.0067,93.7749 L409.1777,97.5979 L409.1777,114.5529 L406.0067,114.5529 L406.0067,93.7749 Z M406.0067,90.5649 L406.0067,87.2719 L407.1467,87.2719 L427.3927,111.6659 L427.3927,114.9999 L426.2537,114.9999 L406.0067,90.5649 Z" id="Fill-34" fill="#25397B"></path>
		</g>
		</g>
		</g>
		</svg>';

		if ( get_theme_mod( 'pehaarig_animate_logo' ) && $animated ) {
			$logo = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
				esc_url( home_url( '/' ) ),
				$svg
			);
		}

		if ( $echo ) {
			echo $logo;
		}
		return $logo;
	}
endif;

if ( ! function_exists( 'pehaarig_custom_logo_mini' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function pehaarig_custom_logo_mini() {
		$custom_logo_id = get_theme_mod( 'pehaarig_logo_mini' );
		pehaarig_custom_logo( $custom_logo_id, 48 );
	}
endif;

if ( ! function_exists( 'pehaarig_custom_logo_footer' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function pehaarig_custom_logo_footer( $echo = true ) {
		$custom_logo_id = get_theme_mod( 'pehaarig_logo_footer' );
		$html = pehaarig_custom_logo( $custom_logo_id, 64 );
		if ( $echo ) {
			echo $html;
		}
		return $html;
	}
endif;

if ( ! function_exists( 'pehaarig_custom_logo_affiliate' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function pehaarig_custom_logo_affiliate( $echo = true ) {
		$custom_logo_id = get_theme_mod( 'pehaarig_logo_affiliate' );
		$url = get_theme_mod( 'pehaarig_link_affiliate' );
		$html = '';
		if ( $custom_logo_id ) {
			$custom_logo_attr = array(
				'class'    => 'custom-logo affiliate-logo skip-lazy',
				'height' => 64,
			);

			$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );			
			$html = sprintf( '<a href="%1$s" class="custom-logo-link affiliate-logo-link" rel="home" itemprop="url">%2$s</a>',
				$url ? esc_url( $url ) : esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr )
			);
		}
		if ( $echo ) {
			echo $html;
		}
		return $html;
	}
endif;

if ( ! function_exists( 'pehaarig_site_title' ) ) :
	function pehaarig_site_title() {
		if ( ! get_theme_mod( 'pehaarig_hide_title' ) ) {
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;
		}
	}
endif;

if ( ! function_exists( 'pehaarig_site_description' ) ) :
	function pehaarig_site_description() {
		$wprig_description = get_bloginfo( 'description', 'display' );
		if ( ! get_theme_mod( 'pehaarig_hide_tagline' ) && ( $wprig_description || is_customize_preview() ) ) {
		?>
			<p class="site-description"><?php echo $wprig_description; /* WPCS: xss ok. */ ?></p>
		<?php
		}
	}
endif;

if ( ! function_exists( 'pehaarig_donation_button' ) ) :
	function pehaarig_donation_button() {
		$url = trim( get_theme_mod( 'pehaarig_link_donate' ) );
		if ( $url ) {
			printf( '<a class="donation-button" href="%1$s"><span class="donation-button-span">%2$s</span></a>', esc_url( $url ), esc_html( 'Faire un don', 'wprig' ) );
		}
	}
endif;

