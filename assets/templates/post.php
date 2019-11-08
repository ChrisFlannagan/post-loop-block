<?php
/**
 * Template: Post
 *
 * @var WP_Post $post
 */
?>

<article class="flanny-plb-post post type-post status-publish format-standard entry">
	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php esc_attr_e( get_the_permalink( $post->ID ) ); ?>"
			   class="title"
			   rel="bookmark"
			   aria-label="<?php esc_html_e( $post->post_title ); ?>">
				<?php esc_html_e( $post->post_title ); ?>
			</a>
		</h2>
		<span class="byline">
			<?php printf( __( 'By: <a href="%s">%s</a> - %s', 'flanny-plb' ),
				esc_url( get_author_posts_url( $post->post_author ) ),
				esc_html( get_the_author_meta( 'display_name', $post->post_author ) ),
				esc_html( get_the_date( '', $post ) ) ); ?>
		</span>
	</header>
	<div class="entry-excerpt">
		<?php esc_html_e( get_the_excerpt( $post->ID ) ); ?>
	</div>
</article>
