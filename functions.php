<?php
/**
 * Pounda functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pounda
 */

if ( ! function_exists( 'pounda_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function pounda_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on pounda, use a find and replace
	 * to change 'pounda' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'pounda', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style();

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'pounda' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'pounda_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // pounda_setup
add_action( 'after_setup_theme', 'pounda_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pounda_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pounda_content_width', 640 );
}
add_action( 'after_setup_theme', 'pounda_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pounda_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'pounda' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'pounda_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pounda_scripts() {

	$pounda_theme_data = wp_get_theme();
	$pounda_theme_ver  = $pounda_theme_data->get( 'Version' );

	$pounda_stylesheet = get_stylesheet_uri();

	if ( defined( 'WP_DEBUG' ) && ( WP_DEBUG == true ) && file_exists( get_stylesheet_directory() . '/css/style.css' ) ) { // WP_DEBUG = ture
		$pounda_stylesheet = get_stylesheet_directory_uri() . '/css/style.css';
	}

	wp_enqueue_style(
		'pounda-style',
		$pounda_stylesheet,
		array(),
		$pounda_theme_ver
	);

	wp_enqueue_script(
		'pounda-navigation',
		get_template_directory_uri() . '/js/navigation.js',
		array(),
		'20120206',
		true
	);

	wp_enqueue_script(
		'pounda-skip-link-focus-fix',
		get_template_directory_uri() . '/js/skip-link-focus-fix.js',
		array(),
		'20130115',
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script(
		'pounda-script',
		get_stylesheet_directory_uri() . '/js/pounda.js',
		array('jquery'),
		$pounda_theme_ver,
		true
	);

	wp_enqueue_script(
		'global-script',
		get_stylesheet_directory_uri() . '/js/global.js',
		array('jquery'),
		$pounda_theme_ver,
		true
	);

	wp_enqueue_script(
		'doubletaptogo-script',
		get_stylesheet_directory_uri() . '/js/doubletaptogo.js',
		array(),
		$pounda_theme_ver,
		true
	);

	wp_enqueue_script(
		'highlightjs-script',
		get_stylesheet_directory_uri() . '/js/fire-highlightjs.js',
		array('jquery'),
		$pounda_theme_ver,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'pounda_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

// Add theme widgets
require get_template_directory() . '/widgets/recent-posts.php';

require get_template_directory() . '/inc/breadcrumb.php'; //パンくずリスト生成関数ファイルをインクルード

require get_template_directory() . '/inc/post-updated-modifier.php'; //投稿の更新日を管理画面で設定する関数ファイルをインクルード

if ( defined('WP_DEBUG') && WP_DEBUG ) { //デバッグモードが有効なことを確実にチェック
	if ( is_user_logged_in() ) { //閲覧者がログインしていれば
		require get_template_directory() . '/inc/show-applied-filenames.php'; //適用ファイルを表示する関数ファイルをインクルード
	}
}

//---------------------------------------------------------------------------
// 絵文字用の Javasvript 除去 http://thk.kanzae.net/net/wordpress/t1779/
//---------------------------------------------------------------------------
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles', 10 );