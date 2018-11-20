<?php

/**
 * Single portfolio content template
 * @package vamtam/nex
 */

global $content_width;

$client = get_post_meta( get_the_id(), 'portfolio-client', true );

$client = preg_replace( '@</\s*([^>]+)\s*>@', '</$1>', $client );

$content = get_the_content();

$portfolio_options = vamtam_get_portfolio_options();
if ( 'gallery' === $portfolio_options['type'] ) {
	list( $gallery, $content ) = VamtamPostFormats::get_first_gallery( $content, null, 'single-portfolio' );
}

VamtamPostFormats::block_gallery_beaver();
$content = apply_filters( 'the_content', $content );
VamtamPostFormats::enable_gallery_beaver();

$project_types = get_the_terms( get_the_id(), Jetpack_Portfolio::CUSTOM_TAXONOMY_TYPE );
$project_tags  = get_the_terms( get_the_id(), Jetpack_Portfolio::CUSTOM_TAXONOMY_TAG );

?>

<?php if ( 'document' !== $type ) : ?>
	<div class="clearfix limit-wrapper vamtam-box-outer-padding">
		<div class="portfolio-image-wrapper fullwidth-folio">
			<?php
				$logo = get_post_meta( get_the_id(), 'portfolio-logo',   true );

				if ( 'gallery' === $type ) :
					echo do_shortcode( $gallery );
				elseif ( 'video' === $type ) :
					global $wp_embed;
					echo do_shortcode( $wp_embed->run_shortcode( '[embed width="' . esc_attr( $content_width ) . '"]' . $href . '[/embed]' ) );
				elseif ( 'html' === $type ) :
					echo do_shortcode( get_post_meta( get_the_ID(), 'portfolio-top-html', true ) );
				else :
					the_post_thumbnail( VAMTAM_THUMBNAIL_PREFIX . 'single' );
				endif;
			?>


		</div>
	</div>
<?php endif ?>



<div class="portfolio-text-content">
	<div class="row portfolio-content">
		<div class="project-meta">

			<?php if ( ! empty( $logo ) ) : ?>
				<div class="client-logo">
					<span style="background-image: url(<?php echo esc_url( $logo ) ?>" alt="<?php the_title_attribute() ?>)" ></span>
				</div>
			<?php endif ?>

			<?php if ( ! empty( $project_types ) && ! is_wp_error( $project_types ) ) : ?>
					<p class="meta posted_in">
						<?php echo wp_kses_post( implode( ' ', VamtamTemplates::project_tax( Jetpack_Portfolio::CUSTOM_TAXONOMY_TYPE ) ) ) ?>
					</p>
			<?php endif ?>

			<div class="meta-top clearfix">
				<span class="post-date vamtam-meta-date"><?php the_date() ?></span>
				 –
				<?php if ( ! empty( $client ) ) : ?>
					<span class="client-name">
						<?php echo wp_kses_post( $client ) ?>
					</span>
				<?php endif ?>
			</div>
		</div>

		<div class="project-main-content">
			<?php echo $content; // xss ok ?>

			<?php if ( ! empty( $project_tags ) && ! is_wp_error( $project_tags ) ) : ?>
				<div class="meta tagged_as"><span class="icon theme"><?php vamtam_icon( 'vamtam-theme-tag3' ); ?></span><?php echo wp_kses_post( implode( ' ', VamtamTemplates::project_tax( Jetpack_Portfolio::CUSTOM_TAXONOMY_TAG ) ) ) ?></div>
			<?php endif ?>

			<?php get_template_part( 'templates/share' ); ?>
		</div>
	</div>
</div>
