<?php
/**
 * Comments template
 *
 * @package vamtam/nex
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Please do not load this page directly. Thanks!' );
}

?>

<div class="limit-wrapper vamtam-box-outer-padding">
<?php if ( 'open' === $post->comment_status ) : ?>
	<div id="comments">
		<div class="respond-box">
			<?php if ( get_option( 'comment_registration' ) && ! $user_ID ) : ?>
				<p id="login-req"><?php printf( wp_kses_post( __( 'You must be <a href="%s" title="Log in">logged in</a> to post in the Guestbook.', 'nex' ) ), esc_url( get_option( 'siteurl' ) . '/wp-login.php?redirect_to=' . get_permalink() ) ) ?></p>
			<?php else : ?>
				<?php
					$req = get_option( 'require_name_email' );
					comment_form( array(
						'title_reply'    => '',
						'title_reply_to' => '',
						'fields'         => array(
								'author' => '<div class="row"><div class="comment-form-author form-input grid-1-2"><label for="author" class="visuallyhidden">' . esc_html__( 'Name:', 'nex' ) . '</label>' . ( $req ? ' <span class="required">*</span>' : '' ) .
								'<input id="author" autocomplete="name" name="author" type="text" ' . ( $req ? 'required="required"' : '' ) . ' value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="' . esc_attr__( 'John Doe', 'nex' ) . '" /></div>',
								'email'  => '<div class="comment-form-email form-input grid-1-2"><label for="email" class="visuallyhidden">' . esc_html__( 'Email:', 'nex' ) . '</label> ' . ( $req ? ' <span class="required">*</span>' : '' ) . '<span class="comment-note">' . esc_html__( 'Your email address will not be published.', 'nex' ) . '</span>
								<input id="email" autocomplete="email" name="email" type="email" ' . ( $req ? 'required="required"' : '' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" placeholder="email@example.com" /></div></div>',
						),
						'comment_field'        => '<div class="comment-form-comment grid-1-1"><label for="comment" class="visuallyhidden">' . esc_html__( 'Message:', 'nex' ) . '</label><textarea id="comment" name="comment" required placeholder="' . esc_attr__( 'Write us something nice or just a funny joke...', 'nex' ) . '" rows="2"></textarea></div>',
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'label_submit'         => esc_html__( 'Add message', 'nex' ),
						'format'               => 'xhtml', // otherwise we get novalidate on the form
					) );
				?>

			<?php endif /* if ( get_option( 'comment_registration' ) && !$user_ID ) */ ?>
		</div><!-- .respond-box -->

		<?php
			$req = get_option( 'require_name_email' ); // Checks if fields are required.

			if ( ! empty( $post->post_password ) ) :
				if ( post_password_required() ) :
		?>
					</div><!-- #comments -->

	<?php
					return;
				endif;
			endif;
	?>

	<?php if ( have_comments() ) : ?>
		<?php // numbers of pings and comments
		$ping_count = $comment_count = 0;
		foreach ( $comments as $comment ) {
			get_comment_type() == 'comment' ? ++$comment_count : ++$ping_count;
		}
		?>

		<h5 class="comments-title"><?php comments_popup_link( wp_kses_post( __( '0 <span class="comment-word">People wrote to us:</span>', 'nex' ) ), wp_kses_post( __( '1 <span class="comment-word">Person wrote to us:</span>', 'nex' ) ), wp_kses_post( __( '% <span class="comment-word">People wrote to us:</span>', 'nex' ) ) ); ?></h5>

		<?php if ( $comment_count ) : ?>
			<?php
				$cube_options = array(
					'layoutMode'        => 'grid',
					'sortToPreventGaps' => true,
					'defaultFilter'     => '*',
					'animationType'     => 'quicksand',
					'gapHorizontal'     => 30,
					'gapVertical'       => 30,
					'gridAdjustment'    => 'responsive',
					'mediaQueries'      => VamtamTemplates::scrollable_columns( 3 ),
					'displayType'       => 'bottomToTop',
					'displayTypeSpeed'  => 100,
				);

				wp_enqueue_script( 'cubeportfolio' );
				wp_enqueue_style( 'cubeportfolio' );
			?>
			<div id="comments-list" class="comments vamtam-comments-small vamtam-cubeportfolio cbp" data-columns="3" data-options="<?php echo esc_attr( json_encode( $cube_options ) ) ?>">
				<?php
					wp_list_comments( array(
						'avatar_size'       => 0,
						'type'              => 'comment',
						'reply_allowed'     => false,
						'max_depth'         => 0,
						'vamtam-layout'     => 'small',
						'callback'          => array( 'VamtamTemplates', 'comments' ),
						'reverse_top_level' => true,
						'reverse_children'  => true,
						'style'             => 'div',
					) );
				?>
			</div><!-- #comments-list.comments -->
		<?php endif; /* if ( $comment_count ) */ ?>
	<?php endif /* if ( $comments ) */ ?>

	<?php
		$comment_pages = paginate_comments_links( array(
			'echo' => false,
		) );

		if ( ! empty( $comment_pages ) ) :
	?>
		<div class="wp-pagenavi comment-paging"><?php echo $comment_pages // xss ok ?></div>
	<?php endif ?>
</div><!-- #comments -->

<?php endif /* if ( 'open' == $post->comment_status ) */ ?>
</div>
