<?php

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
