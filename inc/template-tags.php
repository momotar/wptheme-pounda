<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Pounda
 */

if ( ! function_exists( 'pounda_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function pounda_posted_on() {
	$time_string_published = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string_published = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		$time_string_updated = '<time class="updated" datetime="%3$s">%4$s</time>';
	} else {
		$time_string_updated = '';
	}

	$time_string_published = sprintf( $time_string_published,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	$time_string_updated = sprintf( $time_string_updated,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$published_on = sprintf(
		esc_html( 'Published ON %s', 'post date', 'pounda' ), // 日本語訳にしたい場合は esc_html_x 関数に変更する
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string_published . '</a>'
	);
	$updated_on = sprintf(
		esc_html( 'Last Updated ON %s', 'post date', 'pounda' ), // 日本語訳にしたい場合は esc_html_x 関数に変更する
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string_updated . '</a>'
	);
	if ( get_the_time( 'U' ) == get_the_modified_time( 'U' ) ) {
		$updated_on = '';
	}

	$byline = sprintf(
		esc_html( 'BY %s', 'post author', 'pounda' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'pounda' ) );
	if ( $categories_list && pounda_categorized_blog() ) {
		$categories_list = sprintf( '<span class="cat-links">' . esc_html( 'IN %1$s', 'pounda' ) . '</span>', $categories_list ); // WPCS: XSS OK.
	}

	echo '<p class="byline"> ', $byline, '</p><p class="posted-on">', $updated_on, '&nbsp;', $published_on, '</p><p class="cat-links">', $categories_list, '</p>'; // WPCS: XSS OK.
	edit_post_link('Edit', '<p>', '</p>');
	get_template_part( 'template-parts/content', 'photo-credit' );

}
endif;

if ( ! function_exists( 'pounda_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function pounda_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'pounda' ) );
		if ( $categories_list && pounda_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'pounda' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'pounda' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'pounda' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'pounda' ), esc_html__( '1 Comment', 'pounda' ), esc_html__( '% Comments', 'pounda' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'pounda' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function pounda_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'pounda_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'pounda_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so pounda_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so pounda_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in pounda_categorized_blog
 */
function pounda_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'pounda_categories' );
}
add_action( 'edit_category', 'pounda_category_transient_flusher' );
add_action( 'save_post',     'pounda_category_transient_flusher' );
