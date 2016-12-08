<?php

add_filter( 'validate_username', 'hj_validate_username', 10, 2 );
function hj_validate_username( $valid, $username ) {
  $sanitized = sanitize_user( $username, true );
  $valid = ( $sanitized == $username && ! empty( $sanitized ) && strpos( $username, " " ) === false );

  return $valid;
}

// add_filter( 'gform_field_validation_1_1', 'hj_gforms_username', 10, 4 );
// function hj_gforms_username( $result, $value, $form, $field ) {
//   if ( $result['is_valid'] && !preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $value) ) {
//     $result['is_valid'] = false;
//     $result['message'] = 'Usernames cannot contain invalid characters.';
//   }
//   return $result;
// }

// add_action( 'gform_user_registration_validation', 'hj_gforms_username', 10, 3 );
// function hj_gforms_username( $form, $feed, $submitted_page ) {
//   global $path;
//   $meta = rgar( $feed, 'meta' );
//
//   $entry = GFFormsModel::get_current_lead();
//
//   $username_field = GFFormsModel::get_field( $form, $meta['username'] );
//   $username       = gf_user_registration()->get_meta_value( 'username', $meta, $form, $entry );
//
//   if ( !validate_username( $username ) || strpos( $username, " " ) !== false ) {
//     $username_valid = false;
//     $form           = gf_user_registration()->add_validation_error( $meta['username'], $form, __( 'The username can only contain alphanumeric characters (A-Z, 0-9), underscores and dashes.', 'savoy-haje' ) );
//   }
//
//   // if ( ! preg_match( '~^[a-z0-9]{1}[a-z0-9._-]{3,18}[a-z0-9]{1}$~i', $username ) ) {
//   //   $error_msg = 'Usernames cannot contain invalid characters.';
//   //   $form = gf_user_registration()->add_validation_error( $meta['username'], $form, $error_msg );
//   // }
//
//   return $form;
// }
