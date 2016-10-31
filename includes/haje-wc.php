<?php

require('color-names.php');

// add_action( 'woocommerce_after_customer_login_form', 'hj_social_login' );
add_action( 'woocommerce_login_form_end', 'hj_social_login' );
function hj_social_login() {
  echo do_shortcode( '[woocommerce_social_login_buttons return_url="https://mystore.com/my-account"]' );
}

add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 6 );

// add_action( 'woocommerce_before_shop_loop_item_title', 'hj_before_shop_loop_item_title' );
// function hj_before_shop_loop_item_title() {
//   global $product;
//
//
// }

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

add_filter( 'nm_product_quickview_link', 'hj_nm_product_quickview_link' );
function hj_nm_product_quickview_link( $string ) {
  echo str_ireplace( 'Show more', __('Quick View', 'savoy-haje'), $string );
}


// SINGLE PRODUCT
add_image_size( '40x60', 40, 60, true );

add_action( 'woocommerce_after_single_product_tabs', 'hj_product_nav' );
function hj_product_nav() {
  global $product, $nm_theme_options;

  echo '<div class="hj-product-nav">';

  // Product navigation
  $navigate_same_term = ( $nm_theme_options['product_navigation_same_term'] ) ? true : false;

  $prev_post = get_previous_post( $navigate_same_term );
  if ( is_a( $prev_post , 'WP_Post' ) ) {
    $prev_product   = new WC_Product( $prev_post->ID );
    $prev_price     = $prev_product->get_price_html();

    echo '<a class="prev" href="' . esc_url( get_permalink( $prev_post->ID ) ) . '">';
      echo '<i class="nm-font nm-font-angle-thin-right"></i>';
      echo get_the_post_thumbnail( $prev_post->ID, '40x60' );
      echo '<div class="info">';
        echo '<span class="title">' . get_the_title( $prev_post->ID ) . '</span>';
        echo '<span class="price">' . $prev_price . '</span>';
      echo '</div>';
    echo '</a>';
  }

  $next_post = get_next_post( $navigate_same_term );
  if ( is_a( $next_post , 'WP_Post' ) ) {
    $next_product   = new WC_Product( $next_post->ID );
    $next_price     = $next_product->get_price_html();

    echo '<a class="next" href="' . esc_url( get_permalink( $next_post->ID ) ) . '">';
      echo '<i class="nm-font nm-font-angle-thin-left"></i>';
      echo get_the_post_thumbnail( $next_post->ID, '40x60' );
      echo '<div class="info">';
        echo '<span class="title">' . get_the_title( $next_post->ID ) . '</span>';
        echo '<span class="price">' . $next_price . '</span>';
      echo '</div>';
    echo '</a>';
  }

  echo '</div>';

  // /* Product navigation */
  // next_post_link( '%link', apply_filters( 'nm_single_product_menu_next_icon', '<i class="nm-font nm-font-media-play flip"></i>' ), $navigate_same_term, array(), 'product_cat' );
  // previous_post_link( '%link', apply_filters( 'nm_single_product_menu_prev_icon', '<i class="nm-font nm-font-media-play"></i>' ), $navigate_same_term, array(), 'product_cat' );
}

// add_filter( 'nm_single_product_menu_next_icon', 'hj_single_product_menu_next_icon' );
// function hj_single_product_menu_next_icon( $orig ) {
//   global $product;
//   return '<i class="nm-font nm-font-media-play flip"></i> %title';
// }
// add_filter( 'nm_single_product_menu_prev_icon', 'hj_single_product_menu_prev_icon' );
// function hj_single_product_menu_prev_icon( $orig ) {
//   global $product;
//   return '%title <i class="nm-font nm-font-media-play"></i>';
// }

// /*
//  *	AJAX: Load product
//  */
// function hj_nm_ajax_load_product() {
//   global $woocommerce, $product, $post;
//
//   sleep(60);
//
//   //$post = $product = get_post( $_POST['product_id'] );
//   $product = get_product( $_POST['product_id'] );
//   $post = $product->post;
//   $output = '';
//
//   setup_postdata( $post );
//
//   ob_start();
//     wc_get_template_part( 'quickview/content', 'quickview' );
//   $output = ob_get_clean();
//
//   wp_reset_postdata();
//
//   echo $output;
//
//   exit;
// }
// remove_action( 'wp_ajax_nm_ajax_load_product' , 'nm_ajax_load_product' );
// remove_action( 'wp_ajax_nopriv_nm_ajax_load_product', 'nm_ajax_load_product' );
// remove_action( 'wc_ajax_nm_ajax_load_product', 'nm_ajax_load_product' );
// add_action( 'wp_ajax_nm_ajax_load_product' , 'hj_nm_ajax_load_product' );
// add_action( 'wp_ajax_nopriv_nm_ajax_load_product', 'hj_nm_ajax_load_product' );
// add_action( 'wc_ajax_nm_ajax_load_product', 'hj_nm_ajax_load_product' );
