<?php

add_filter( 'show_admin_bar', '__return_false', 999999 );

// add_action( 'admin_head', 'hj_admin_styles' );
// function hj_admin_styles() {
//   echo '<style>
//     .menu-item-settings:after {
//       content: "";
//       display: table;
//       clear: both;
//     }
//   </style>';
// }

// Remove nags here
add_action( 'admin_print_styles', 'haje_admin_style' );
function haje_admin_style() {
?>
<style type="text/css">
  .update-nag.bsf-update-nag {
    display: none;
  }

  .wppb-serial-notification {
    display: none;
  }
</style>
<?php
}



// add_action( 'wc_shipment_tracking_get_providers' , 'wc_shipment_tracking_add_custom_provider' );
// /**
//  * wc_shipment_tracking_add_custom_provider
//  *
//  * Adds custom provider to shipment tracking
//  * Change the country name, the provider name, and the URL (it must include the %1$s)
//  * Add one provider per line
// */
// function wc_shipment_tracking_add_custom_provider( $providers ) {
//   $providers['Malaysia']['Pos Laju'] = 'http://url.com?id=%1$s';
//
//   return $providers;
// }



// add_action( 'admin_init', 'clean_unwanted_caps' );
// function clean_unwanted_caps(){
//   $delete_caps = array(
//     'mymail_add_forms',
//     'mymail_add_lists',
//     'mymail_add_subscribers',
//     'mymail_bulk_delete_subscribers',
//     'mymail_change_plaintext',
//     'mymail_change_template',
//     'mymail_dashboard_widget',
//     'mymail_delete_forms',
//     'mymail_delete_lists',
//     'mymail_delete_subscribers',
//     'mymail_delete_templates',
//     'mymail_edit_autoresponders',
//     'mymail_edit_forms',
//     'mymail_edit_lists',
//     'mymail_edit_others_autoresponders',
//     'mymail_edit_subscribers',
//     'mymail_edit_templates',
//     'mymail_export_subscribers',
//     'mymail_import_subscribers',
//     'mymail_import_wordpress_users',
//     'mymail_manage_capabilities',
//     'mymail_manage_subscribers',
//     'mymail_manage_templates',
//     'mymail_save_template',
//     'mymail_see_codeview',
//     'mymail_update_templates',
//     'mymail_upload_templates',
//     'rcp_export_data',
//     'rcp_manage_discounts',
//     'rcp_manage_levels',
//     'rcp_manage_members',
//     'rcp_manage_payments',
//     'rcp_manage_settings',
//     'rcp_view_discounts',
//     'rcp_view_help',
//     'rcp_view_levels',
//     'rcp_view_members',
//     'rcp_view_payments',
//     'wysija_config',
//     'wysija_newsletters',
//     'wysija_stats_dashboard',
//     'wysija_style_tab',
//     'wysija_subscribers',
//     'wysija_theme_tab'
//   );
//   global $wp_roles;
//   foreach ($delete_caps as $cap) {
//     foreach (array_keys($wp_roles->roles) as $role) {
//       $wp_roles->remove_cap($role, $cap);
//     }
//   }
// }
