<?php
/**
 * Template part for displaying page content in custom-page-template-full.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wprig
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	
	<?php
	the_content();
	?>
	

</article><!-- #post-<?php the_ID(); ?> -->
