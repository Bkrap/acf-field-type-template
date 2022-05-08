function plugin_theme_enqueue_styles() {
	$the_theme = wp_get_theme();
	wp_enqueue_style( 'custom-theme-styles', get_stylesheet_directory_uri() . '/assets/css/style.min.css', array(), $the_theme->get( 'Version' ) );
}

add_action( 'wp_enqueue_scripts', 'plugin_theme_enqueue_styles' );