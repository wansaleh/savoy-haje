<?php

add_action( 'woocommerce_account_dashboard', 'hj_edar_dashboard' );
function hj_edar_dashboard() {
  if ( is_user_in_role( 'haje_edar' ) ) {
    $context = Timber::get_context();

    $context['discounts'] = array(
      array(10, 14, '5'),
      array(15, 24, '10'),
      array(25, 49, '15'),
      array(50, 99, '20'),
      array(100, 200, '25')
    );

    Timber::render('myaccount-edar.twig', $context);
  }
}


// function hj_custom_endpoints() {
//   add_rewrite_endpoint( 'edar', EP_ROOT | EP_PAGES );
// }
//
// add_action( 'init', 'hj_custom_endpoints' );
