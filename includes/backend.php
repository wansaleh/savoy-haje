<?php

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
