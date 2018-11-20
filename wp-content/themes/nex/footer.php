<?php
/**
 * Footer template
 *
 * @package vamtam/nex
 */

$footer_onepage = ( ! is_page_template( 'onepage.php' ) || rd_vamtam_get_optionb( 'one-page-footer' ) );

$beaver_footer_ids  = class_exists( 'FLThemeBuilderLayoutData' ) ? FLThemeBuilderLayoutData::get_current_page_footer_ids() : array();
$footer_template_id = rd_vamtam_get_option( 'footer-beaver-template' );

?>

<?php if ( ! defined( 'VAMTAM_NO_PAGE_CONTENT' ) ) : ?>
	<?php if ( ! class_exists( 'Vamtam_Elements_B' ) || Vamtam_Elements_B::had_limit_wrapper() ) :  ?>
					</div> <!-- .limit-wrapper -->
	<?php endif ?>

				</div><!-- #main -->

			</div><!-- #main-content -->

			<?php if ( ! is_page_template( 'page-blank.php' ) ) : ?>
				<?php if ( ! empty( $beaver_footer_ids ) ) : ?>
					<div class="footer-wrapper">
						<footer id="main-footer">
							<?php FLThemeBuilderLayoutRenderer::render_footer(); ?>
						</footer>
					</div>
				<?php elseif ( ( $footer_onepage || is_customize_preview() ) && ! empty( $footer_template_id ) ) : ?>
					<div class="footer-wrapper" style="<?php VamtamTemplates::display_none( $footer_onepage, false ) ?>">
						<footer id="main-footer">
							<?php
								if ( class_exists( 'FLBuilderShortcodes' ) ) {
									echo FLBuilderShortcodes::insert_layout( array( // xss ok
										'slug' => $footer_template_id,
									) );
								}
							?>
						</footer>
					</div>
				<?php endif ?>
			<?php endif ?>

		</div><!-- / .pane-wrapper -->

<?php endif // VAMTAM_NO_PAGE_CONTENT ?>
	</div><!-- / .boxed-layout -->
</div><!-- / #page -->

<div id="vamtam-overlay-search">
	<button id="vamtam-overlay-search-close"><?php echo vamtam_get_icon_html( array( // xss ok
		'name' => 'vamtam-theme-close-sample',
	) ) ?></button>
	<form action="<?php echo esc_url( home_url( '/' ) ) ?>" class="searchform" method="get" role="search" novalidate="">
		<input type="search" required="required" placeholder="<?php esc_attr_e( 'Search...', 'nex' ) ?>" name="s" value="" />
		<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) : ?>
			<input type="hidden" name="lang" value="<?php echo esc_attr( ICL_LANGUAGE_CODE ) ?>"/>
		<?php endif ?>
	</form>
</div>

<?php get_template_part( 'templates/side-buttons' ) ?>

<?php get_template_part( 'templates/overlay-menu' ) ?>

<?php wp_footer(); ?>
<!-- W3TC-include-js-head -->
</body>
</html>
