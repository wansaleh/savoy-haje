<?php

class HJPO {
  public static function can_preorder( $product ) {
    if ( ! is_object( $product ) ) {
      $product = wc_get_product( $product );
    }

    return $product->get_attribute('pre_order') == 1;
  }

  public static function preorder_date( $product ) {
    if ( ! is_object( $product ) ) {
      $product = wc_get_product( $product );
    }

    return strtotime( $product->get_attribute('pre_order_release_date') );
  }

  public static function preorder_date_diff( $product ) {
    if ( ! is_object( $product ) ) {
      $product = wc_get_product( $product );
    }

    $timestamp = HJPO::preorder_date( $product );
    $td = human_time_diff( current_time('timestamp'), $timestamp );
    preg_match('/(\d+)\s(weeks|days)/i', $td, $matches);
    $newtd = $matches[1] . '&ndash;' . ($matches[1] + 1) . ' ' . $matches[2];

    return $newtd;
  }

  public static function cart_contains_preorder() {
    global $woocommerce;

    $contains_pre_order = false;
    if ( ! empty( $woocommerce->cart->cart_contents ) ) {
      foreach ( $woocommerce->cart->cart_contents as $cart_item ) {
        if ( HJPO::can_preorder( $cart_item['product_id'] ) ) {
          $contains_pre_order = true;
          break;
        }
      }
    }

    return $contains_pre_order;
  }
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'hj_preorder_add_to_cart' );    // < 2.1
function hj_preorder_add_to_cart( $text ) {
  global $product;
  if ( HJPO::can_preorder( $product ) ) {
    return __( 'Add To Cart (Pre-Order)', 'savoy-haje' );
  }
  return $text;
}

add_action( 'woocommerce_single_product_summary', 'hj_woocommerce_single_product_summary', 20 );
function hj_woocommerce_single_product_summary() {
  global $product;

  if ( HJPO::can_preorder( $product ) ) {
    echo "<div class='preorder-notice'>This product is currently in production.";
    if ( HJPO::preorder_date( $product ) ) {
      echo " Estimated delivery time in <strong>" . HJPO::preorder_date_diff( $product ) . ".</strong>";
    }
    echo "</div>";
  }

  // if ( WC_Pre_Orders_Product::product_can_be_pre_ordered( $product ) ) {
  //   echo "<div class='preorder-notice'>This product is currently in production.";
  //
  //   $timestamp = WC_Pre_Orders_Product::get_localized_availability_datetime_timestamp( $product );
  //
  //   if ( $timestamp ) {
  //     $td = human_time_diff( current_time('timestamp'), $timestamp );
  //     preg_match('/(\d+)\s(weeks|days)/i', $td, $matches);
  //     $newtd = $matches[1] . '&ndash;' . ($matches[1] + 1) . ' ' . $matches[2];
  //
  //     echo " Estimated delivery time in <strong>$newtd.</strong>";
  //   }
  //
  //   echo "</div>";
  // }
}

// Add an optional pre-order product message after single product price on the single product page
add_action( 'woocommerce_single_product_summary', 'hj_wc_pre_orders_product_message', 11 );

// Add an optional pre-order product message before the 'add to cart' button on the product shop loop page
add_action( 'woocommerce_after_shop_loop_item_title', 'hj_wc_pre_orders_product_message', 11 );

function hj_wc_pre_orders_product_message() {
  global $product;

  if ( HJPO::can_preorder( $product ) ) {
    if ( ! HJPO::preorder_date( $product ) ) {
      echo '<div class="preorder-release-date">Avalable soon</div>';
    }
    else {
      echo '<div class="preorder-release-date">Ready to ship in ' . HJPO::preorder_date_diff( $product ) . '</div>';
    }
  }

}

add_filter( 'woocommerce_get_item_data', 'hj_preorder_item_data', 10, 2 );
function hj_preorder_item_data( $item_data, $cart_item ) {
  // if ( ! HJPO::cart_contains_preorder() )
  //   return $item_data;
  //
  // // get title text
  // $name = 'Estimated release';
  //
  // // don't add if empty
  // if ( ! $name )
  //   return $item_data;
  //
  // $pre_order_meta = array(
  //   'name'    => $name,
  //   'display' => $cart_item['data'],
  // );
  //
  // // add title and localized date
  // if ( ! empty( $pre_order_meta ) )
  //   $item_data[] = $pre_order_meta;
  //
  // return $item_data;

  if ( HJPO::can_preorder( $cart_item['product_id'] ) ) {
    $timestamp = HJPO::preorder_date( $cart_item['product_id'] );
    if ( $timestamp ) {
      // $date = date_i18n( get_option( 'date_format' ), $timestamp );
      $date = HJPO::preorder_date_diff( $cart_item['product_id'] );
    }
    else {
      $date = 'Soon';
    }
    $item_data[] = array(
      'name' => 'Estimated Release',
      'display' => $date
    );
  }

  return $item_data;
}

// add_filter( 'wc_pre_orders_product_message', 'hj_wc_pre_orders_product_message', 10, 2 );
// function hj_wc_pre_orders_product_message( $message, $product ) {
//   $timestamp = WC_Pre_Orders_Product::get_localized_availability_datetime_timestamp( $product );
//
//   if ( ! $timestamp ) {
//     return '<div class="preorder-release-date">Avalable soon</div>';
//   }
//   else {
//     $td = human_time_diff( current_time('timestamp'), $timestamp );
//     preg_match('/(\d+)\s(weeks|days)/i', $td, $matches);
//     $newtd = $matches[1] . '&ndash;' . ($matches[1] + 1) . ' ' . $matches[2];
//
//     return '<div class="preorder-release-date">Ready to ship in ' . $newtd . '</div>';
//   }
// }

function hj_pre_order_flash() {
  global $product;

  // if ( WC_Pre_Orders_Product::product_can_be_pre_ordered( $product ) ) {
  if ( HJPO::can_preorder( $product ) ) {
    echo "<span class='preorder'>Pre Order</span>";
  }
  // }
}
