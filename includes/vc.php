<?php

add_action( 'vc_after_init', 'add_row_type' ); /* Note: here we are using vc_after_init because WPBMap::GetParam and mutateParame are available only when default content elements are "mapped" into the system */
function add_row_type() {
  vc_set_shortcodes_templates_dir( get_stylesheet_directory() . '/element-templates' );

  $param = WPBMap::getParam( 'vc_row', 'type' );
  $param['param_name'] = 'type';
  $param['value'] = array(
    'Full'				=> 'full',
    'Full (no padding)'	=> 'full-nopad',
    'Full (boxed)'	=> 'full-boxed',
    'Boxed' 			=> 'boxed'
  );
  vc_update_shortcode_param( 'vc_row', $param );
}
