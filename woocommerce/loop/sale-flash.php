<?php
/**
 * Product loop sale flash
 *
 * @author 	WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $nm_theme_options;

?>
<div class="product_flash">
<?php if ( $nm_theme_options['product_sale_flash'] && $product->is_on_sale() ) : ?>

	<?php
		// Output percentage or text "sale flash"
		if ( $nm_theme_options['product_sale_flash'] !== 'txt' ) {
			$sale_percent = nm_product_get_sale_percent( $product );

			if ( $sale_percent > 0 ) {
				echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span class="nm-onsale-before">Save </span>' . $sale_percent . '<span class="nm-onsale-after">%</span></span>', $post, $product );
			}
		} else {
			$sale_text = __( 'Sale!', 'woocommerce' );

			echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . $sale_text . '</span>', $post, $product );
		}
	?>

<?php endif;

$postdate = get_the_time ( 'Y-m-d' );
$postdatestamp = strtotime ( $postdate );
$newness = 10;
if ((time () - (60 * 60 * 24 * $newness)) < $postdatestamp) {
	echo '<span class="isnew">New</span>';
}

?>
</div>
