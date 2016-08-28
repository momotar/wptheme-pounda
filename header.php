<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pounda
 */

?>
<?php 	// http://oxynotes.com/?p=3050
		// <!DOCTYPE html>
		/* <html <?php language_attributes(); ?>> */
?>

<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php get_template_part( 'template-parts/content', 'ogp' ); ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'pounda_before_body' ); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'pounda' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<?php do_action( 'pounda_before_header' ); ?>

		<div class="site-branding">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<!--nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'pounda' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav--><!-- #site-navigation -->















			<div class="toggles">
						
				<div class="nav-toggle toggle">
					
					<div class="bar"></div>
					<div class="bar"></div>
					<div class="bar"></div>
					
				</div>
				
				<div class="search-toggle toggle">
					
					<div class="genericon genericon-search"></div>
					
				</div>
				
				<div class="clear"></div>
				
			</div> <!-- /toggles -->





















		<div class="navigation bg-white no-padding">
			
			<div class="section-inner">
				
				<ul class="mobile-menu">
				
					<?php if ( has_nav_menu( 'primary' ) ) {
																		
						wp_nav_menu( array( 
						
							'container' => '', 
							'items_wrap' => '%3$s',
							'theme_location' => 'primary'
														
						) ); } else {
					
						wp_list_pages( array(
						
							'container' => '',
							'title_li' => ''
						
						));
						
					} ?>
					
				</ul>
				
				<div class="mobile-search">
				
					<?php get_search_form(); ?>
				
				</div>
				
				<ul class="main-menu">
				
					<?php if ( has_nav_menu( 'primary' ) ) {
																	
						wp_nav_menu( array( 
						
							'container' => '', 
							'items_wrap' => '%3$s',
							'theme_location' => 'primary'
														
						) ); } else {
					
						wp_list_pages( array(
						
							'container' => '',
							'title_li' => ''
						
						));
						
					} ?>
					
				</ul>
				
				<div class="clear"></div>
				
			</div> <!-- /section-inner -->
			
		</div> <!-- /navigation -->






























		<?php do_action( 'pounda_after_header' ); ?>
	</header><!-- #masthead -->











		<?php if ( is_singular() && has_post_thumbnail() ) : ?>
		
			<?php 
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-image-cover' );
				$post_image = $thumb['0']; 
			?>
		
			<div class="header-image bg-image" style="background-image: url(<?php echo esc_url( $post_image ); ?>)">
				
				<?php the_post_thumbnail('post-image'); ?>
				
			</div>
		
		<?php else : ?>
		
			<div class="header-image bg-image" style="background-image: url(<?php if (get_header_image() != '') { header_image(); echo ')'; } else { echo   get_template_directory_uri() . "/images/header.jpg)"; } ?>">
				
				<?php 
					if (get_header_image() != '') {
						echo '<img src="'; header_image(); echo '">';
					} else {
						echo '<img src="' . get_template_directory_uri() . '/images/header.jpg">';
					}
				?>
				
			</div>
		
		<?php endif; ?>













	<div id="content" class="site-content">
		<?php do_action( 'pounda_before_content' ); ?>
