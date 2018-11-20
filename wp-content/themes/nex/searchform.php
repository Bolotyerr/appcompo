<?php
/**
 * Search form template
 *
 * @package vamtam/nex
 */
?>
<form role="search" method="get" class="searchform clearfix" action="<?php echo esc_url( home_url( '/' ) ) ?>">
	<label for="search-text-widget" class="visuallyhidden"><?php esc_html_e( 'Search for:', 'nex' ) ?></label>
	<input id="search-text-widget" type="text" value="" name="s" placeholder="<?php esc_attr_e( 'Search', 'nex' )?>" required="required" />
	<input type="submit" value="<?php esc_attr_e( 'Search', 'nex' )?>" />
	<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) : ?>
		<input type="hidden" name="lang" value="<?php echo esc_attr( ICL_LANGUAGE_CODE ) ?>"/>
	<?php endif ?>
</form>
