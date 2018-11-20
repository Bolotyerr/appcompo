<?php
/**
 * Header search button
 *
 * @package vamtam/nex
 */


if ( ! rd_vamtam_get_optionb( 'enable-header-search' ) && ! is_customize_preview() ) return;

?>
<div class="search-wrapper" <?php VamtamTemplates::display_none( rd_vamtam_get_optionb( 'enable-header-search' ) ) ?>>
	<button class="header-search icon vamtam-overlay-search-trigger"><?php vamtam_icon( 'search-clean' ) ?></button>
</div>
