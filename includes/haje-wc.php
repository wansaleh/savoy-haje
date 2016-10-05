<?php

require('color-names.php');

add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 4 );


add_action( 'woocommerce_single_product_summary', 'hj_show_brand', 13 );
function hj_show_brand() {
  echo '<div class="brand-image">';
  echo do_shortcode('[product_brand class=""]');
  echo '</div>';
}

// add_action( 'woocommerce_before_single_product', 'hj_hex_terms' );
// function hj_hex_terms() {
//   global $product;
//   $hexes = $product->get_attribute('hex');
//
//   if ($hexes) {
//     $out = array();
//     foreach (preg_split("/\s?\|\s?/", trim($hexes)) as $hex) {
//       $clr_hex = explode(',', $hex);
//       $out[trim($clr_hex[0])] = trim($clr_hex[1]);
//     }
//
//     echo '<script>var _haje_hex=' . json_encode($out) . ';</script>';
//   }
// }

// add_action( 'wc_ajax_haje_hex_terms', 'hj_ajax_hex_terms' );
// function hj_ajax_hex_terms() {
//   global $woocommerce, $product, $post;
//
//   $product = get_product( $_REQUEST['product_id'] );
//   $hexes = $product->get_attribute('hex');
//
//   $out =   null;
//
//   if ($hexes) {
//     $out = array();
//     foreach (preg_split("/\s?\|\s?/", trim($hexes)) as $hex) {
//       $clr_hex = explode(',', $hex);
//       $out[trim($clr_hex[0])] = trim($clr_hex[1]);
//     }
//   }
//
//   wp_send_json($out);
// }

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
//   echo "<script>var _haje_cart_hex=" . json_encode($product_hexes) . ";</script>";
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

function wc_dropdown_variation_attribute_options( $args = array() ) {
  global $haje_color_names_flipped_lowercase;
  $colors = $haje_color_names_flipped_lowercase;

  $args = wp_parse_args( apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ), array(
    'options'          => false,
    'attribute'        => false,
    'product'          => false,
    'selected'          => false,
    'name'             => '',
    'id'               => '',
    'class'            => '',
    'show_option_none' => __( 'Choose an option', 'woocommerce' )
  ) );

  $options   = $args['options'];
  $product   = $args['product'];
  $attribute = $args['attribute'];
  $name      = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
  $id        = $args['id'] ? $args['id'] : sanitize_title( $attribute );
  $class     = $args['class'];

  if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
    $attributes = $product->get_variation_attributes();
    $options    = $attributes[ $attribute ];
  }

  $html = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

  if ( $args['show_option_none'] ) {
    $html .= '<option value="">' . esc_html( $args['show_option_none'] ) . '</option>';
  }

  if ( ! empty( $options ) ) {
    $hexes = hj_get_hexes($product);

    if ( $product && taxonomy_exists( $attribute ) ) {
      // Get terms if this is a taxonomy - ordered. We need the names too.
      $terms = wc_get_product_terms( $product->id, $attribute, array( 'fields' => 'all' ) );

      foreach ( $terms as $term ) {
        if ( in_array( $term->slug, $options ) ) {
          $att = sanitize_title( $attribute );
          $slug = strtolower( $term->slug );
          $hex = '';
          if ( $att == 'pa_color' || $att == 'color' ) {
            if ( array_key_exists( $slug, $hexes ) ) {
              $hex = ' data-hex="' . $hexes[$slug] . '"';
            } elseif ( array_key_exists( $slug, $colors ) ) {
              $hex = ' data-hex="' . $colors[$slug] . '"';
            }
          }

          $html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . $hex . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
        }
      }
    } else {
      foreach ( $options as $option ) {
        $att = sanitize_title( $attribute );
        $slug = strtolower( $option );
        $hex = '';
        if ( $att == 'pa_color' || $att == 'color' ) {
          if ( array_key_exists( $slug, $hexes ) ) {
            $hex = ' data-hex="' . $hexes[$slug] . '"';
          } elseif ( array_key_exists( $slug, $colors ) ) {
            $hex = ' data-hex="' . $colors[$slug] . '"';
          }
        }

        // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
        $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
        $html .= '<option value="' . esc_attr( $option ) . '" ' . $selected . $hex . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
      }
    }
  }

  $html .= '</select>';

  echo apply_filters( 'woocommerce_dropdown_variation_attribute_options_html', $html, $args );
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
