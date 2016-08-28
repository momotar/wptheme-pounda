<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Pounda
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php do_action( 'pounda_before_entry_header' ); ?>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php pounda_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		<?php do_action( 'pounda_after_entry_header' ); ?>
	</header><!-- .entry-header -->

	<?php //< div class="entry-summary">
		 //the_excerpt();
	//</div><!-- .entry-summary --> ?>

	<div class="entry-content">
		<?php do_action( 'pounda_before_entry_content' ); ?>
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'pounda' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pounda' ),
				'after'  => '</div>',
			) );
		?>
		<?php do_action( 'pounda_after_entry_content' ); ?>
	</div><!-- .entry-content -->

	<?php //<footer class="entry-footer">
		//pounda_entry_footer();
	//</footer><!-- .entry-footer --> ?>
</article><!-- #post-## -->

