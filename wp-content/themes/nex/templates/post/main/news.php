<?php if ( $show_media ) :  ?>
	<div class="post-media">
		<?php if ( isset( $post_data['media'] ) ) :  ?>
			<div class="thumbnail">
				<?php if ( has_post_format( 'image' ) || ( isset( $post_data['act_as_image'] ) && $post_data['act_as_image'] ) ) :  ?>
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute()?>">
						<?php echo $post_data['media']; // xss ok ?>
						<?php echo vamtam_get_icon_html( array( // xss ok
							'name' => 'vamtam-theme-circle-post',
						) ); ?>
					</a>
				<?php else : ?>
					<?php echo $post_data['media']; // xss ok ?>
				<?php endif ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif ?>

<?php if ( $show_content || $show_title ) :  ?>
	<div class="post-content-wrapper">
		<?php
			$show_tax = rd_vamtam_get_optionb( 'post-meta', 'tax' ) && ( ! post_password_required() || is_customize_preview() );
			$tags     = get_the_tags();
		?>

		<?php if ( $show_tax || is_customize_preview() ) : ?>
			<div class="post-content-meta">
				<div class="vamtam-meta-tax the-categories" <?php VamtamTemplates::display_none( $show_tax ) ?>><span class="icon theme"><?php vamtam_icon( 'vamtam-theme-layers' ); ?></span> <span class="visuallyhidden"><?php esc_html_e( 'Category', 'nex' ) ?> </span><?php the_category( ' ' ); ?></div>
			</div>
		<?php endif ?>

		<?php if ( $show_title ) : ?>
			<?php include locate_template( 'templates/post/header.php' ); ?>
		<?php endif ?>

		<?php get_template_part( 'templates/post/main/actions' ) ?>

		<?php if ( $show_content ) : ?>
			<div class="post-content-outer">
				<?php echo $post_data['content']; // xss ok ?>
			</div>
		<?php endif ?>

		<?php if ( ( $show_tax || is_customize_preview() ) && !!$tags ) : ?>
			<div class="post-content-meta">
				<div class="the-tags vamtam-meta-tax" <?php VamtamTemplates::display_none( $show_tax ) ?>>
					<?php the_tags( '<span class="icon">' . vamtam_get_icon( 'tag' ) . '</span> <span class="visuallyhidden">' . esc_html__( 'Tags', 'nex' ) . '</span> ', ', ', '' ); ?>
				</div>
			</div>
		<?php endif ?>

		<div class="vamtam-button-wrap vamtam-button-width-auto vamtam-button-left">
			<a href="<?php the_permalink() ?>" target="_self" class="vamtam-button accent3 hover-accent1 button-underline" role="button">
				<span class="vamtam-button-text"><?php esc_html_e( 'Read More', 'nex' ) ?></span>
			</a>
		</div>



	</div>
<?php endif; ?>
