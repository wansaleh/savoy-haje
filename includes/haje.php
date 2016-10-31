<?php

define( 'HJ_VERSION', '1.1.1' );

// is_admin() or add_filter( 'locale', function() {
//   return 'ms_MY';
// });

add_action( 'after_setup_theme', 'hj_theme_support' );
function hj_theme_support() {
  load_theme_textdomain( 'savoy-haje', get_stylesheet_directory() . '/languages' );
}

function hj_uri( $relative_uri = "" ) {
  return get_stylesheet_directory_uri() . $relative_uri;
}

add_action( 'wp_head', 'hj_pace', 0 );
function hj_pace() {
  if ( is_admin() ) return;

  echo "<script type='text/javascript' src='" . hj_uri() . '/assets/bower_components/PACE/pace.min.js' . "'></script>\n";
  echo "<style>.pace{-webkit-pointer-events:none;pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none}.pace-inactive{display:none}.pace .pace-progress{background:#2979FF;position:fixed;z-index:2000;top:0;right:100%;width:100%;height:2px}</style>";
}

add_action( 'wp_head', 'hj_head_last', 10000 );
function hj_head_last() {
  if ( is_admin() ) return;

  echo "<link rel='stylesheet' href='" . hj_uri() . '/assets/css/haje.css?v=' . HJ_VERSION . "' type='text/css' media='all'>";
}

/**
 * Savoy javascript overrides.
 */

add_action( 'wp_enqueue_scripts', 'hj_scripts', 10000 );
function hj_scripts() {
  global $wp_scripts, $nm_theme_options, $nm_globals, $nm_page_includes;

  if ( is_admin() ) return;

  // wp_enqueue_style( 'haje-main', hj_uri() . '/assets/css/haje.css', array( 'nm-core' ), HJ_VERSION );

  wp_enqueue_script( 'haje-vendor', hj_uri() . '/assets/js/vendor.js', array( 'jquery' ), HJ_VERSION );

  wp_enqueue_script( 'nm-core', hj_uri() . '/assets/js/haje-nm-core.js', array( 'jquery' ), NM_THEME_VERSION, true );

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
    wp_enqueue_script( 'nm-shop-quickview', hj_uri() . '/assets/js/haje-nm-shop-quickview.js', array( 'jquery', 'nm-shop', 'wc-add-to-cart-variation' ), NM_THEME_VERSION, true );

    if ( is_woocommerce() ) {

      if ( is_product() ) {
        wp_enqueue_script( 'nm-shop-single-product', hj_uri() . '/assets/js/haje-nm-shop-single-product.js', array( 'jquery', 'nm-shop' ), NM_THEME_VERSION, true );
      }
      else {
        wp_enqueue_script( 'nm-shop-filters', hj_uri() . '/assets/js/haje-nm-shop-filters.js', array( 'jquery', 'nm-shop' ), NM_THEME_VERSION, true );
      }
    }
  }
}

add_action( 'wp_enqueue_scripts', 'hj_wc_scripts', 9 );
function hj_wc_scripts() {
  if ( is_cart() )
    wp_enqueue_script( 'wc-cart', hj_uri() . '/assets/js/woocommerce/cart.js', array( 'jquery', 'wc-country-select', 'wc-address-i18n' ) );
}


/**
 * Main javascripts.
 */

add_action( 'wp_footer', 'hj_footer' );
function hj_footer() {
  if ( is_admin() ) return;

  wp_enqueue_script( 'haje-main', hj_uri() . '/assets/js/haje.js', array( 'haje-vendor' ), HJ_VERSION );

  // echo "<script type='text/javascript' src='" . hj_uri() . '/assets/js/vendor.js' . "'></script>\n";
  // echo "<script type='text/javascript' src='" . hj_uri() . '/assets/js/haje.js' . "'></script>\n";

  // if ( is_page( 'Coming Soon' ) ) {
  //   echo "<script type='text/javascript' src='" . hj_uri() . '/assets/js/comingsoon.js' . "'></script>\n";
  // }
}

/**
 * Savoy menus.
 */

function nm_register_menus() {
  register_nav_menus( array(
    'top-bar-menu'  => __( 'Top Bar Menu', 'nm-framework' ),
    'main-menu'    => __( 'Main Menu', 'nm-framework' ),
    'right-menu'  => __( 'Right Menu', 'nm-framework' ),
    'mobile-menu'  => __( 'Mobile Menu', 'savoy-haje' ),
    'footer-menu'  => __( 'Footer Menu', 'nm-framework' )
  ) );
}

