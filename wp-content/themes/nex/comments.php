<?php
/**
 * Comments template
 *
 * @package vamtam/nex
 */

if ( is_page_template( 'page-blank.php' ) ) {
	return;
}

wp_reset_postdata();

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Please do not load this page directly. Thanks!' );
}

$req = get_option( 'require_name_email' ); // Checks if fields are required.

// do not display anything if the post is protected or the comments are closed and there is no comment history
if (
	( ! empty( $post->post_password ) && post_password_required() ) ||
	( ! comments_open() && ! have_comments() ) ||
	! post_type_supports( get_post_type(), 'comments' ) ) {
	return;
}

?>
<div class="limit-wrapper clearboth">
	<div id="comments" class="comments-wrapper">
		<?php if ( have_comments() ) : ?>
			<?php // numbers of pings and comments
			$ping_count = $comment_count = 0;
			foreach ( $comments as $comment ) {
				get_comment_type() == 'comment' ? ++$comment_count : ++$ping_count;
			}
			?>

			<div class="sep-text centered keep-always">
				<div class="content">
					<?php comments_popup_link( esc_html__( '0 Comments:', 'nex' ), esc_html__( '1 Comment', 'nex' ), esc_html__( '% Comments:', 'nex' ) ); ?>
				</div>
			</div>

			<?php if ( $comment_count ) : ?>
				<div id="comments-list" class="comments">
					<?php wp_list_comments( array(
						'type'     => 'comment',
						'callback' => array( 'VamtamTemplates', 'comments' ),
						'style'    => 'div',
					) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $ping_count ) : ?>
				<div class="sep-text centered keep-always">
					<div class="content">
						<?php echo sprintf( $ping_count > 1 ? esc_html__( '%d Trackbacks:', 'nex' ) : esc_html__( 'One Trackback:', 'nex' ), (int) (int) $ping_count );  // xss ok ?>
					</div>
				</div>
				<div id="trackbacks-list" class="comments">
					<?php wp_list_comments( array(
						'type'       => 'pings',
						'callback'   => array( 'VamtamTemplates', 'comments' ),
						'style'      => 'div',
						'short_ping' => true,
					) ); ?>
				</div>
			<?php endif ?>
		<?php endif ?>

		<?php
			$comment_pages = paginate_comments_links( array(
				'echo' => false,
			) );

			if ( ! empty( $comment_pages ) ) :
		?>
			<div class="wp-pagenavi comment-paging"><?php echo $comment_pages // xss ok ?></div>
		<?php endif ?>

		<div class="respond-box">
			<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'nex' ); ?></p>
			<?php endif; ?>
			<?php if ( get_option( 'comment_registration' ) && ! $user_ID ) : ?>
				<p id="login-req"><?php printf( wp_kses_post( __( 'You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'nex' ) ), esc_url( get_option( 'siteurl' ) . '/wp-login.php?redirect_to=' . get_permalink() ) ) ?></p>
			<?php else : ?>
				<?php
					comment_form( array(
						'title_reply_before' => '<h5 id="reply-title" class="comment-reply-title respond-box-title grid-1-1">',
						'title_reply_after'  => '</h5>',
						'title_reply'    =>  esc_html__( 'Write a comment:', 'nex' ),
						'fields'         => array(
								'author' => '<div class="comment-form-author form-input grid-1-1"><label for="author" >' . esc_html__( 'Name', 'nex' ) . '</label>' . ( $req ? ' <span class="required">*</span>' : '' ) .
								'<input id="author" autocomplete="name" name="author" type="text" ' . ( $req ? 'required="required"' : '' ) . ' value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="' . esc_attr__( 'John Doe', 'nex' ) . '" /></div>',
								'email'  => '<div class="comment-form-email form-input grid-1-1"><label for="email" >' . esc_html__( 'Email', 'nex' ) . '</label> ' . ( $req ? ' <span class="required">*</span>' : '' ) .
								'<input id="email" autocomplete="email" name="email" type="email" ' . ( $req ? 'required="required"' : '' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" placeholder="email@example.com" /></div> <p class="comment-notes grid-1-1">' . esc_html__( 'Your email address will not be published.', 'nex' ) . '</p>',
						),
						'comment_field'        => '<div class="comment-form-comment grid-1-1"><label for="comment" class="visuallyhidden">' . esc_html_x( 'Message', 'noun', 'nex' ) . '</label><textarea id="comment" name="comment" required placeholder="' . esc_attr__( 'Write us something nice or just a funny joke...', 'nex' ) . '" rows="2"></textarea></div>',
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'format'               => 'xhtml', // otherwise we get novalidate on the form
					) );
				?>

			<?php endif /* if ( get_option( 'comment_registration' ) && !$user_ID ) */ ?>
		</div><!-- .respond-box -->
	</div><!-- #comments -->
</div>
