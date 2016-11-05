<?php

add_shortcode( 'svg_curve_divider', 'svg_curve_divider' );
function svg_curve_divider() {
  $output = ob_start();
  ?>
  <svg viewBox="0 0 1280 110" preserveAspectRatio="none" class="header-curve-shadow"><path d="M1280 3.9V110H0C194 71.33 662-19.9 1280 3.9z"></path></svg>
  <svg viewBox="0 0 1280 110" preserveAspectRatio="none" class="header-curve"><path d="M1280 3.9V110H0C194 71.33 662-19.9 1280 3.9z"></path></svg>
  <?php
  return ob_get_clean();
}

add_shortcode( 'svg_hexagons', 'svg_hexagons' );
function svg_hexagons() {
  $output = ob_start();
  ?>
  <svg class="hexagon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 848.2 979.5"><polygon points="843.2,731.7 424.1,973.7 5,731.7 5,247.8 424.1,5.8 843.2,247.8 "/></svg>
  <svg class="hexagon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 848.2 979.5"><polygon points="843.2,731.7 424.1,973.7 5,731.7 5,247.8 424.1,5.8 843.2,247.8 "/></svg>
  <svg class="hexagon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 848.2 979.5"><polygon points="843.2,731.7 424.1,973.7 5,731.7 5,247.8 424.1,5.8 843.2,247.8 "/></svg>
  <svg class="hexagon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 848.2 979.5"><polygon points="843.2,731.7 424.1,973.7 5,731.7 5,247.8 424.1,5.8 843.2,247.8 "/></svg>
  <?php
  return ob_get_clean();
}

add_shortcode( 'hi', 'hj_hi_shortcode' );
function hj_hi_shortcode( $atts, $content = null ) {
  return '<span class="accent">' . $content . '</span>';
}

add_shortcode( 'haje_address', 'hj_address' );
function hj_address( $atts ) {
  $a = shortcode_atts( array(
    'phone_email' => false
  ), $atts );

  $phone_email = "";
  if ($a['phone_email'])
    $phone_email = "<p><i class='fa fa-paper-plane'></i> <a href='/contact'>hello@haje.my</a>&nbsp;&nbsp;&middot;&nbsp;&nbsp;<i class='fa fa-phone'></i> +603 7733 1297</p>";

  return "
  <address>
    <p><b>Mikraj Concept Sdn. Bhd.</b><br>Company Reg. No. 1110211-K</p>
  </address>
  ";

  // return "
  // <address>
  //   <p><b>Haje, Mikraj Concept</b><br>F-LG-07, Neo Damansara<br>Jalan PJU 8/1, Damansara Perdana<br>47820 Petaling Jaya, Selangor, Malaysia</p>
  //   $phone_email
  // </address>
  // ";
}
