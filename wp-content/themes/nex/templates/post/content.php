<?php
/**
 * Post content template
 *
 * @package vamtam/nex
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$page_links = VamtamTemplates::custom_link_pages( array(
	'before' => '<div class="wp-pagenavi"><span class="visuallyhidden">' . esc_html__( 'Pages:', 'nex' ) . '</span>',
	'after'  => '</div>',
	'echo'   => false,
) );

if ( empty( $post_data['content'] ) && isset( $post_data['media'] ) && empty( $page_links ) ) return;

?>
<div class="post-content the-content">
	<?php
		do_action( 'vamtam_before_post_content' );

		if ( ! empty( $post_data['content'] ) ) {
			echo $post_data['content']; // xss ok
		}

		do_action( 'vamtam_after_post_content' );

		echo $page_links; // xss ok
	?>
</div>
