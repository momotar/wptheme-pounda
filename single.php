<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Pounda
 */

get_header(); ?>

	<div id="primary" class="content-area">






		<?php do_action( 'pounda_before_primary' ); ?>
		<main id="main" class="site-main" role="main">


			<div class="page-title">
				<div class="section-inner">
					<?php breadcrumb(); ?>								
				</div><!-- /section-inner -->
			</div><!-- /page-title -->


		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>


			<?php get_template_part( 'template-parts/change-logs' ); ?>

			<div class="relatedEntry">
                <h3>関連記事</h3>
                <?php get_template_part( 'template-parts/related-entries' ); ?>
            </div>

			<!--?php the_post_navigation(); ?-->
			<?php get_template_part( 'template-parts/content', 'post-navi' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
		<?php do_action( 'pounda_after_primary' ); ?>
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
