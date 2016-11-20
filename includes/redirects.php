<?php

add_action( 'template_redirect', 'hj_edar_role_redirects' );
function hj_edar_role_redirects() {
  if ( ( is_page( 'edar' ) || is_page( 'edar/apply' ) ) && is_user_logged_in() ) {
    if ( is_user_in_role( 'haje_edar_unapproved' ) ) {
      wp_redirect( '/edar/waiting-confirmation/' );
      exit;
    }

    if ( is_user_in_role( 'haje_edar' ) ) {
      wp_redirect( '/shop/' );
      exit;
    }
  }
}



// add_action( 'template_redirect', 'hj_logged_in' );
// function hj_logged_in() {
//   if ( is_page('login') && is_user_logged_in() ) {
//     wp_redirect( home_url() );
//     exit;
//   }
//
//   if ( is_page('edar') && is_user_logged_in() && is_user_in_role( 'haje_edar' ) ) {
//     wp_redirect( '/shop/category/edar/' );
//   }
// }

// add_action( 'wp_logout', create_function( '', 'wp_redirect(home_url()); exit();' ));

// function wc_custom_user_redirect( $redirect, $user ) {
//   // Get the first of all the roles assigned to the user
//   $role = $user->roles[0];
//   $dashboard = admin_url();
//   $myaccount = get_permalink( wc_get_page_id( 'myaccount' ) );
//   if ( $role == 'haje-edar' ) {
//     //Redirect customers and subscribers to the "My Account" page
//     $redirect = $myaccount;
//   } else {
//     //Redirect any other role to the previous visited page or, if not available, to the home
//     $redirect = wp_get_referer() ? wp_get_referer() : home_url();
//   }
//   return $redirect;
// }
// add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 );
