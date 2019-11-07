<?php

namespace Flanny\PLB\Util;

use Flanny\PLB\Core;

class Register {

	const BLOCK_NAME = 'flanny/post-loop-block';
	const JS_HANDLE  = 'flanny-post-loop-block-js';
	const CSS_HANDLE = 'flanny-post-loop-block-css';

	const NUM_POSTS_ATT = 'numberPosts';
	const NUM_PAGE_ATT  = 'page';
	const NUM_TOTAL_ATT = 'totalPages';
	const DEFAULT_NUM   = 3;

	public static function hook() {
		add_action( 'init', [ self::class, 'register' ] );
	}

	public static function register() {
		$js_url         = sprintf( '%s/assets/dist/js/post-loop-block.js', FLANNY_PLB_URL );
		$css_editor_url = sprintf( '%s/assets/css/post-loop-block.css', FLANNY_PLB_URL );

		// Register our blocks script with its handle
		wp_register_script(
			self::JS_HANDLE,
			$js_url,
			[ 'wp-blocks', 'wp-editor', 'wp-components', 'wp-block-editor', 'wp-i18n' ],
			FLANNY_PLB_VER
		);

		// Let's pass some vars down into the js world here
		$query = Core::instance()->render->get_query();
		wp_localize_script( self::JS_HANDLE, 'FlannyPostLoopBlock', [
			'blockName'  => self::BLOCK_NAME,
			'defaultNum' => self::DEFAULT_NUM,
			'totalPages' => $query->found_posts,
		] );

		// Register style sheet for the in admin editor
		wp_register_style( self::CSS_HANDLE, $css_editor_url, [], FLANNY_PLB_VER );

		// Lastly register our post loop block
		register_block_type( self::BLOCK_NAME, [
			'style'           => self::CSS_HANDLE,
			'editor_script'   => self::JS_HANDLE,
			'render_callback' => [ Core::instance()->render, 'render' ],
			'attributes'      => [
				self::NUM_POSTS_ATT => [
					'type'    => 'number',
					'default' => self::DEFAULT_NUM,
				],
				self::NUM_PAGE_ATT  => [
					'type'    => 'number',
					'default' => 1,
				],
			],
		] );
	}

}
