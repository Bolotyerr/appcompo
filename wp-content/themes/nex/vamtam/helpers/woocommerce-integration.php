<?php

/**
 * WooCommerce-related functions and filters
 *
 * @package vamtam/nex
 */

/**
 * Alias for function_exists('is_woocommerce')
 * @return bool whether WooCommerce is active
 */
function vamtam_has_woocommerce() {
	return function_exists( 'is_woocommerce' );
}

if ( vamtam_has_woocommerce() ) {
	// we have woocommerce

	// replace the default pagination with ours
	function woocommerce_pagination() {
		echo VamtamTemplates::pagination_list(); // xss ok
	}

	function vamtam_woocommerce_columns() {
		return 4;
	}

	// remove the WooCommerce breadcrumbs
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20,0 );

	// remove the WooCommerve sidebars
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	/**
	 * Redefine woocommerce_output_related_products()
	 */
	function woocommerce_output_related_products() {
		if ( is_product() ) {
			if ( ! class_exists( 'Vamtam_Columns' ) || Vamtam_Columns::had_limit_wrapper() ) {
				echo '</div>';
			}

			woocommerce_related_products( array(
				'columns'        => 4,
				'posts_per_page' => 12,
			) );

			if ( ! class_exists( 'Vamtam_Columns' ) || Vamtam_Columns::had_limit_wrapper() ) {
				echo '<div class="limit-wrapper">';
			}
		}
	}

	// move related products after the content + sidebars
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	add_action( 'woocommerce_after_main_content', 'woocommerce_output_related_products', 999 );

	function vamtam_woocommerce_upsell_display() {
		if ( ! class_exists( 'Vamtam_Columns' ) || Vamtam_Columns::had_limit_wrapper() ) {
			echo '</div>';
		}

		woocommerce_upsell_display();

		if ( ! class_exists( 'Vamtam_Columns' ) || Vamtam_Columns::had_limit_wrapper() ) {
			echo '<div class="limit-wrapper">';
		}
	}
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	add_action( 'woocommerce_after_main_content', 'vamtam_woocommerce_upsell_display', 990 );

	add_filter( 'woocommerce_upsells_columns', 'vamtam_woocommerce_columns' );

	/**
	 * Set the number of gallery thumbnails per row
	 */
	add_filter( 'woocommerce_product_thumbnails_columns', 'vamtam_woocommerce_columns' );

	/**
	 * star rating used in the single product template
	 */
	function vamtam_woocommerce_rating() {
		global $product;

		if ( ! isset( $product ) || get_option( 'woocommerce_enable_review_rating' ) != 'yes' ) return;

		$count = $product->get_rating_count();

		if ( $count > 0 ) {

			$average = $product->get_average_rating();

			echo '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';

			echo '<div class="star-rating" title="' . esc_attr( sprintf( esc_html__( 'Rated %s out of 5', 'nex' ), $average ) ) . '"><span style="width:' . esc_attr( ( ( $average / 5 ) * 100 ) ) . '%"><strong itemprop="ratingValue" class="rating">' . esc_html( $average ) . '</strong> <span class="visuallyhidden">' . esc_html__( 'out of 5', 'nex' ) . '</span></span></div>';
			echo '</div>';

		}
	}
	add_action( 'woocommerce_single_product_summary', 'vamtam_woocommerce_rating', 15, 0 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

	/**
	 * Move .onsale inside the images div
	 */
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	add_action( 'vamtam_woocommerce_before_single_product_images', 'woocommerce_show_product_sale_flash', 10 );

	/**
	 * star rating for the shop loop, related product, etc.
	 */
	function woocommerce_template_loop_rating() {
		vamtam_woocommerce_rating();
	}

	/**
	 * wrap the product thumbnails in div.product-thumbnail
	 */
	function woocommerce_template_loop_product_thumbnail() {
		echo '<div class="product-thumbnail">' . wp_kses_post( woocommerce_get_product_thumbnail() ) . '</div>';
	}

	/**
	 * Show the product title in the product loop. By default this is an H3.
	 */
	function woocommerce_template_loop_product_title() {
		echo '<h3 class="woocommerce-loop-product__title">' . get_the_title() . '</h3>';
	}

	/**
	 * WooCommerce catalog/related products excerpt
	 */
	function vamtam_woocommerce_catalog_excerpt() {
		global $post;

		if ( ! $post->post_excerpt ) return;

		$excerpt_length = apply_filters( 'vamtam_woocommerce_catalog_excerpt_length', 60 );

		$excerpt         = explode( "\n", wordwrap( $post->post_excerpt, $excerpt_length ) );
		if (count( $excerpt ) > 1)
			$excerpt[0] .= '...';
		$excerpt         = $excerpt[0];
		?>

		<?php
	}
	add_action( 'woocommerce_after_shop_loop_item_title','vamtam_woocommerce_catalog_excerpt', 0 );

	function vamtam_woocommerce_cart_dropdown() {
		get_template_part( 'templates/cart-dropdown' );
	}
	add_action( 'vamtam_header_cart', 'vamtam_woocommerce_cart_dropdown' );

	function vamtam_woocommerce_body_class( $class ) {
		if ( is_cart() || is_checkout() || is_account_page() ) {
			$class[] = 'woocommerce';
		}

		return $class;
	}
	add_action( 'body_class', 'vamtam_woocommerce_body_class' );

	function vamtam_woocommerce_product_review_comment_form_args( $comment_form ) {
		$comment_form['comment_field'] = '';

		if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
			$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . esc_html__( 'Your Rating', 'nex' ) . '</label><select name="rating" id="rating">
				<option value="">' . esc_html__( 'Rate&hellip;', 'nex' ) . '</option>
				<option value="5">' . esc_html__( 'Perfect', 'nex' ) . '</option>
				<option value="4">' . esc_html__( 'Good', 'nex' ) . '</option>
				<option value="3">' . esc_html__( 'Average', 'nex' ) . '</option>
				<option value="2">' . esc_html__( 'Not that bad', 'nex' ) . '</option>
				<option value="1">' . esc_html__( 'Very Poor', 'nex' ) . '</option>
			</select></p>'; }

		$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your Review', 'nex' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

		return $comment_form;
	}
	add_filter( 'woocommerce_product_review_comment_form_args', 'vamtam_woocommerce_product_review_comment_form_args' );

	add_filter( 'woocommerce_get_stock_html', 'vamtam_wc_get_stock_html', 10, 3 );
	function vamtam_wc_get_stock_html( $availability_html, $product ) {
		$availability = $product->get_availability();

		return empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '"><small>' . wp_kses_post( $availability['availability'] ) . '</small></p>';
	}

	// before_shop_loop_item_title

	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	if ( ! class_exists( 'WC_pac' ) || get_option( 'wc_pac_rating' ) !== 'no' ) {
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 45 );
	}

	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 40 );

	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	if ( ! class_exists( 'WC_pac' ) || get_option( 'wc_pac_add_to_cart' ) !== 'no' ) {
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 50 );
	}

	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 65 );

	// reorder wC PAC categories
	function vamtam_reorder_wc_pac() {
		if ( isset( $GLOBALS['wp_filter']['woocommerce_after_shop_loop_item']->callbacks[30] ) ) {
			foreach ( $GLOBALS['wp_filter']['woocommerce_after_shop_loop_item']->callbacks[30] as $key => $callback ) {
				if ( is_array( $callback['function'] ) && $callback['function'][1] === 'woocommerce_pac_show_product_categories' ) {
					remove_action( 'woocommerce_after_shop_loop_item', $callback['function'], 30 );
					add_action( 'woocommerce_before_shop_loop_item_title', $callback['function'], 60 );
				}
			}
		}
	}
	add_action( 'wp', 'vamtam_reorder_wc_pac', 100 );

	// after_shop_loop_item

	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	if ( ! class_exists( 'WC_pac' ) || get_option( 'wc_pac_rating' ) !== 'no' ) {
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 45 );
	}

	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	if ( ! class_exists( 'WC_pac' ) || get_option( 'wc_pac_price' ) !== 'no' ) {
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 50 );
	}

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

	function vamtam_before_single_product_summary() {
		// check vamtam_after_single_product_summary() if modifying this line
		echo '<div class="limit-wrapper vamtam-box-outer-padding clearfix">';
	}
	add_action( 'woocommerce_before_single_product_summary', 'vamtam_before_single_product_summary', 1 );

	function vamtam_after_single_product_summary() {
		// check vamtam_before_single_product_summary() if modifying this line
		echo '</div>';
	}
	add_action( 'woocommerce_after_single_product_summary', 'vamtam_after_single_product_summary', 1 );

	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	add_action( 'woocommerce_after_cart_table', 'woocommerce_cross_sell_display' );
	add_filter( 'woocommerce_cross_sells_columns', 'vamtam_woocommerce_columns' );

	add_filter( 'woocommerce_product_description_heading', '__return_false' );

	/**
	 * Show a shop page description on product archives
	 *
	 * @access public
	 * @subpackage	Archives
	 * @return void
	 */
	function woocommerce_product_archive_description() {
		if ( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0 && ! is_search() ) {
			$shop_page = get_post( wc_get_page_id( 'shop' ) );
			if ( $shop_page ) {
				// this IS content, why not apply the filters anyway?
				echo apply_filters( 'the_content', wp_kses_post( $shop_page->post_content ) ); // xss ok
			}
		}
	}
}
