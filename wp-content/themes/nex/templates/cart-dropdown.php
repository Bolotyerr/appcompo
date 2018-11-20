<?php
	$show_if_empty = rd_vamtam_get_option( 'show-empty-header-cart' );
?>
<div class="cart-dropdown <?php echo esc_attr( $show_if_empty ? 'show-if-empty' : 'hidden' ) ?>">
	<div class="cart-dropdown-inner">
		<a class="vamtam-cart-dropdown-link" href="#">
			<span class="icon theme"><?php vamtam_icon( 'vamtam-theme-bag-clean' ) ?></span>
			<span class="products cart-empty">...</span>
		</a>
		<div class="widget woocommerce widget_shopping_cart">
			<div class="widget_shopping_cart_content"></div>
		</div>
	</div>
</div>
