<?php
/**
 * Share Button
 *
 *
 * @package PeHaarig
 * @author  PeHaa THEMES <info@pehaa.com>
 */

if ( ! class_exists( 'PeHaaRig_Share_Button' ) ) :

class PeHaaRig_Share_Button {

	public function __construct( $id = NULL ) {

		if ( $id ) {
			$this->id = $id;
		} else {
			$this->id = get_the_ID();
		}

		$this->generate_links();
	}

	public function display_share() {

		$output = sprintf( '<button type="button" aria-label="Share">%1$s</button>', 'iconS');
		$output .= '<div class="pehaarig-share-buttons">';
		$output .= sprintf( '<a href="%1$s" aria-label="Share on Twitter">%2$s</a>', $this->link_twitter, 'iconT');
		$output .= sprintf( '<a href="%1$s" aria-label="Share on Facebook">%2$s</a>', $this->link_facebook, 'iconF');
		$output .= sprintf( '<a href="%1$s" aria-label="Share on Linkedin">%2$s</a>', $this->link_linkedin, 'iconFL');
		$output .= '</div>';
		
		return $output;

	}

	private function generate_links() {

		if ( is_front_page() || !$this->id ) {
			$share_url = home_url( '/' );
			$share_title = get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' );
		} else {
			$share_url = get_the_permalink( $this->id );
			$share_title = get_the_title( $this->id );
		}		

		if ( !$share_url ) {
			return;
		}
		$this->link_twitter = esc_url( 'https://twitter.com/share?text=' . rawurlencode( html_entity_decode( $share_title, ENT_COMPAT, 'UTF-8' ) ) . '&url=' . rawurlencode( $share_url ) );
		$this->link_facebook = esc_url( 'https://www.facebook.com/sharer/sharer.php?u='.$share_url );
		$this->link_google_plus = esc_url( 'https://plus.google.com/share?url=' .$share_url );
	}

}

endif;