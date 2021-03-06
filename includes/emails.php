<?php

// add_filter('wp_mail_from', 'hj_mail_from');
// add_filter('wp_mail_from_name', 'hj_mail_from_name');
// function hj_mail_from($old) {
//   return 'hello@haje.my';
// }
// function hj_mail_from_name($old) {
//   return 'Haje HQ';
// }

add_filter( 'woocommerce_email_headers', 'hj_woocommerce_email_headers', 10, 3 );
function hj_woocommerce_email_headers( $string, $low_stock, $product ) {
  return $string . "X-HAJE-WC: true\r\n";
};

add_filter( 'haet_mail_use_template', 'hj_haet_mail_use_template', 20, 2 );
function hj_haet_mail_use_template( $use_template, $mail ) {
  if ( is_string( $mail['headers'] ) && strpos( $mail['headers'], 'X-HAJE-WC: true' ) !== false ) {
    return false;
  }

  if ( is_array( $mail['headers'] ) && isset( $mail['headers']['X-HAJE-WC'] ) ) {
    return false;
  }

  return $use_template;
}

// remove_filter( 'wp_mail', array(Haet_Mail(), 'style_mail'), 12, 1 );
// add_filter( 'wp_mail', 'hj_wp_mail_filter' );
// function hj_wp_mail_filter( $orig_mail ) {
//
//   if ( class_exists("Haet_Mail") ) {
//     if ( is_string( $orig_mail['headers'] ) && strpos( $orig_mail['headers'], 'X-HAJE-WC: true' ) !== false ) {
//       return $orig_mail;
//     }
//
//     if ( is_array( $orig_mail['headers'] ) && isset( $orig_mail['headers']['X-HAJE-WC'] ) ) {
//       return $orig_mail;
//     }
//
//     $wp_html_mail = new Haet_Mail();
//     $new_mail = $wp_html_mail->style_mail($orig_mail);
//
//     return $new_mail;
//   }
//
//   return $orig_mail;
// }

add_action( 'wp_head', function() {
  if ( isset( $_REQUEST['testmail'] ) && $_REQUEST['testmail'] == 'marhaban' ) {
    $site_url = get_bloginfo('wpurl');
    $user_info = wp_get_current_user();
    $to = $user_info->user_email;

    $subject = "[Haje] Congratulations!";

    $context = Timber::get_context();
    $context['username'] = $user_info->display_name;

    $message = Timber::compile('emails/haje-edar-approved.twig', $context);

    $headers = array();

    // Send the message as HTML
    $headers['Content-Type'] = 'text/html';

    // Enable open tracking (requires HTML email enabled)
    $headers['X-PM-Track-Opens'] = true;

    // Send the email
    wp_mail( $to, $subject, $message, $headers );
  }
} );

add_action( 'set_user_role', 'hj_mail_haje_edar_approved', 10, 2);
function hj_mail_haje_edar_approved( $user_id, $new_role ) {
  global $wp_roles;

  if ( $new_role == 'haje_edar' ) {
    $new_role_name = $wp_roles->roles[$new_role]['name'];

    $site_url = get_bloginfo('wpurl');
    $user_info = get_userdata( $user_id );
    $to = $user_info->user_email;

    $subject = "[Haje] Congratulations, you are now a $new_role_name!";

    $context = Timber::get_context();
    $context['username'] = $user_info->display_name;

    $message = Timber::compile('emails/haje-edar-approved.twig', $context);

    $headers = array();

    // Send the message as HTML
    $headers['Content-Type'] = 'text/html';

    // Enable open tracking (requires HTML email enabled)
    $headers['X-PM-Track-Opens'] = true;

    // Send the email
    wp_mail( $to, $subject, $message, $headers );
  }
}