add_filter( 'body_class', 'hj_slug_body_class' );
function hj_slug_body_class( $classes ) {
  global $post;
  if ( isset( $post ) ) {
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}

add_filter( 'nm_myaccount_title', 'hj_myaccount_title' );
function hj_myaccount_title($title) {
  return 'Account';
}

add_action( 'login_enqueue_scripts', 'hj_login' );
function hj_login() {
  echo '<link href="/wp-content/uploads/2016/09/haje-icon-accented-512.png" rel="shortcut icon">';
  wp_enqueue_style( 'haje-login', hj_uri() . '/assets/css/login.css', array( ), HJ_VERSION );
  wp_enqueue_script( 'haje-login', hj_uri() . '/assets/js/login.js', array( 'jquery' ), HJ_VERSION, true );
}

add_filter( 'login_headerurl', 'hj_login_logo_url' );
function hj_login_logo_url() {
  return home_url();
}

add_action( 'wp_logout', create_function( '', 'wp_redirect(home_url()); exit();' ));

// add_action( 'admin_head', 'hj_admin_styles' );
function hj_admin_styles() {
  echo '<style>
    .menu-item-settings:after {
      content: "";
      display: table;
      clear: both;
    }
  </style>';
}


add_shortcode( 'hi', 'hj_hi_shortcode' );
function hj_hi_shortcode( $atts, $content = null ) {
  return '<span class="accent">' . $content . '</span>';
}

add_shortcode( 'haje_address', 'hj_address' );
function hj_address( $atts ) {
  $a = shortcode_atts( array(
    'phone_email' => false
  ), $atts );

  $phone_email = "";
  if ($a['phone_email'])
    $phone_email = "<p><i class='fa fa-paper-plane'></i> <a href='/contact'>hello@haje.my</a>&nbsp;&nbsp;&middot;&nbsp;&nbsp;<i class='fa fa-phone'></i> +603 7733 1297</p>";

  return "
  <address>
    <p><b>Haje, Mikraj Concept</b><br>F-LG-07, Neo Damansara<br>Jalan PJU 8/1, Damansara Perdana<br>47820 Petaling Jaya, Selangor, Malaysia</p>
    $phone_email
  </address>
  ";
}

add_filter( 'widget_title', 'hj_html_widget_title' );
function hj_html_widget_title( $var) {
  $var = str_replace( '[', '<', $var );
  $var = str_replace( ']', '>', $var );
  return $var;
}

add_filter( 'get_terms_args', 'hj_convert_include', 10, 2 );
function hj_convert_include($query, $taxonomies) {
  if ( $query['include'] && is_string( $query['include'] ) && strpos( $query['include'], ',' ) !== false ) {
    $query['include'] = explode( ',', $query['include'] );
  }

  return $query;
}

add_action( 'redux/options/nm_theme_options/saved', 'hj_custom_styles', 100 );
function hj_custom_styles() {
  global $nm_theme_options;

  ob_start();
?>
$clr-highlight: <?php echo esc_attr( $nm_theme_options['highlight_color'] ); ?>;
$clr-main-font: <?php echo esc_attr( $nm_theme_options['main_font_color'] ); ?>;
$clr-heading: <?php echo esc_attr( $nm_theme_options['heading_color'] ); ?>;
$clr-button-bg: <?php echo esc_attr( $nm_theme_options['button_background_color'] ); ?>;
$clr-button-font: <?php echo esc_attr( $nm_theme_options['button_font_color'] ); ?>;
$clr-topbar-bg: <?php echo esc_attr( $nm_theme_options['top_bar_background_color'] ); ?>;
$clr-nav: <?php echo esc_attr( $nm_theme_options['header_navigation_color'] ); ?>;
$clr-nav-hover: <?php echo esc_attr( $nm_theme_options['header_navigation_highlight_color'] ); ?>;
$clr-saleflash-bg: <?php echo esc_attr( $nm_theme_options['sale_flash_background_color'] ); ?>;
$clr-saleflash-font: <?php echo esc_attr( $nm_theme_options['sale_flash_font_color'] ); ?>;
$clr-single-bg: <?php echo esc_attr( $nm_theme_options['single_product_background_color'] ); ?>;
$clr-grey-bg: <?php echo esc_attr( $nm_theme_options['footer_widgets_background_color'] ); ?>;

<?php
  if ( $nm_theme_options['main_font_source'] == 1 && $nm_theme_options['main_font']['font-family'] != '' ) : ?>
$font-primary: '<?php echo esc_attr( $nm_theme_options['main_font']['font-family'] ); ?>';
<?php
  endif;
  if ( $nm_theme_options['secondary_font_source'] == 1 && $nm_theme_options['secondary_font']['font-family'] != '' ) : ?>
$font-secondary: '<?php echo esc_attr( $nm_theme_options['secondary_font']['font-family'] ); ?>';
<?php
  endif;
  file_put_contents( get_stylesheet_directory() . '/assets/_source/css/includes/_savoy-settings.scss', ob_get_clean() );
}

add_action( 'admin_print_footer_scripts', 'haje_iris_palette' );
add_action( 'customize_controls_print_footer_scripts', 'haje_iris_palette' );
function haje_iris_palette() {
?>
<script>
jQuery(document).ready(function($){
  $.wp.wpColorPicker.prototype.options = {
    palettes: ['#ffffff', '#282828', '#777777', '#2979FF', '#E91E63', '#00C853', '#FF9800', '#607D8B']
  };
});
</script>
<?php
}

// Remove nags here
add_action( 'admin_print_styles', 'haje_admin_style' );
function haje_admin_style() {
?>
<style type="text/css">
  .update-nag.bsf-update-nag {
    display: none;
  }
</style>
<?php
}
