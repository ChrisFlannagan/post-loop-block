<?php

namespace Flanny\PLB\Util;

class Register {

	const BLOCK_NAME = 'flanny/post-loop-block';
	const JS_HANDLE = 'flanny-post-loop-block';

	public static function hook() {
		add_action( 'init', [ self::class, 'register' ] );
	}

	public static function register() {
		$url = sprintf( '%s/assets/dist/js/post-loop-block.js', FLANNY_PLB_URL );
		wp_register_script(
			self::JS_HANDLE,
			$url,
			[ 'wp-blocks', 'wp-element' ],
			FLANNY_PLB_VER
		);

		register_block_type( self::BLOCK_NAME, [ 'editor_script' => self::JS_HANDLE ] );
	}

}
