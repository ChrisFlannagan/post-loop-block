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

		return $this->get_posts_display( $attributes[ Register::NUM_POSTS_ATT ], $attributes[ Register::NUM_PAGE_ATT ] );
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
		printf( '<div data-js="%s" data-per-page="%d" data-page="%d" data-total-pages="%d">', Register::BLOCK_JS, $per_page, $page, $query->max_num_pages);
		printf( '<div class="posts">' );
		foreach ( $posts as $post ) {
			include sprintf( '%s/assets/templates/post.php', FLANNY_PLB_PATH );
		}
		echo '</div>';

		// If front end we need to include buttons html
		if ( ! isset( $_REQUEST['context'] ) || $_REQUEST['context'] !== 'edit' ) {
			include sprintf( '%s/assets/templates/buttons.php', FLANNY_PLB_PATH );
		}
		echo '</div>';

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
			'post__not_in' => [ get_the_ID() ], // let's never show a post on it's own page
			'paged' => $page,
		] );
	}

}
