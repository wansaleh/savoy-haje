<?php

$hj_version = '1.1';

function hj_uri($relative_uri = "") {
  return get_stylesheet_directory_uri() . $relative_uri;
}

add_action( 'wp_head', 'hj_head', 10000 );
function hj_head() {
  if ( is_admin() ) return;

  echo "<link rel='stylesheet' href='" . hj_uri('/assets/css/haje.css') . "' type='text/css' media='all'>";
  echo "<script src='https://cdn.polyfill.io/v2/polyfill.min.js'></script>";
}

/**
 * Savoy javascript overrides.
 */

add_action( 'wp_enqueue_scripts', 'hj_scripts', 10000 );
function hj_scripts() {
  if ( nm_woocommerce_activated() ) {
    wp_enqueue_script('nm-shop-quickview', hj_uri('/assets/js/haje-nm-shop-quickview.js'), array( 'jquery', 'nm-shop', 'wc-add-to-cart-variation' ), NM_THEME_VERSION);

    if ( is_woocommerce() ) {

      if ( is_product() ) {
        wp_enqueue_script( 'nm-shop-single-product', hj_uri('/assets/js/haje-nm-shop-single-product.js'), array( 'jquery', 'nm-shop' ), NM_THEME_VERSION );
      }
      else {
        wp_enqueue_script('nm-shop-filters', hj_uri('/assets/js/haje-nm-shop-filters.js'), array( 'jquery', 'nm-shop' ), NM_THEME_VERSION);
      }
    }
  }
}

/**
 * Main javascripts.
 */

add_action( 'wp_footer', 'hj_footer' );
function hj_footer() {
  global $hj_version;

  if ( ! is_admin() ) {

    wp_enqueue_script('haje-vendor', hj_uri('/assets/js/vendor.js'), array( 'jquery' ), NM_THEME_VERSION);
    wp_enqueue_script('haje-main', hj_uri('/assets/js/haje.js'), array( 'haje-vendor' ), NM_THEME_VERSION);

    // echo "<script type='text/javascript' src='" . hj_uri('/assets/js/vendor.js') . "'></script>\n";
    // echo "<script type='text/javascript' src='" . hj_uri('/assets/js/haje.js') . "'></script>\n";

    // if ( is_page( 'Coming Soon' ) ) {
    //   echo "<script type='text/javascript' src='" . hj_uri('/assets/js/comingsoon.js') . "'></script>\n";
    // }
  }
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
  global $hj_version;

  echo '<link href="/wp-content/uploads/2016/09/haje-icon-accented-512.png" rel="shortcut icon">';
  echo "<link rel='stylesheet' href='" . hj_uri('/assets/css/login.css') . "' type='text/css' media='all'>";
  wp_enqueue_script('haje-login', hj_uri('/assets/js/login.js'), array('jquery'), $hj_version);
}

add_filter( 'login_headerurl', 'hj_login_logo_url' );
function hj_login_logo_url() {
  return home_url();
}

add_action('wp_logout', create_function('', 'wp_redirect(home_url()); exit();'));

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
  $var = (str_replace( '[', '<', $var ));
  $var = (str_replace( ']', '>', $var ));
  return $var;
}

add_filter( 'get_terms_args', 'hj_convert_include', 10, 2 );
function hj_convert_include($query, $taxonomies) {
  if ($query['include'] && is_string($query['include']) && strpos($query['include'], ',') !== false) {
    $query['include'] = explode(',', $query['include']);
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

<?php
  file_put_contents( get_stylesheet_directory() . '/assets/_source/css/includes/_colors-settings.scss', ob_get_clean() );
}

add_action('admin_print_footer_scripts', 'haje_iris_palette');
add_action('customize_controls_print_footer_scripts', 'haje_iris_palette');
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
add_action('admin_print_styles', 'haje_admin_style');
function haje_admin_style() {
?>
<style type="text/css">
  .update-nag.bsf-update-nag {
    display: none;
  }
</style>
<?php
}
