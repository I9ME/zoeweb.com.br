<?php
/**
 * Skeleton funções e definições
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage skeleton
 * @since 1.0
 */


/**
 * Funções e Configurações do Tema
 */
function skeleton_setup() {
	load_theme_textdomain( 'skeleton' );

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
	 * Ativando o recurso de Imagem Destacada
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'skeleton-featured-image', 2000, 1200, true );

	add_image_size( 'skeleton-thumbnail-avatar', 100, 100, true );

	
	// Localizações dos Menus
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'skeleton' ),
		'social' => __( 'Social Links Menu', 'skeleton' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Habilitando os Formatos de POst
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Habilitando o recurso de Logotipo Customizável.

	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Editor de Estilo
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', skeleton_fonts_url() ) );

}

add_action( 'after_setup_theme', 'skeleton_setup' );

/**
 * Registrando as fontes customizadas.
 */
function skeleton_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$rajdhani = _x( 'on', 'Rajdhani font: on or off', 'skeleton' );

	if ( 'off' !== $rajdhani ) {
		$font_families = array();

		$font_families[] = 'Rajdhani:400,500,600,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Skeleton 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function skeleton_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'skeleton-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'skeleton_resource_hints', 10, 2 );



/**
 * Customizando o "Saiba mais / Continue lendo"
 * 
 *
 * @since Skeleton 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function skeleton_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'skeleton' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'skeleton_excerpt_more' );


/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Skeleton 1.0
 */
function skeleton_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'skeleton_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function skeleton_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'skeleton_pingback_header' );



/**
 * Enqueue scripts and styles.
 */
function skeleton_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'skeleton-fonts', skeleton_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'skeleton-style', get_stylesheet_uri() );

	

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'skeleton-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'skeleton-style' ), '1.0' );
		wp_style_add_data( 'skeleton-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'skeleton-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'skeleton-style' ), '1.0' );
	wp_style_add_data( 'skeleton-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );


	wp_enqueue_script( 'skeleton-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

}
add_action( 'wp_enqueue_scripts', 'skeleton_scripts' );



/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );
