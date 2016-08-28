<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pounda
 */

?>

		<?php do_action( 'pounda_after_content' ); ?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php do_action( 'pounda_before_footer' ); ?>
		<div class="site-info">
			<?php do_action( 'pounda_footer' ); ?>
			&copy; <?php 
			  $fromYear = 2016; 
			  $thisYear = (int)date('Y'); 
			  echo $fromYear, 
			  		(($fromYear != $thisYear) ? '-' . $thisYear : ''), 
			  		'&nbsp;', 
			  		'<a href="', bloginfo('url'), '" title="', bloginfo('name'), '">', bloginfo('name'), '</a>',
			  		' | ', bloginfo('description');
			?>
		</div><!-- .site-info -->
		<?php do_action( 'pounda_after_footer' ); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php do_action( 'pounda_after_body' ); ?>

<?php wp_footer(); ?>

</body>
</html>
