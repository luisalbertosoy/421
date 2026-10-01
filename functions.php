<?php
/**
 * 421 Sound Experience — functions.php
 * Theme: 421
 *
 * @package s421
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =========================
// CONFIG
// =========================
require_once get_template_directory() . '/config.php';

// =========================
// INCLUDES
// =========================
foreach ( array( 'cpt', 'taxonomies', 'helpers' ) as $s421_include ) {
	$s421_include_file = S421_DIR . '/inc/' . $s421_include . '.php';
	if ( file_exists( $s421_include_file ) ) {
		require_once $s421_include_file;
	}
}
unset( $s421_include, $s421_include_file );

// =========================
// THEME SETUP
// =========================
function s421_setup(): void {
	load_theme_textdomain( 's421', S421_DIR . '/languages' );

	register_nav_menus(
		array(
			'main-menu'   => __( 'Main menu', 's421' ),
			'footer-menu' => __( 'Footer menu', 's421' ),
		)
	);

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
}
add_action( 'after_setup_theme', 's421_setup' );

/**
 * Asset version based on its last modification time.
 */
function s421_asset_version( string $relative_path ): string {
	$file = S421_DIR . '/' . ltrim( $relative_path, '/' );

	return file_exists( $file ) ? (string) filemtime( $file ) : S421_VERSION;
}

// =========================
// STYLES
// =========================
function s421_enqueue_styles(): void {
	wp_enqueue_style( 's421-base', S421_URI . '/assets/css/base.css', array(), s421_asset_version( 'assets/css/base.css' ) );
	wp_enqueue_style( 's421-layout', S421_URI . '/assets/css/layout.css', array( 's421-base' ), s421_asset_version( 'assets/css/layout.css' ) );
	wp_enqueue_style( 's421-components', S421_URI . '/assets/css/components.css', array( 's421-base', 's421-layout' ), s421_asset_version( 'assets/css/components.css' ) );

	// Per-page styles.
	if ( is_front_page() && file_exists( S421_DIR . '/assets/css/home.css' ) ) {
		wp_enqueue_style( 's421-home', S421_URI . '/assets/css/home.css', array( 's421-base', 's421-layout', 's421-components' ), s421_asset_version( 'assets/css/home.css' ) );
	}
}
add_action( 'wp_enqueue_scripts', 's421_enqueue_styles' );

