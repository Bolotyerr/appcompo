<?php
$show = rd_vamtam_get_optionb( 'post-meta', 'tax' );

if ( $show || is_customize_preview() ) :
?>
	<div class="vamtam-meta-tax" <?php VamtamTemplates::display_none( $show ) ?>><span class="icon theme"><?php vamtam_icon( 'vamtam-theme-layers' ); ?></span> <span class="visuallyhidden"><?php esc_html_e( 'Category', 'nex' ) ?> </span><?php the_category( ' ' ); ?></div>
<?php
endif;
