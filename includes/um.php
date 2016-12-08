<?php

/* add new tab called "edar" */

add_filter('um_account_page_default_tabs_hook', 'my_custom_tab_in_um', 100 );
function my_custom_tab_in_um( $tabs ) {
  $role = um_user('role');

  if ( $role == 'haje-edar' ) {
    $tabs[800]['edar']['icon'] = 'icon-haje-logo';
    $tabs[800]['edar']['title'] = 'Haje Edar';
    $tabs[800]['edar']['custom'] = true;
  }

  return $tabs;
}

/* make our new tab hookable */

add_action('um_account_tab__edar', 'um_account_tab__edar');
function um_account_tab__edar( $info ) {
  global $ultimatemember;
  extract( $info );

  $output = $ultimatemember->account->get_tab_output('edar');
  if ( $output ) { echo $output; }
}

/* Finally we add some content in the tab */

add_filter('um_account_content_hook_edar', 'um_account_content_hook_edar');
function um_account_content_hook_edar( $output ){
  $role = um_user('role');
  if ( $role == 'haje-edar' ) {
    $context = Timber::get_context();

    $context['discounts'] = array(
      array(15, 49, '15'),
      array(50, 99, '20'),
      array(100, 199, '25'),
      array(200, 500, '30'),
    );


    $output = '<div class="um-field">';
    $output .= Timber::compile('myaccount-edar.twig', $context);
    $output .= '</div>';
  }

  return $output;
}
