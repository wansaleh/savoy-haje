<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-item-data.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require dirname(__FILE__) . '/../../includes/color-names.php';

$product_id = null;
foreach ( $item_data as $data ) {
	if ($data['key'] == 'product_id')
		$product_id = $data['value'];
}

?>
<ul class="variation">
	<?php foreach ( $item_data as $data ) :
		if ($data['key'] == 'product_id')
			continue;

		if ( $product_id ) {
			$hexes = hj_get_hexes( wc_get_product( $product_id ) );

			$hex = '';

			if ($data['key'] == 'Color') {
				$color = strtolower(trim($data['display']));

				$hex = ' data-color="' . $color . '"';

				if ( array_key_exists( $color, $hexes ) ) {
					$hex .= ' data-hex="' . $hexes[$color] . '"';
				} elseif ( array_key_exists( $color, $haje_color_names_flipped_lowercase ) ) {
					$hex .= ' data-hex="' . $colors[$color] . '"';
				}
			}
		}

	?>
		<li>
            <div class="variation-<?php echo sanitize_html_class( $data['key'] ); ?>"><?php echo wp_kses_post( $data['key'] ); ?>:</div>
            <div class="variation-<?php echo sanitize_html_class( $data['key'] ); ?>"<?php echo $hex; ?>><?php echo wp_kses_post( wpautop( $data['display'] ) ); ?></div>
        </li>
	<?php endforeach; ?>
</ul>
