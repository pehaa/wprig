<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wprig
 */
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/pehaarig-share-button-class.php';
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
			$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
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
		$svg = '<svg class="pehaarig-svg" height="64"><use xlink:href="#animated-logo" /></svg>';

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
				'width' => 64,
			);

			$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
			$html = sprintf( '<a href="%1$s" class="custom-logo-link affiliate-logo-link" target="_blank" rel="noopener" itemprop="url">%2$s</a>',
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
			printf( '<a class="donation-button" href="%1$s" %2$s>
						<span class="circle_pos">
							<svg class="circle" version="1.1" viewBox="0 0 100 100">
								<circle fill="rgba(37, 151, 212,.8)" cx="50" cy="50" r="50" />
								<circle fill="rgb(37, 151, 212)" cx="50" cy="50" r="46" />
								<circle fill="rgba(0, 120, 115, .4)" cx="50" cy="50" r="38" />
								<circle fill="rgba(0, 120, 115, .6)" cx="50" cy="50" r="30" />
								<circle fill="rgb(0, 120, 115)" cx="50" cy="50" r="22" />
								<circle fill="rgba(236, 100, 78,.75)" cx="50" cy="50" r="15" />
								<circle fill="rgb(236, 100, 78)" cx="50" cy="50" r="10" />
								<circle fill="#ebac45" cx="50" cy="50" r="5" />
							</svg>
						</span>
  						<span class="donation-button-span">Faire un don</span>
  					</a>',
  					esc_url( $url ),
  					get_theme_mod( 'pehaarig_link_donate_new_tab', 1 ) ? 'target="_blank" rel="noopener"': ''
  				);
		}
	}
endif;

if ( ! function_exists( 'pehaarig_social_share') ) {
	function pehaarig_social_share() {
		$share = new PeHaaRig_Share_Button();
		echo apply_filters( 'pehaarig_share_ouput', $share->display_share( false, false ) );
	}
}
