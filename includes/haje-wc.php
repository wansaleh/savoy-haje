<?php

class Haje_WC
{
	function __construct() {
		add_action( 'woocommerce_before_single_product', array( $this, 'hex_terms' ) );
		add_action( 'woocommerce_before_cart', array( $this, 'hex_terms_cart' ) );
		add_action( 'woocommerce_before_mini_cart', array( $this, 'hex_terms_cart' ) );
		add_action( 'woocommerce_before_checkout_form', array( $this, 'hex_terms_cart' ) );
		add_filter( 'woocommerce_cart_item_class', array( $this, 'cart_item_class' ), 10, 3 );
		add_filter( 'woocommerce_mini_cart_item_class', array( $this, 'cart_item_class' ), 10, 3 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'show_brand' ), 12 );
		add_action( 'wc_ajax_haje_hex_terms', array( $this, 'ajax_hex_terms' ) );

		add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 4 );
		// add_action( 'woocommerce_single_product_summary', array( $this, 'show_product_new_flash' ), 4 );

		// add_filter( 'post_class', array( $this, 'product_post_class' ), 30, 3 );
	}

	function show_brand() {
		echo '<div class="brand-image">';
	  echo do_shortcode('[product_brand class=""]');
	  echo '</div>';
	}

	function hex_terms() {
		global $product;
		$hexes = $product->get_attribute('hex');

		if ($hexes) {
			$out = array();
			foreach (preg_split("/\s?\|\s?/", trim($hexes)) as $hex) {
				$clr_hex = explode(',', $hex);
				$out[trim($clr_hex[0])] = trim($clr_hex[1]);
			}

			echo '<script>var _haje_hex=' . json_encode($out) . ';</script>';
		}
	}

	function ajax_hex_terms() {
		global $woocommerce, $product, $post;

		$product = get_product( $_REQUEST['product_id'] );
		$hexes = $product->get_attribute('hex');

		$out = 	null;

		if ($hexes) {
			$out = array();
			foreach (preg_split("/\s?\|\s?/", trim($hexes)) as $hex) {
				$clr_hex = explode(',', $hex);
				$out[trim($clr_hex[0])] = trim($clr_hex[1]);
			}
		}

		wp_send_json($out);
	}

	function hex_terms_cart() {
		$product_hexes = array();
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product		 = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id	 = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			$hexes = $_product->get_attribute('hex');

			if ($hexes) {
				$out = array();
				foreach (preg_split("/\s?\|\s?/", trim($hexes)) as $hex) {
					$clr_hex = explode(',', $hex);
					$out[trim($clr_hex[0])] = trim($clr_hex[1]);
				}
				$product_hexes[$product_id] = $out;
			}
		}

		echo "<script>var _haje_cart_hex=" . json_encode($product_hexes) . ";</script>";
	}

	function cart_item_class($class, $cart_item, $cart_item_key) {
		return $class . " product-id-" . $cart_item['product_id'];
		// woocommerce_cart_item_class
	}

	function product_post_class( $classes, $class = '', $post_id = '' ) {
		if ( ! $post_id || 'product' !== get_post_type( $post_id ) ) {
			return $classes;
		}

		$classes[] = 'atvImg';

		return $classes;
	}
}

new Haje_WC;
