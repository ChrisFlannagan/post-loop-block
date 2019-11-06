<?php
/**
 * Plugin Name: Post Loop Block
 * Description: A WP Gutenberg block for display user defined amount of posts.
 * Author: MrFlannagan
 * Author URI: https://whoischris.com
 * Version: 1.0
 */

define( 'FLANNY_PLB_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'FLANNY_PLB_PATH', untrailingslashit( __DIR__ ) );
define( 'FLANNY_PLB_VER', '1.0' );

require_once sprintf( '%s/vendor/autoload.php', FLANNY_PLB_PATH );
add_action( 'plugins_loaded', function() {
	\Flanny\PLB\Core::instance();
} );
