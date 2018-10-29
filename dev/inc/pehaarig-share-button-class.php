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
		$this->iconShare = '<svg class="pehaarig-svg pehaarig-trigger-share"><use xlink:href="#share" /></svg>';
		$this->twitterShare = '<svg class="pehaarig-svg pehaarig-share-service"><use xlink:href="#twitter" /></svg>';
		$this->facebookShare = '<svg class="pehaarig-svg pehaarig-share-service"><use xlink:href="#facebook" /></svg>';
		$this->linkedinShare = '<svg class="pehaarig-svg pehaarig-share-service"><use xlink:href="#linkedin-share" /></svg>';
		$this->mailShare = '<svg class="pehaarig-svg pehaarig-share-service"><use xlink:href="#mail" /></svg>';
	}

	public function display_share() {
		$output = '<div class="pehaarig-share-buttons-ctnr">';
		$output .= sprintf( '<button class="pehaarig-trigger-share-btn withoutbuttonlook" type="button" aria-label="Share">%1$s</button>', $this->iconShare );
		$output .= '<div class="pehaarig-share-buttons">';
		$output .= sprintf( '<a href="%1$s" aria-label="Share on Twitter">%2$s</a>', $this->link_twitter, $this->twitterShare );
		$output .= sprintf( '<a href="%1$s" aria-label="Share on Facebook">%2$s</a>', $this->link_facebook, $this->facebookShare );
		$output .= sprintf( '<a href="%1$s" aria-label="Share on Linkedin">%2$s</a>', $this->link_linkedin, $this->linkedinShare );
		//$output .= sprintf( '<a href="%1$s" aria-label="Share via Email">%2$s</a>', $this->link_mail, $this->mailShare );
		$output .= '</div>';
		$output .= '</div>';
		return $output;
	}

	private function generate_links() {

		if ( is_front_page() || !$this->id ) {
			$share_url = esc_url( home_url( '/' ) );
			$share_title = esc_html( get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ) );
		} else {
			$share_url = esc_url( get_the_permalink( $this->id ) );
			$share_title = esc_html( get_the_title( $this->id ) );
		}
		$description = $this->id ? get_post_field( 'post_excerpt', $this->id ) : '';
		if ( !$share_url ) {
			return;
		}
		$this->link_twitter = esc_url( 'https://twitter.com/share?text=' . rawurlencode( html_entity_decode( $share_title, ENT_COMPAT, 'UTF-8' ) ) . '&url=' . rawurlencode( $share_url ) );

		// check here: https://cards-dev.twitter.com/validator must be enabled for robots

		$this->link_facebook = esc_url( 'https://m.facebook.com/sharer.php?u=' . $share_url . '&t=' . rawurlencode( $share_title ) );

		// check here: https://developers.facebook.com/tools/debug/sharing/

		$this->link_linkedin = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $share_url . '&amp;title=' . rawurlencode( $share_title ) . '&amp;summary=' . rawurlencode( mb_substr( html_entity_decode( $description, ENT_QUOTES, 'UTF-8' ), 0, 256 ) );

		// check here: https://www.linkedin.com/post-inspector/inspect/

		$this->link_mail = 'mailto:?subject=' . rawurlencode( $share_title ) . '&body=' . $share_url;
	}

}

endif;