// =========================
// SCRIPTS
// =========================
function s421_enqueue_scripts(): void {
	// Handle suffix => file name in assets/js. Only enqueued if the file exists.
	$scripts = array(
		'main'      => 'main.js',
		'fade'      => 'fade.js',
		'scroll'    => 'scroll.js',
		'fit-text'  => 'fit-text.js',
		'accordion' => 'accordion.js',
	);

	foreach ( $scripts as $handle => $file ) {
		$path = 'assets/js/' . $file;
		if ( file_exists( S421_DIR . '/' . $path ) ) {
			wp_enqueue_script( 's421-' . $handle, S421_URI . '/' . $path, array(), s421_asset_version( $path ), true );
		}
	}

	if ( wp_script_is( 's421-fade', 'enqueued' ) ) {
		wp_localize_script(
			's421-fade',
			's421Ajax',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 's421_enqueue_scripts' );

// =========================
// GOOGLE FONTS
// =========================
function s421_google_fonts(): void {
	wp_enqueue_style( 's421-fonts', 'https://fonts.googleapis.com/css2?family=Geist:ital,wght@0,100..900;1,100..900&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 's421_google_fonts' );

// =========================
// CONTENT HELPERS
// =========================

/**
 * Remove <strong> inside headings (added by the WP editor).
 */
function s421_remove_strong_from_headings( $content ) {
	return preg_replace_callback(
		'/<h[1-6][^>]*>.*?<\/h[1-6]>/s',
		static function ( array $matches ): string {
			return preg_replace( '/<\/?strong>/', '', $matches[0] );
		},
		(string) $content
	);
}
add_filter( 'the_content', 's421_remove_strong_from_headings' );

/**
 * Safe getter for nested ACF fields.
 * Usage: s421_acf_safe( $page, 'hero.title' )
 */
function s421_acf_safe( $array, string $path, $default = '' ) {
	if ( ! is_array( $array ) ) {
		return $default;
	}

	$value = $array;
	foreach ( explode( '.', $path ) as $key ) {
		if ( is_array( $value ) && array_key_exists( $key, $value ) ) {
			$value = $value[ $key ];
		} else {
			return $default;
		}
	}

	return $value;
}

// =========================
// ACF DEFAULTS
// =========================

/**
 * Default rows for the Experience numbered list (ACF repeaters have no default value).
 */
function s421_experience_default_items(): array {
	return array(
		'Sound travels.',
		'THROUGH AIR.',
		'THROUGH ARCHITECTURE.',
		'THROUGH YOU.',
		'IT CREATES TENSION.',
		'RELEASE.',
		'TRIGGERS EMOTION.',
		'CHANGES YOUR STATE.',
		'UNTIL LISTENING, BECOMES FEELING.',
		'AND YOU ARE PART OF THE SOUND.',
	);
}

/**
 * Prefill the Experience repeater with the default rows until it is saved for the first time.
 * Applies to both the editor and the front end. Once saved (even empty), the stored value wins.
 */
function s421_experience_items_defaults( $value, $post_id, array $field ) {
	if ( ! empty( $value ) || ! is_numeric( $post_id ) ) {
		return $value;
	}

	// The repeater lives inside the "experience" group, so its meta key is "experience_items".
	if ( metadata_exists( 'post', (int) $post_id, 'experience_items' ) ) {
		return $value;
	}

	return array_map(
		static fn( string $text ): array => array( 'field_s421_experience_item_text' => $text ),
		s421_experience_default_items()
	);
}
add_filter( 'acf/load_value/key=field_s421_experience_items', 's421_experience_items_defaults', 20, 3 );

// =========================
// BODY CLASSES
// =========================

/**
 * Add a body class to pages with a partially transparent header.
 */
function s421_body_classes( array $classes ): array {
	// TODO: add the templates that need a header with transparent background only
	// (e.g. page-example.php).
	$partial_toppage = array(
		// 'page-example.php',
	);

	foreach ( $partial_toppage as $template ) {
		if ( is_page_template( $template ) ) {
			$classes[] = 'toppage-bg-only';
		}
	}

	return $classes;
}
add_filter( 'body_class', 's421_body_classes' );

// =========================
// MOBILE MENU TOGGLE
// =========================
function s421_header_scripts(): void {
	?>
<script>
document.addEventListener("DOMContentLoaded", function () {
	const toggleBtn = document.querySelector('.menu-toggle');
	const menu      = document.querySelector('.menu-list.showmob');
	if (!toggleBtn || !menu) return;

	const setOpen = (open) => {
		menu.classList.toggle('active', open);
		toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
		toggleBtn.setAttribute('aria-label', open ? <?php echo wp_json_encode( __( 'Cerrar menú', 's421' ) ); ?> : <?php echo wp_json_encode( __( 'Abrir menú', 's421' ) ); ?>);
	};

	toggleBtn.addEventListener('click', () => setOpen(!menu.classList.contains('active')));

	// One-page anchors: close the menu after picking a link.
	menu.querySelectorAll('a').forEach(link => link.addEventListener('click', () => setOpen(false)));
});
</script>
	<?php
}
add_action( 'wp_footer', 's421_header_scripts' );

// =========================
// SVG SUPPORT
// =========================
function s421_allow_svg( array $mimes ): array {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}
add_filter( 'upload_mimes', 's421_allow_svg' );

function s421_fix_svg_mime( $data, $file, $filename, $mimes ) {
	if ( 'svg' === strtolower( pathinfo( (string) $filename, PATHINFO_EXTENSION ) ) ) {
		$data['type'] = 'image/svg+xml';
		$data['ext']  = 'svg';
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 's421_fix_svg_mime', 10, 4 );
