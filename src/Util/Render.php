<?php

namespace Flanny\PLB\Util;

/**
 * Class Render
 *
 * @package Flanny\PLB\Util
 */
class Render {

	/**
	 * @var \WP_Query $query
	 */
	private $query;

	/**
	 * @param array $attributes
	 *
	 * @return string
	 * @gutenberg <ServerSideRender block=flanny/post-loop-block />
	 */
	public function render( array $attributes ) : string {
		if ( ! isset( $attributes[ Register::NUM_POSTS_ATT ], $attributes[ Register::NUM_PAGE_ATT ] ) ) {
			return '';
		}

		return $this->get_posts_display( $attributes[ Register::NUM_POSTS_ATT ], $attributes[ Register::NUM_POSTS_ATT ] );
	}

	/**
	 * @param int $per_page
	 * @param int $page
	 *
	 * @return string
	 */
	private function get_posts_display( int $per_page, int $page ) : string {
		$query = $this->get_query( $per_page, $page );
		$posts = $query->get_posts();
		ob_start();
		foreach ( $posts as $post ) {
			include sprintf( '%s/assets/templates/post.php', FLANNY_PLB_PATH );
		}

		return ob_get_clean();
	}

	/**
	 * @param int $per_page
	 * @param int $page
	 *
	 * @return \WP_Query
	 */
	public function get_query( $per_page = -1, $page = 1 ) {
		return new \WP_Query( [
			'post_type' => [ 'post' ],
			'post_status' => 'publish',
			'posts_per_page' => $per_page,
			'paged' => $page,
		] );
	}

}
