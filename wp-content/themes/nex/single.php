<?php
/**
 * Single post template
 *
 * @package vamtam/nex
 */

get_header();

?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>

		<div class="row page-wrapper">
			<?php VamtamTemplates::$in_page_wrapper = true; ?>

			<article <?php post_class( 'single-post-wrapper ' . VamtamTemplates::get_layout() )?>>
				<div class="page-content loop-wrapper clearfix full">
					<?php get_template_part( 'templates/post' ); ?>

					<?php comments_template(); ?>
				</div>
			</article>

			<?php get_template_part( 'sidebar' ) ?>
		</div>

		<?php if ( ( rd_vamtam_get_optionb( 'show-related-posts' ) || is_customize_preview() ) && is_singular( 'post' ) && class_exists( 'VamtamBlogModule' ) ) : ?>
			<?php if ( ! class_exists( 'Vamtam_Elements_B' ) || Vamtam_Elements_B::had_limit_wrapper() ) :  ?>
				</div>
			<?php endif ?>
			<?php
				$terms = array();
				$cats  = get_the_category();
				foreach ( $cats as $cat ) {
					$terms[] = $cat->term_id;
				}

				$related_query = new WP_Query( array(
					'post_type'      => 'post',
					'category__in'   => $terms,
					'post__not_in'   => array( get_the_ID() ),
					'posts_per_page' => 1,
				) );

				if ( intval( $related_query->found_posts ) > 0 ) :
			?>
					<div class="related-posts row vamtam-related-content" <?php VamtamTemplates::display_none( rd_vamtam_get_optionb( 'show-related-posts' ) ) ?>>
						<div class="clearfix limit-wrapper vamtam-box-outer-padding">
							<div class="grid-1-1">
								<?php echo wp_kses_post( apply_filters( 'vamtam_related_posts_title', '<h5 class="related-content-title">' . rd_vamtam_get_option( 'related-posts-title' ) . '</h5>' ) ); ?>
								<?php
									FLBuilder::render_module_html( 'vamtam-blog', array(
										'count'               => 8,
										'columns'             => 4,
										'tax_post_category'   => implode( ',', $terms ),
										'layout'              => 'scroll-x',
										'show_title'          => true,
										'show_content'        => true,
										'posts_post'          => get_the_ID(),
										'posts_post_matching' => 0,
										'gap'                 => 'true',
									) );
								?>
							</div>
						</div>
					</div>
			<?php endif ?>
			<?php if ( ! class_exists( 'Vamtam_Elements_B' ) || Vamtam_Elements_B::had_limit_wrapper() ) :  ?>
				<div class="limit-wrapper">
			<?php endif ?>
		<?php endif ?>
	<?php endwhile;
endif;

get_footer();
