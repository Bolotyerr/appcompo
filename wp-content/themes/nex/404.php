<?php
/**
 * 404 page template
 *
 * @package vamtam/nex
 */

get_header(); ?>

<div class="clearfix">
	<div id="header-404" style="background: url('<?php echo esc_attr( VAMTAM_IMAGES ) ?>404.svg') no-repeat left 110px / 130px">
		<div class="line-1"><?php echo esc_html_x( '404', 'page not found error', 'nex' ) ?></div>
		<div class="line-2"><?php esc_html_e( 'Holy guacamole!', 'nex' ) ?></div>
		<div class="line-3"><?php esc_html_e( 'Looks like this page is on vacation. Or just playing hard to get. At any rate... it is not here.', 'nex' ) ?></div>
		<div class="line-4"><a href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php echo esc_html__( '&larr; Go to the home page or just search...', 'nex' ) ?></a></div>
	</div>
	<div class="page-404">
		<?php get_search_form(); ?>
	</div>
</div>

<?php get_footer(); ?>
