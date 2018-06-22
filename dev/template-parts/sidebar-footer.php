<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wprig
 */

 $sidebar_id = 'footer-1';

if ( is_active_sidebar( $sidebar_id ) ) :
    wp_print_styles( array( 'wprig-sidebar', 'wprig-widgets' ) );
    $all_widgets = wp_get_sidebars_widgets();
    $count = count( $all_widgets[ $sidebar_id ] );
    $aside_class = 0 === $count % 3 || $count % 3 > $count % 4	? 'grid-3cols' : 'grid-4cols';
?>
<aside id="secondary-2" class="secondary-sidebar widget-area <?php echo esc_attr( $aside_class ); ?>">
    <?php dynamic_sidebar( $sidebar_id ); ?>
</aside>
<?php endif;
