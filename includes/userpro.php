<?php

remove_action('admin_notices', 'userpro_admin_notices');
remove_action('userpro_pre_form_message', 'userpro_trial_notice');

add_action( 'admin_print_styles', 'hj_userpro_admin' );
function hj_userpro_admin() {
?>
<style type="text/css">
  .userpro-admin-badge img {
    width: 16px;
    height: 16px;
  }
</style>
<?php
}

add_action( 'wp_enqueue_scripts', 'hj_userpro_css' );
function hj_userpro_css() {
  if ( is_admin() ) return;

  // UserPro things
  remove_filter( 'style_loader_src', 'up_remove_wp_ver_css_js', 9999 );
  remove_filter( 'script_loader_src','up_remove_wp_ver_css_js', 9999 );

  // userpro things
  if ( !userpro_get_option('rtl') ) {
    $css = 'css/userpro.min.css';
  } else {
    $css = 'css/userpro-rtl.min.css';
  }
  wp_enqueue_style( 'userpro_min', userpro_url . $css );

  wp_enqueue_style( 'haje-userpro', HJ_URI . '/assets/css/userpro.css', array( ), HJ_VERSION );
}
