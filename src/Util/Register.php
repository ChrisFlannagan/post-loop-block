<?php

namespace Flanny\PLB\Util;

use Flanny\PLB\Core;

/**
 * Class Register
 *
 * @package Flanny\PLB\Util
 */
class Register {

	const BLOCK_NAME   = 'flanny/post-loop-block';
	const BLOCK_JS     = 'flanny-post-loop-block';
	const JS_HANDLE    = 'flanny-post-loop-block-js';
	const JS_HANDLE_FE = 'flanny-post-loop-block-fe-js';
	const CSS_HANDLE   = 'flanny-post-loop-block-css';

	const NUM_POSTS_ATT = 'numberPosts';
	const NUM_PAGE_ATT  = 'page';
	const DEFAULT_NUM   = 3;

	/**
	 * Register all hooks
	 */
	public static function hook() {
		add_action( 'init', [ self::class, 'register' ] );
		add_action( 'wp_enqueue_scripts', [ self::class, 'frontend' ] );
	}

	/**
	 * Register our block and required styles/scripts for editor
	 */
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

	/**
	 * Register needed assets for the front end only
	 */
	public static function frontend() {
		if ( ! has_block( self::BLOCK_NAME ) ) {
			return;
		}

		$js_url         = sprintf( '%s/assets/frontend/ajax.js', FLANNY_PLB_URL );
		wp_register_script( self::JS_HANDLE_FE, $js_url, [], FLANNY_PLB_VER );
		wp_localize_script( self::JS_HANDLE_FE, 'FlannyPostLoopBlock', [
			'blockJs'  => self::BLOCK_JS,
		] );
		wp_enqueue_script( self::JS_HANDLE_FE );
	}

}
