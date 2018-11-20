<?php
/**
 * Single page template
 *
 * @package vamtam/nex
 */

get_header();
?>

<?php if ( have_posts() ) : the_post(); ?>
	<div class="row page-wrapper">
		<?php VamtamTemplates::$in_page_wrapper = true; ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( VamtamTemplates::get_layout() ); ?>>
			<div class="page-content">
				<?php
					the_content();

					VamtamTemplates::custom_link_pages( array(
						'before' => '<div class="wp-pagenavi"><span class="visuallyhidden">' . esc_html__( 'Pages:', 'nex' ) . '</span>',
						'after'  => '</div>',
					) );
				?>
				<?php get_template_part( 'templates/share' ); ?>
			</div>

			<?php comments_template( '', true ); ?>
		</article>

		<?php get_template_part( 'sidebar' ) ?>

	</div>
<?php endif;

get_footer();
