<?php
/**
 * Template: Post
 *
 * @var WP_Post $post
 */
?>

<div class="flanny-plb-post">
	<a href="<?php esc_attr_e( get_the_permalink( $post->ID ) ); ?>"
	   class="title"
	   aria-label="<?php esc_html_e( $post->post_title ); ?>">
		<h3><?php esc_html_e( $post->post_title ); ?></h3>
	</a>
	<div class="byline">
		<span>
			<?php printf( __( 'By: <a href="%s">%s</a> - %s', 'flanny-plb' ),
				get_author_posts_url( $post->post_author ),
				get_the_author_meta( 'display_name', $post->post_author ),
				(string) date( 'm/d/Y', strtotime( $post->post_date ) ) ); ?>
		</span>
	</div>
	<div class="excerpt">
		<?php esc_html_e( get_the_excerpt( $post->ID ) ); ?>
	</div>
</div>
