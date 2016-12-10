<?php

// function hj_filter_html($buffer) {
//   $urlOut=preg_replace('/https?:/i','',$urlIn);
//   return $urlOut;
//   // modify buffer here, and then return the updated code
//   return $buffer;
// }
//
// function buffer_start() { ob_start("hj_filter_html"); }
//
// function buffer_end() { ob_end_flush(); }
//
// add_action( 'wp_loaded', 'buffer_start' );
// add_action( 'shutdown', 'buffer_end' );

add_action('wp_head', 'hj_prefetch', 2);
function hj_prefetch() {
  echo "<link rel='dns-prefetch' href='//www.google-analytics.com'>\n";
  echo "<link rel='dns-prefetch' href='//apis.google.com'>\n";
  echo "<link rel='dns-prefetch' href='//content.googleapis.com'>\n";
  echo "<link rel='dns-prefetch' href='//connect.facebook.net'>\n";
}

function get_user_roles() {
  $user = wp_get_current_user();
  return empty( $user ) ? array() : $user->roles;
}

function is_user_in_role( $role ) {
  return in_array( $role, get_user_roles() );
}

// is_admin() or add_filter( 'locale', function() {
//   return 'ms_MY';
// });

// add_filter( 'body_class', 'hj_adjust_body_class', 99999 );
// function hj_adjust_body_class( $classes ) {
//
//   // if ( isset( $_GET['page'] ) && $_GET['page'] == 'gf_activation' ) {
//   //   foreach ( $classes as $key => $value ) {
//   //     if ( $value == 'header-light' || $value == 'header-transparency' ) {
//   //       unset( $classes[ $key ] );
//   //       $classes[] = 'gf-activation';
//   //     }
//   //   }
//   // }
//
//   return $classes;
// }

// Add role class to body
add_filter( 'body_class','hj_add_role_to_body' );
function hj_add_role_to_body( $classes ) {
  global $current_user;

  foreach ( $current_user->roles as $role ) {
    $classes[] = 'role-'. $role;
  }

  return $classes;
}

add_filter( 'body_class', 'hj_slug_body_class' );
function hj_slug_body_class( $classes ) {
  global $post;
  if ( isset( $post ) ) {
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}

add_action( 'after_setup_theme', 'hj_theme_support' );
function hj_theme_support() {
  load_theme_textdomain( 'savoy-haje', get_stylesheet_directory() . '/languages' );
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


add_filter( 'nm_myaccount_title', 'hj_myaccount_title' );
function hj_myaccount_title($title) {
  return 'Account';
}

add_filter( 'widget_title', 'hj_html_widget_title' );
function hj_html_widget_title( $var) {
  $var = str_replace( '[', '<', $var );
  $var = str_replace( ']', '>', $var );
  return $var;
}

// add_filter( 'get_terms_args', 'hj_convert_include', 10, 2 );
// function hj_convert_include($query, $taxonomies) {
//   if ( $query['include'] && is_string( $query['include'] ) && strpos( $query['include'], ',' ) !== false ) {
//     $query['include'] = explode( ',', $query['include'] );
//   }
//
//   return $query;
// }

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
$clr-footer-bg: <?php echo esc_attr( $nm_theme_options['footer_widgets_background_color'] ); ?>;
$clr-footer-text: <?php echo esc_attr( $nm_theme_options['footer_widgets_font_color'] ); ?>;
$clr-footer-title: <?php echo esc_attr( $nm_theme_options['footer_widgets_title_font_color'] ); ?>;
$clr-footer-highlight: <?php echo esc_attr( $nm_theme_options['footer_widgets_highlight_font_color'] ); ?>;

<?php
  if ( $nm_theme_options['main_font_source'] == 1 && $nm_theme_options['main_font']['font-family'] != '' ) : ?>
$font-primary: '<?php echo esc_attr( $nm_theme_options['main_font']['font-family'] ); ?>';
<?php
  elseif ( $nm_theme_options['main_font_source'] == 2 && $nm_theme_options['main_typekit_font'] != '' ) : ?>
$font-primary: '<?php echo esc_attr( $nm_theme_options['main_typekit_font'] ); ?>';
<?php
  endif;

  if ( $nm_theme_options['secondary_font_source'] == 1 && $nm_theme_options['secondary_font']['font-family'] != '' ) : ?>
$font-secondary: '<?php echo esc_attr( $nm_theme_options['secondary_font']['font-family'] ); ?>';
<?php
  elseif ( $nm_theme_options['secondary_font_source'] == 2 && $nm_theme_options['secondary_typekit_font'] != '' ) : ?>
  $font-secondary: '<?php echo esc_attr( $nm_theme_options['secondary_typekit_font'] ); ?>';
<?php
  endif;
  file_put_contents( get_stylesheet_directory() . '/_source/css/includes/_savoy-settings.scss', ob_get_clean() );
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
