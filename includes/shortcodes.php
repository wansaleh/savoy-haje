<?php

add_shortcode( 'user_account_link', 'hj_user_account_link' );
function hj_user_account_link( $atts ) {
  if ( is_user_logged_in() ) {
    $current_user = wp_get_current_user();
    return "<a href='/account/'>$current_user->user_login</a>";
  }
  return $content;
}

add_shortcode( 'USER', 'show_user_content' );
function show_user_content( $atts, $content = null ) {
  if ( !is_user_logged_in() ) {
    return "";
  }
  return $content;
}
add_shortcode( 'GUEST', 'show_guest_content' );
function show_guest_content( $atts, $content = null ) {
  if ( is_user_logged_in() ) {
    return "";
  }
  return $content;
}

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

add_shortcode( 'kurta_cta', 'hj_kurta_cta' );
function hj_kurta_cta( $atts ) {
  $a = shortcode_atts( array(
    'id' => false
  ), $atts );

  $product = wc_get_product( $a['id'] );
  $permalink = get_permalink( $a['id'] );
  $sizes = $product->get_attribute( 'size' );
  $sizes = preg_split( "/\s?\,\s?/", trim( $sizes ) );

  $out = "";

  if ( ! empty( $sizes ) ) {
    $count = count( $sizes );
    $out .= "<ul class='home-size-list'>";
    $out .= "<li class='size-count'>Available in $count sizes</li>";

    foreach ( $sizes as $size ) {
      $out .= "<li><a href='$permalink?attribute_pa_size=$size'>$size</a></li>";
    }

    $out .= "</ul>";
  }

  $can_be_preordered = WC_Pre_Orders_Product::product_can_be_pre_ordered( $product );

  $action = !$can_be_preordered ? "Buy" : "Pre-Order";

  $preorder_timestamp = WC_Pre_Orders_Product::get_localized_availability_datetime_timestamp( $product );
  $td = human_time_diff( current_time('timestamp'), $preorder_timestamp );
  preg_match('/(\d+)\s(weeks|days)/i', $td, $matches);
  $newtd = $matches[1] . '&ndash;' . ($matches[1] + 1) . ' ' . $matches[2];

  $preorder_info = !$can_be_preordered ? '' :
    '<div class="home-pre-order">' .
    'Ready to ship in ' .
    $newtd . '.</div>';

  ob_start();
  ?>
  <div class="home-kurta-price">
    <?php echo $product->get_price_html(); ?>
  </div>
  <div class="home-kurta-cta">
    <a href="<?php echo $permalink; ?>" class="nm_btn nm_btn_lg nm_btn_filled">
      <span class="nm_btn_title"><?php echo $action; ?> <?php echo preg_replace( '/^Kurta\s/', '', $product->get_title() ); ?></span>
      <span class="nm_btn_bg"></span>
    </a>
  </div>
  <?php echo $preorder_info; ?>
  <?php

  $out .= ob_get_clean();

  return $out;
}

add_shortcode( 'sizeguide_img', 'hj_sizeguide_img' );
function hj_sizeguide_img() {
  return '<img class="alignright" style="width: 200px; margin-top: -80px;" src="' . HJ_URI . '/assets/images/sizechart.svg" alt="sizeguide">';
}
