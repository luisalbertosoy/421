<?php
/**
 * Funciones del tema 421.
 *
 * @package s421
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'S421_DIR', get_template_directory() );
define( 'S421_URI', get_template_directory_uri() );

/**
 * Soportes del tema.
 */
function s421_setup(): void {
	load_theme_textdomain( 's421', S421_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
}
add_action( 'after_setup_theme', 's421_setup' );

/**
 * Versión de un asset basada en su fecha de modificación.
 */
function s421_asset_version( string $relative_path ): string {
	$file = S421_DIR . '/' . ltrim( $relative_path, '/' );

	return file_exists( $file ) ? (string) filemtime( $file ) : wp_get_theme()->get( 'Version' );
}

/**
 * Carga de CSS y JS.
 */
function s421_enqueue_assets(): void {
	wp_enqueue_style(
		's421-main',
		S421_URI . '/assets/css/main.css',
		array(),
		s421_asset_version( 'assets/css/main.css' )
	);

	wp_enqueue_script(
		's421-main',
		S421_URI . '/assets/js/main.js',
		array(),
		s421_asset_version( 'assets/js/main.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 's421_enqueue_assets' );
