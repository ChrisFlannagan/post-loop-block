<?php

namespace Flanny\PLB\Util;

/**
 * Class Rest_Api
 *
 * @package Flanny\PLB\Util
 */
class Rest_Api {

	const AUTHOR_LINK = 'plb_author_link';
	const FORMATTED_DATE = 'plb_formatted_date';

	const CACHE_KEY = 'flanny_plb_api_cache';

	/**
	 * Hook our rest api injection and cache flush listener
	 */
	public static function hook() {
		add_filter( 'rest_prepare_post', [ self::class, 'add_author_and_format_date' ], 10, 2 );
		add_action( 'save_post', [ self::class ], 'flush_cache', 10, 1 );
	}

	/**
	 * @param \WP_Rest_Response $response
	 * @param \WP_Post $post
	 *
	 * @return \WP_Rest_Response
	 * @filter rest_prepare_post
	 *
	 * We need to pass some formatted meta to our javascript that's not available by default in the rest response for posts
	 */
	public static function add_author_and_format_date( \WP_Rest_Response $response, \WP_Post $post ) : \WP_Rest_Response {
		$new_data = self::get_author_and_formatted_date( $post );

		$data = $response->get_data();
		$data[ self::AUTHOR_LINK ] = $new_data[ self::AUTHOR_LINK ];
		$data[ self::FORMATTED_DATE ] = $new_data[ self::FORMATTED_DATE ];
		$response->set_data( $data );

		return $response;
	}

	/**
	 * @param \WP_Post $post
	 *
	 * @return array
	 */
	public static function get_author_and_formatted_date( \WP_Post $post ) : array {
		$cached = wp_cache_get( sprintf( '%s-%d', self::CACHE_KEY, $post->ID ) );
		if ( ! empty( $cached ) ) {
			return $cached;
		}

		$data = [
			self::AUTHOR_LINK => sprintf( '<a href="%s">%s</a>',
				esc_url( get_author_posts_url( $post->post_author ) ),
				esc_html( get_the_author_meta( 'display_name', $post->post_author ) ) ),
			self::FORMATTED_DATE => esc_html( get_the_date( '', $post ) ),
		];

		wp_cache_set( sprintf( '%s-%d', self::CACHE_KEY, $post->ID ), $data );
		return $data;
	}

	/**
	 * @param int $post_id
	 * @action save_post
	 */
	public static function flush_cache( int $post_id ) {
		wp_cache_delete(  sprintf( '%s-%d', self::CACHE_KEY, $post_id ) );
	}

}
