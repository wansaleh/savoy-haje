<?php

define( 'HJ_VERSION', '1.2.1' );
define( 'HJ_URI', get_stylesheet_directory_uri() );

add_action( 'wp_head', 'hj_pace', 0 );
function hj_pace() {
  global $nm_theme_options;
  if ( is_admin() ) return;

  echo "<script type='text/javascript' src='" . HJ_URI . '/bower_components/PACE/pace.min.js' . "'></script>\n";
  echo "<style>.pace{-webkit-pointer-events:none;pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none}.pace-inactive{display:none}.pace .pace-progress{background:".esc_attr( $nm_theme_options['highlight_color'] ).";position:fixed;z-index:2000;top:0;right:100%;width:100%;height:2px;box-shadow:0 0 2px ".esc_attr( $nm_theme_options['highlight_color'] )."}</style>";
}

add_action( 'wp_head', 'hj_head_last', 10000 );
function hj_head_last() {
  if ( is_admin() ) return;

  echo "<link rel='stylesheet' href='" . HJ_URI . '/assets/css/haje.css?v=' . HJ_VERSION . "' type='text/css' media='all'>";
}

/**
 * Savoy javascript overrides.
 */

add_action( 'wp_enqueue_scripts', 'hj_scripts', 10000 );
function hj_scripts() {
  global $wp_scripts, $nm_theme_options, $nm_globals, $nm_page_includes;

  if ( is_admin() ) return;

  // wp_enqueue_style( 'haje-main', HJ_URI . '/assets/css/haje.css', array( 'nm-core' ), HJ_VERSION );

  wp_enqueue_script( 'haje-modernizr', HJ_URI . '/assets/js/modernizr.js', array(), HJ_VERSION );

  wp_enqueue_script( 'haje-vendor', HJ_URI . '/assets/js/vendor.js', array( 'jquery' ), HJ_VERSION, true );

  wp_enqueue_script( 'nm-core', HJ_URI . '/assets/js/haje-nm-core.js', array( 'jquery' ), NM_THEME_VERSION, true );

  $local_js_vars = array(
    'themeUri'               => NM_THEME_URI,
    'ajaxUrl'                => admin_url( 'admin-ajax.php' ),
    'searchUrl'              => home_url( '?s=' ),
    'pageLoadTransition'     => intval( $nm_theme_options['page_load_transition'] ),
    'shopFiltersAjax'        => isset( $_GET['ajax_filters'] ) ? esc_attr( $_GET['ajax_filters'] ) : esc_attr( $nm_theme_options['shop_filters_enable_ajax'] ),
    'shopAjaxUpdateTitle'    => intval( $nm_theme_options['shop_ajax_update_title'] ),
    //'shopFilterScrollbars' => ( $nm_globals['shop_filters_scrollbar_custom'] ) ? 1 : 0,
    'shopImageLazyLoad'      => intval( $nm_theme_options['product_image_lazy_loading'] ),
    'shopScrollOffset'       => intval( $nm_theme_options['shop_scroll_offset'] ),
    'shopScrollOffsetTablet' => intval( $nm_theme_options['shop_scroll_offset_tablet'] ),
    'shopScrollOffsetMobile' => intval( $nm_theme_options['shop_scroll_offset_mobile'] ),
    'shopSearch'             => esc_attr( $nm_globals['shop_search_layout'] ),
    'shopSearchMinChar'      => intval( $nm_theme_options['shop_search_min_char'] ),
    'shopSearchAutoClose'    => intval( $nm_theme_options['shop_search_auto_close'] ),
    'shopAjaxAddToCart'      => ( get_option( 'woocommerce_enable_ajax_add_to_cart' ) == 'yes' && get_option( 'woocommerce_cart_redirect_after_add' ) == 'no' ) ? 1 : 0,
    'shopRedirectScroll'     => intval( $nm_theme_options['product_redirect_scroll'] ),
    'shopCustomSelect'       => intval( $nm_theme_options['product_custom_select'] ),
    'wpGalleryPopup'         => intval( $nm_theme_options['wp_gallery_popup'] )
  );
  wp_localize_script( 'nm-core', 'nm_wp_vars', $local_js_vars );

  if ( nm_woocommerce_activated() ) {
    wp_enqueue_script( 'nm-shop-quickview', HJ_URI . '/assets/js/haje-nm-shop-quickview.js', array( 'jquery', 'nm-shop', 'wc-add-to-cart-variation' ), NM_THEME_VERSION, true );

    if ( is_woocommerce() ) {

      if ( is_product() ) {
        wp_enqueue_script( 'nm-shop-single-product', HJ_URI . '/assets/js/haje-nm-shop-single-product.js', array( 'jquery', 'nm-shop' ), NM_THEME_VERSION, true );
      }
      else {
        wp_enqueue_script( 'nm-shop-filters', HJ_URI . '/assets/js/haje-nm-shop-filters.js', array( 'jquery', 'nm-shop' ), NM_THEME_VERSION, true );
      }
    }
  }
}

// add_action( 'wp_enqueue_scripts', 'hj_wc_scripts', 9 );
// function hj_wc_scripts() {
//   if ( is_cart() )
//     wp_enqueue_script( 'wc-cart', HJ_URI . '/assets/js/woocommerce/cart.js', array( 'jquery', 'wc-country-select', 'wc-address-i18n' ) );
// }


/**
 * Main javascripts.
 */

add_action( 'wp_footer', 'hj_footer' );
function hj_footer() {
  if ( is_admin() ) return;

  $js_vars = array(
    'login_url' => wp_login_url( get_permalink() ),
    'logout_url' => wp_logout_url( get_permalink() )
  );

  wp_enqueue_script( 'haje-main', HJ_URI . '/assets/js/haje.js', array( 'haje-vendor' ), HJ_VERSION );
  wp_localize_script( 'haje-main', '_hj_vars', $js_vars );

  // echo "<script type='text/javascript' src='" . HJ_URI . '/assets/js/vendor.js' . "'></script>\n";
  // echo "<script type='text/javascript' src='" . HJ_URI . '/assets/js/haje.js' . "'></script>\n";

  // if ( is_page( 'Coming Soon' ) ) {
  //   echo "<script type='text/javascript' src='" . HJ_URI . '/assets/js/comingsoon.js' . "'></script>\n";
  // }
}


add_action( 'login_enqueue_scripts', 'hj_login' );
function hj_login() {
  echo '<link href="/wp-content/uploads/2016/09/haje-icon-accented-512.png" rel="shortcut icon">';
  wp_enqueue_style( 'haje-login', HJ_URI . '/assets/css/login.css', array( ), HJ_VERSION );
  wp_enqueue_script( 'haje-login', HJ_URI . '/assets/js/login.js', array( 'jquery' ), HJ_VERSION, true );
}

add_filter( 'login_headerurl', 'hj_login_logo_url' );
function hj_login_logo_url() {
  return home_url();
}

//Dequeue Styles
function hj_dequeue_unnecessary_styles() {
  if ( !current_user_can( 'update_core' ) ) {
    wp_deregister_style('dashicons');
  }
  wp_dequeue_style( 'magnific.popup.css' );
  wp_deregister_style( 'magnific.popup.css' );
}
add_action( 'wp_print_styles', 'hj_dequeue_unnecessary_styles' );

//Dequeue JavaScripts
function hj_dequeue_unnecessary_scripts() {
  wp_dequeue_script( 'magnific.popup.js' );
  wp_deregister_script( 'magnific.popup.js' );
}
add_action( 'wp_print_scripts', 'hj_dequeue_unnecessary_scripts' );
