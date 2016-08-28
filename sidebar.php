<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pounda
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'pounda_before_secondary' ); ?>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php do_action( 'pounda_after_secondary' ); ?>

<?php 
	if ( defined('WP_DEBUG') && WP_DEBUG ) { //デバッグモードが有効なことを確実にチェック
		if ( is_user_logged_in() ) { //閲覧者がログインしていれば
			show_template_filenames(); 
			show_included_filenames();
		}
	}
?>

</div><!-- #secondary -->
