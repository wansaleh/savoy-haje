<?php

function hj_new_flash( $newness = 30 ) { // days
  // $postdate = get_the_time( 'Y-m-d' );
  // $postdatestamp = strtotime( $postdate );
  //
  // if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) {
  // 	echo "<span class='isnew'>" . __( 'New', 'savoy-haje' ) . "</span>\n";
  // }
}

function hj_edar_flash() { // days
  if ( is_user_in_role( 'haje_edar' ) ) {
    echo "<span class='haje-edar'>" . __( 'Edar Discounts', 'savoy-haje' ) . " <a href='/account/edar/' class='info' target='_blank'><i class='fa fa-question'></i></a></span>";
  }
}


add_filter( 'woocommerce_cart_item_price', 'hj_woocommerce_cart_item_price', 20, 3 );
function hj_woocommerce_cart_item_price( $html, $cart_item, $cart_item_key ) {
  if ( isset( $cart_item['discounts'] ) ) {
    $percent = 100 * ( ( $cart_item['discounts']['display_price'] - $cart_item['discounts']['price_adjusted'] ) / $cart_item['discounts']['display_price'] );

    return "$html<span class='discount-percent'>Discount $percent%</span>";
  }

  return $html;
}

add_action( 'woocommerce_single_product_summary', 'hj_product_title_initials', 4 );
function hj_product_title_initials() {
  global $product;

  $words = preg_split("/\s+/", trim($product->get_title()));
  $i = 0;
  $acronym = '';
  foreach ($words as $w) {
    if ( $i++ < 2 )
      $acronym .= $w[0];
  }

  echo '<div class="initials">' . $acronym . '</div>';
}

// add_action( 'woocommerce_shop_loop_item_title', 'hj_edar_badge' );
// function hj_edar_badge() {
//   global $product;
//   if ( has_term( 'edar', 'product_cat', $product->id ) ) {
//     echo '<span class="haje-edar">Edar</span>';
//   }
// }

// add_action( 'woocommerce_after_customer_login_form', 'hj_social_login' );
// add_action( 'woocommerce_login_form_end', 'hj_social_login' );
// function hj_social_login() {
//   echo do_shortcode( '[woocommerce_social_login_buttons return_url="http://haje.my/my-account"]' );
// }

add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

// add_action( 'woocommerce_share', 'hj_currency_switcher' );
// function hj_currency_switcher() {
//   echo do_shortcode("[woocs show_flags=0 width='100%' txt_type='code']");
// }


// add_action( 'woocommerce_single_product_summary', 'hj_haje_edar_box', 25 );
// function hj_haje_edar_box() {
//   if ( is_user_in_role( 'haje_edar' ) ) {
//     Timber::render('single-product-haje-edar.twig');
//   }
// }

// add_action( 'woocommerce_single_product_summary', 'hj_show_brand', 13 );
// function hj_show_brand() {
//   echo '<div class="brand-image-wrap">';
//   echo do_shortcode('[product_brand class=""]');
//   echo '</div>';
// }

add_action( 'woocommerce_before_single_product', 'hj_hex_terms' );
function hj_hex_terms() {
  global $product;
  $hexes = $product->get_attribute('hex');

  if ($hexes) {
    $out = array();
    foreach (preg_split("/\s?\|\s?/", trim($hexes)) as $hex) {
      $clr_hex = explode(':', $hex);
      $out[trim($clr_hex[0])] = trim($clr_hex[1]);
    }

    // wp_localize_script( 'haje-main', 'haje_hex', $out );
    echo '<script>window.haje_hex=' . json_encode($out) . ';</script>';
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
      $clr_hex = explode(':', $hex);
      $out[trim($clr_hex[0])] = trim($clr_hex[1]);
    }
  }

  wp_send_json($out);
}

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
      $clr_hex = explode(':', $hex);
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
  // echo str_ireplace( 'Show more', __('Quick View', 'savoy-haje'), $string );
  echo str_ireplace( 'Show more', '<i class="nm-font nm-font-eye"></i>', $string );
}

// add_filter( 'wc_price', 'hj_wc_price', 10, 3 );
// function hj_wc_price( $string, $price, $args ) {
//   extract( apply_filters( 'wc_price_args', wp_parse_args( $args, array(
//     'ex_tax_label'       => false,
//     'currency'           => '',
//     'decimal_separator'  => wc_get_price_decimal_separator(),
//     'thousand_separator' => wc_get_price_thousand_separator(),
//     'decimals'           => wc_get_price_decimals(),
//     'price_format'       => get_woocommerce_price_format()
//   ) ) ) );
//
//   $negative        = $price < 0;
//   $price           = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * -1 : $price ) );
//   $price           = apply_filters( 'formatted_woocommerce_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );
//
//   if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $decimals > 0 ) {
//     $price = wc_trim_zeros( $price );
//   }
//
//   $pricelr = explode( '.', $price );
//   $price   = $pricelr[0] . '<span class="decimals"><span class="point">.</span>' . $pricelr[1] . '</span>';
//
//   $formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( $currency ) . '</span>', $price );
//   $return          = '<span class="woocommerce-Price-amount amount">' . $formatted_price . '</span>';
//
//   if ( $ex_tax_label && wc_tax_enabled() ) {
//     $return .= ' <small class="woocommerce-Price-taxLabel tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
//   }
//
//   return $return;
// }

remove_action( 'wp_ajax_nm_ajax_load_product' , 'nm_ajax_load_product' );
remove_action( 'wp_ajax_nopriv_nm_ajax_load_product', 'nm_ajax_load_product' );
remove_action( 'wc_ajax_nm_ajax_load_product', 'nm_ajax_load_product' );

add_action( 'wp_ajax_nm_ajax_load_product' , 'hj_nm_ajax_load_product' );
add_action( 'wp_ajax_nopriv_nm_ajax_load_product', 'hj_nm_ajax_load_product' );
add_action( 'wc_ajax_nm_ajax_load_product', 'hj_nm_ajax_load_product' );
function hj_nm_ajax_load_product() {
  global $woocommerce, $product, $post;

  //$post = $product = get_post( $_POST['product_id'] );
  $product = get_product( $_POST['product_id'] );
  $post = $product->post;
  $output = '';

  setup_postdata( $post );

  ob_start();
    hj_hex_terms();
    wc_get_template_part( 'quickview/content', 'quickview' );
  $output = ob_get_clean();

  wp_reset_postdata();

  echo str_replace( 'window.haje_hex=', 'window.haje_hex_qv=', $output );

  exit;
}
