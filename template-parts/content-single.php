<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Pounda
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php do_action( 'pounda_before_entry_header' ); ?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php pounda_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php do_action( 'pounda_after_entry_header' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php do_action( 'pounda_before_entry_content' ); ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pounda' ),
				'after'  => '</div>',
			) );
		?>
		<?php do_action( 'pounda_after_entry_content' ); ?>
	</div><!-- .entry-content -->

	<!--?php <footer class="entry-footer">
		<?php pounda_entry_footer(); ?>
	</footer>?-->
</article><!-- #post-## -->

