<?php

require('color-names.php');

add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 4 );


add_action( 'woocommerce_single_product_summary', 'hj_show_brand', 13 );
function hj_show_brand() {
  echo '<div class="brand-image-wrap">';
  echo do_shortcode('[product_brand class=""]');
  echo '</div>';
}

// add_action( 'woocommerce_single_product_summary', 'hj_size_guide', 8 );
// function hj_size_guide() {
//   echo '<div class="clearfix"></div><div class="size-guide-wrap">';
//   echo do_shortcode('[ct_size_guide]');
//   echo '</div>';
// }

add_action( 'woocommerce_single_product_summary', 'hj_hex_terms' );
function hj_hex_terms() {
  global $product;
  $hexes = $product->get_attribute('hex');

  if ($hexes) {
    $out = array();
    foreach (preg_split("/\s?\|\s?/", trim($hexes)) as $hex) {
      $clr_hex = explode(',', $hex);
      $out[trim($clr_hex[0])] = trim($clr_hex[1]);
    }

    // wp_localize_script( 'haje-main', 'haje_hex', $out );
    echo '<script>var haje_hex=' . json_encode($out) . ';</script>';
  }
}

add_action( 'wc_ajax_haje_hex_terms', 'hj_ajax_hex_terms' );
function hj_ajax_hex_terms() {
  global $woocommerce, $product, $post;

  $product = get_product( $_REQUEST['product_id'] );
  $hexes = $product->get_attribute('hex');

  $out =   null;

  if ($hexes) {
    $out = array();
    foreach (preg_split("/\s?\|\s?/", trim($hexes)) as $hex) {
      $clr_hex = explode(',', $hex);
      $out[trim($clr_hex[0])] = trim($clr_hex[1]);
    }
  }

  wp_send_json($out);
}

// add_action( 'woocommerce_before_cart', 'hj_hex_terms_cart' );
// add_action( 'woocommerce_before_mini_cart', 'hj_hex_terms_cart' );
// add_action( 'woocommerce_before_checkout_form', 'hj_hex_terms_cart' );
// function hj_hex_terms_cart() {
//   $product_hexes = array();
//   foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
//     $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
//     $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
//
//     $hexes = $_product->get_attribute('hex');
//
//     if ($hexes) {
//       $out = array();
//       foreach (preg_split("/\s?\|\s?/", trim($hexes)) as $hex) {
//         $clr_hex = explode(',', $hex);
//         $out[trim($clr_hex[0])] = trim($clr_hex[1]);
//       }
//       $product_hexes[$product_id] = $out;
//     }
//   }
//
//   echo "<script>var haje_cart_hex=" . json_encode($product_hexes) . ";</script>";
// }

add_filter( 'woocommerce_cart_item_class', 'hj_cart_item_class', 10, 3 );
add_filter( 'woocommerce_mini_cart_item_class', 'hj_cart_item_class', 10, 3 );
function hj_cart_item_class($class, $cart_item, $cart_item_key) {
  return $class . " product-id-" . $cart_item['product_id'];
  // woocommerce_cart_item_class
}

function hj_get_hexes($product) {
  $hexes = $product->get_attribute('hex');

  if ($hexes) {
    $out = array();
    foreach (preg_split("/\s?\|\s?/", trim($hexes)) as $hex) {
      $clr_hex = explode(',', $hex);
      $out[strtolower(trim($clr_hex[0]))] = trim($clr_hex[1]);
    }

    return $out;
  }

  return null;
}

add_filter( 'woocommerce_get_catalog_ordering_args', 'wc_get_catalog_ordering_args' );
function wc_get_catalog_ordering_args( $args ) {
  $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
  if ( 'sales' == $orderby_value ) {
    $args['orderby'] = 'meta_value_num';
    $args['order'] = 'DESC';
    $args['meta_key'] = 'total_sales';
  }
  return $args;
}

function array_insert_after( array $array, $key, array $new ) {
  $keys = array_keys( $array );
  $index = array_search( $key, $keys );
  $pos = false === $index ? count( $array ) : $index + 1;
  return array_merge( array_slice( $array, 0, $pos ), $new, array_slice( $array, $pos ) );
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'wc_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'wc_catalog_orderby' );
function wc_catalog_orderby( $sortby ) {
  // $sortby = array_insert_after( $sortby, 'date', array( 'sales' => 'Sales' ) );
  $sortby['sales'] = 'Sales';
  return $sortby;
}

add_filter( 'woocommerce_get_item_data', 'hj_get_item_data', 10, 2 );
function hj_get_item_data( $item_data, $cart_item ) {
  $item_data[] = array(
    'key' => 'product_id',
    'value' => $cart_item['product_id']
  );
  return $item_data;
}
