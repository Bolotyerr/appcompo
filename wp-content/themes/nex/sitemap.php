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
			<?php
				global $vamtam_has_header_sidebars;
				if ( $vamtam_has_header_sidebars ) {
					VamtamTemplates::header_sidebars();
				}
			?>
			<div class="page-content">
				<?php do_action( 'vamtam-display-sitemap' ) ?>
				<?php the_content(); ?>
				<?php wp_link_pages( array(
					'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'nex' ),
					'after' => '</div>',
				) ); ?>
				<?php get_template_part( 'templates/share' ); ?>
			</div>

			<?php comments_template( '', true ); ?>
		</article>

		<?php get_template_part( 'sidebar' ) ?>

	</div>
<?php endif;

get_footer();
