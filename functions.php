<?php
/**
 * Primer functions and definitions.
 *
 * Set up the theme and provide some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a `function_exists()` call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in `function_exists()`) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Primer
 * @since   1.0.0
 */

/**
 * Primer theme version.
 *
 * @since 1.0.0
 *
 * @var string
 */
define( 'PRIMER_VERSION', '1.0.0' );

/**
 * Minimum WordPress version required for Primer.
 *
 * @since 1.0.0
 *
 * @var string
 */
if ( ! defined( 'PRIMER_MIN_WP_VERSION' ) ) {

	define( 'PRIMER_MIN_WP_VERSION', '4.1' );

}

/**
 * Enforce the minimum WordPress version requirement.
 *
 * @since 1.0.0
 */
if ( version_compare( get_bloginfo( 'version' ), PRIMER_MIN_WP_VERSION, '<' ) ) {

	require_once get_template_directory() . '/inc/back-compat.php';

}

/**
 * Load custom helper functions for this theme.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/helpers.php';

/**
 * Load custom template tags for this theme.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Load template parts and override some WordPress defaults.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/hooks.php';

/**
 * Load Customizer class.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Load WooCommerce compatibility file.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/woocommerce.php';

/**
 * Load Jetpack compatibility file.
 *
 * @since 1.0.0
 */
require_once get_template_directory() . '/inc/jetpack.php';

