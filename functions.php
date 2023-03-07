<?php
/**
 * De Nieuwe Garde functions and definitions
 */

/* ### HOOK IT UP ########################################################## */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @return void
 */
add_action( 'after_setup_theme', function() {

	// Add support for block styles.
	add_theme_support( 'wp-block-styles' );

	// Enqueue editor styles.
	add_editor_style( 'style.css' );

	// Enqueue scripts and styles to frontend
	add_action( 'wp_enqueue_scripts', 'dng_add_frontend_styles_and_scripts' );

	// Enqueue scripts and styles to the editor
	add_action( 'enqueue_block_editor_assets', 'dng_add_editor_styles_and_scripts' );

} );


/* ### DEFINE FUNCTIONS ##################################################### */

/**
 * Enqueue styles.
 *
 * @return void
 */
function dng_add_frontend_styles_and_scripts() {

	// Register theme stylesheet.
	$theme_version = wp_get_theme()->get( 'Version' );

	$version_string = is_string( $theme_version ) ? $theme_version : false;
	wp_register_style(
		'dng-style',
		get_template_directory_uri() . '/style.css',
		array(),
		$version_string
	);

	// Enqueue theme stylesheet.
	wp_enqueue_style( 'dng-style' );
}


/**
 * Add scripts and styles (editor)
 */
function dng_add_editor_styles_and_scripts() {

	// Register theme stylesheet.
	$theme_version = wp_get_theme()->get( 'Version' );

	$version_string = is_string( $theme_version ) ? $theme_version : false;
	wp_register_style(
		'dng-style-for-editor',
		get_template_directory_uri() . '/style-for-editor.css',
		array(),
		$version_string
	);

	// Enqueue theme stylesheet.
	wp_enqueue_style( 'dng-style-for-editor' );
}


function dng_get_svg( $name = '' ) {

	$svg = '';

	if ($name) {
		
		$context = null; 

		/**
		 * Skip SSL check on local development due to SSL error
		 * 
		 * @link https://stackoverflow.com/questions/26148701/file-get-contents-ssl-operation-failed-with-code-1-failed-to-enable-crypto#26151993
		 */
		if ( wp_get_environment_type() == 'local' ) {

			$contextOptions = array(
			    "ssl" => array(
			        "verify_peer" => false,
			        "verify_peer_name" => false,
			    )
			);

			$context = stream_context_create( $contextOptions );
		}

		$svg = file_get_contents( get_stylesheet_directory() . "/assets/svg/{$name}.svg", false, $context );
		$svg = ($svg) ? $svg : '';
	}

	return $svg;
}
