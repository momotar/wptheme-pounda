<?php //カテゴリ情報から関連記事を3個ランダムに呼び出す
    $categories = get_the_category($post->ID);
    $category_ID = array();
    foreach($categories as $category):
        if ($category->count >= 3) {
        	array_push( $category_ID, $category -> cat_ID);
		} else { //該当カテゴリの記事数が3つ以上なければ、親カテゴリから関連記事を抽出
			array_push( $category_ID, $category -> category_parent);
		}
    endforeach;
    $args = array(
        'post__not_in' => array($post -> ID),
        'posts_per_page'=> 3,
        'category__in' => $category_ID,
        'orderby' => 'rand',
    );
    $query_by_cat = new WP_Query($args);
    //タグ情報から関連記事をランダムに呼び出す
    $tags = wp_get_post_tags($post->ID);
    $tag_ids = array();
    foreach($tags as $tag):
      array_push( $tag_ids, $tag -> term_id);
    endforeach ;
        //カテゴリで抽出した記事を除外指定
        $except_cat_posts = array($post->ID);
        $posts = $query_by_cat->get_posts();
        foreach($posts as $post): 
            array_push( $except_cat_posts, $post->ID);
        endforeach;
    $args = array(
        'post__not_in' => $except_cat_posts,
        'posts_per_page'=> 3,
        'tag__in' => $tag_ids,
        'orderby' => 'rand',
    );
    $query_by_tag = new WP_Query($args);
    //関連記事データの連結
    $query = new WP_Query();
    $query->posts = array_merge( $query_by_cat->posts, $query_by_tag->posts );
    $query->post_count = count( $query->posts );
?>
    <div class="uk-grid uk-grid-match">
<?php 
    if( $query -> have_posts() ):
        while ($query -> have_posts()) : $query -> the_post(); ?>
            <div class="uk-width-medium-1-2">
                <a class="uk-grid relatedEntry__post" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
                    <div class="uk-width-3-10 relatedEntry__thumb">
                        <span class="thumbnail-screen">
                            <?php 
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail();
                                } else {
                                    echo '<img src="' . get_template_directory_uri() . '/images/header.jpg">';
                                }
                            ?>
                            <span class="thumbnail-hover"></span>
                        </span>
                    </div>
                    <div class="uk-width-7-10 relatedEntry__title">
                        <h4><?php the_title(); ?></h4>
                        <span class="relatedEntry__postDate">
                            <?php print('Published '.get_post_time('M d, Y')); ?>
                        </span>
                    </div>
                </a>
            </div>
    <?php 
        endwhile;
    else: ?>
        <p>関連する記事はありません</p>
<?php
    endif;
    wp_reset_postdata(); ?>       
</div>