if ( ! function_exists( 'primer_setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the 'after_setup_theme' hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since 1.0.0
	 */
	function primer_setup() {

		/**
		 * Load theme translations.
		 *
		 * Translations can be filed in the /languages/ directory. If you're
		 * building a theme based on Primer, use a find and replace to change
		 * 'primer' to the name of your theme in all the template files.
		 *
		 * @link  https://codex.wordpress.org/Function_Reference/load_theme_textdomain
		 * @since 1.0.0
		 */
		load_theme_textdomain( 'primer', get_template_directory() . '/languages' );

		/**
		 * Add an image size for Featured Images.
		 *
		 * @link  https://codex.wordpress.org/Function_Reference/add_image_size
		 * @since 1.0.0
		 */
		add_image_size( 'primer-featured', 1600, 900, 1 );

		/**
		 * Enable support for Automatic Feed Links.
		 *
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Feed_Links
		 * @since 1.0.0
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for plugins and themes to manage the document title tag.
		 *
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
		 * @since 1.0.0
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 * @since 1.0.0
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Register custom Custom Navigation Menus.
		 *
		 * @link  https://codex.wordpress.org/Function_Reference/register_nav_menus
		 * @since 1.0.0
		 */
		register_nav_menus(
			/**
			 * Filter registered nav menus.
			 *
			 * @since 1.0.0
			 *
			 * @var array
			 */
			(array) apply_filters( 'primer_nav_menus',
				array(
					'primary' => esc_html__( 'Primary Menu', 'primer' ),
					'social'  => esc_html__( 'Social Menu', 'primer' ),
				)
			)
		);

		/**
		 * Enable support for HTML5 markup.
		 *
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
		 * @since 1.0.0
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/**
		 * Enable support for Post Formats.
		 *
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Formats
		 * @since 1.0.0
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
			)
		);

	}

}
add_action( 'after_setup_theme', 'primer_setup' );

/**
 * Sets the content width in pixels, based on the theme layout.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @action after_setup_theme
 * @global int $content_width
 * @since  1.0.0
 */
function primer_content_width() {

	$layout        = primer_get_layout();
	$content_width = ( 'one-column-wide' === $layout ) ? 1068 : 688;

	/**
	 * Filter the content width in pixels.
	 *
	 * @since 1.0.0
	 *
	 * @param string $layout
	 *
	 * @var int
	 */
	$GLOBALS['content_width'] = (int) apply_filters( 'primer_content_width', $content_width, $layout );

}
add_action( 'after_setup_theme', 'primer_content_width', 0 );

/**
 * Enable support for custom editor style.
 *
 * @link  https://developer.wordpress.org/reference/functions/add_editor_style/
 * @since 1.0.0
 */
function primer_editor_style() {

	add_editor_style();

}
add_action( 'admin_init', 'primer_editor_style' );

/**
 * Register sidebar areas.
 *
 * @link  http://codex.wordpress.org/Function_Reference/register_sidebar
 * @since 1.0.0
 */
function primer_register_sidebars() {

	/**
	 * Filter registered sidebars areas.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	$sidebars = (array) apply_filters( 'primer_register_sidebars',
		array(
			array(
				'name'          => esc_html__( 'Sidebar', 'primer' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'The primary sidebar appears alongside the content of every page, post, archive, and search template.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			array(
				'name'          => esc_html__( 'Secondary Sidebar', 'primer' ),
				'id'            => 'sidebar-2',
				'description'   => esc_html__( 'The secondary sidebar will only appear when you have selected a three-column layout.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			array(
				'name'          => esc_html__( 'Footer 1', 'primer' ),
				'id'            => 'footer-1',
				'description'   => esc_html__( 'This sidebar is the first column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			array(
				'name'          => esc_html__( 'Footer 2', 'primer' ),
				'id'            => 'footer-2',
				'description'   => esc_html__( 'This sidebar is the second column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			),
			array(
				'name'          => esc_html__( 'Footer 3', 'primer' ),
				'id'            => 'footer-3',
				'description'   => esc_html__( 'This sidebar is the third column of the footer widget area.', 'primer' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		)
	);

	foreach ( $sidebars as $args ) {

		register_sidebar( $args );

	}

}
add_action( 'widgets_init', 'primer_register_sidebars' );

if ( ! function_exists( 'primer_scripts' ) ) {

	/**
	 * Enqueue theme scripts and styles.
	 *
	 * @link  https://codex.wordpress.org/Function_Reference/wp_enqueue_style
	 * @link  https://codex.wordpress.org/Function_Reference/wp_enqueue_script
	 * @since 1.0.0
	 */
	function primer_scripts() {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style( 'primer', get_stylesheet_uri(), false, PRIMER_VERSION );

		wp_style_add_data( 'primer', 'rtl', 'replace' );

		wp_enqueue_script( 'primer-navigation', get_template_directory_uri() . "/assets/js/navigation{$suffix}.js", array(), PRIMER_VERSION, true );
		wp_enqueue_script( 'primer-skip-link-focus-fix', get_template_directory_uri() . "/assets/js/skip-link-focus-fix{$suffix}.js", array(), PRIMER_VERSION, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

			wp_enqueue_script( 'comment-reply' );

		}

		/**
		 * Enqueue lt IE 9 Conditional
		 */
		wp_enqueue_style( 'primer-lt-ie9-style', get_template_directory_uri() . '/assets/css/ie.css', array(), PRIMER_VERSION );
		wp_style_add_data( 'primer-lt-ie9-style', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'primer-respond', get_template_directory_uri() . '/assets/js/respond.min.js', array(), PRIMER_VERSION );
		wp_script_add_data( 'primer-respond', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'primer-nwmatcher', get_template_directory_uri() . '/assets/js/nwmatcher.min.js', array(), PRIMER_VERSION );
		wp_script_add_data( 'primer-nwmatcher', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'primer-jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), PRIMER_VERSION );
		wp_script_add_data( 'primer-jquery', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'primer-html5shiv', get_template_directory_uri() . '/assets/js/html5shiv.min.js', array(), PRIMER_VERSION );
		wp_script_add_data( 'primer-html5shiv', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'primer-selectivizr', get_template_directory_uri() . '/assets/js/selectivizr.min.js', array(), PRIMER_VERSION );
		wp_script_add_data( 'primer-selectivizr', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'primer-rem', get_template_directory_uri() . '/assets/js/rem.min.js', array(), PRIMER_VERSION );
		wp_script_add_data( 'primer-rem', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'primer-jquery-backgroundSize', get_template_directory_uri() . '/assets/js/jquery.backgroundSize.min.js', array( 'primer-jquery' ), PRIMER_VERSION );
		wp_script_add_data( 'primer-jquery-backgroundSize', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'primer-lt-ie9-script', get_template_directory_uri() . "/assets/js/lt-ie9$suffix.js", array( 'primer-jquery' ), PRIMER_VERSION );
		wp_script_add_data( 'primer-lt-ie9-script', 'conditional', 'lt IE 9' );

	}

}
add_action( 'wp_enqueue_scripts', 'primer_scripts' );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @action wp
 * @global WP_Query $wp_query
 * @global WP_User  $authordata
 * @since  1.0.0
 */
function primer_setup_author() {

	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {

		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );

	}

}
add_action( 'wp', 'primer_setup_author' );

/**
 * Reset the transient for the active categories check.
 *
 * @action create_category
 * @action edit_category
 * @action delete_category
 * @action save_post
 * @see    primer_has_active_categories()
 * @since  1.0.0
 */
function primer_has_active_categories_reset() {

	delete_transient( 'primer_has_active_categories' );

}
add_action( 'create_category', 'primer_has_active_categories_reset' );
add_action( 'edit_category',   'primer_has_active_categories_reset' );
add_action( 'delete_category', 'primer_has_active_categories_reset' );
add_action( 'save_post',       'primer_has_active_categories_reset' );

/**
 * Add title to Page Builder template.
 *
 * @since 1.0.0
 */
function primer_add_page_builder_template_title(){
	if( is_page_template( 'templates/page-builder.php' ) ){
		get_template_part( 'templates/parts/header', 'page-title' );
	}
}
add_action( 'primer_after_header', 'primer_add_page_builder_template_title', 100 );

/**
 * Add title to blog index template.
 *
 * @since 1.0.0
 */
function primer_add_blog_title(){
	if( is_home() || is_single() ){
		get_template_part( 'templates/parts/blog', 'title' );
	}
}
add_action( 'primer_after_header', 'primer_add_blog_title', 100 );

/**
 * Add archive title to archive template.
 *
 * @since 1.0.0
 */
function primer_add_archive_title(){
	if( is_archive() ){
		get_template_part( 'templates/parts/archive', 'title' );
	}
}
add_action( 'primer_after_header', 'primer_add_archive_title', 100 );
