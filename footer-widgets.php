<?php
	global $nm_theme_options;

	// Layout classes
	$border_class = ( $nm_theme_options['footer_widgets_border'] ) ? ' has-border' : '';
	$row_class = ' nm-row-' . $nm_theme_options['footer_widgets_layout'];

	// Grid columns class
	$columns_medium = ( intval( $nm_theme_options['footer_widgets_columns'] ) < 2 ) ? '1' : '2';
	$columns_class = apply_filters( 'nm_footer_widgets_columns_class', 'small-block-grid-1 medium-block-grid-' . $columns_medium . ' large-block-grid-' . $nm_theme_options['footer_widgets_columns'] );
?>

	<div class="nm-footer-widgets<?php echo esc_attr( $border_class ); ?> clearfix light">
			<!-- <svg class="mpc-separator mpc-separator--top mpc-separator-style--arrow-center" data-color="#ffffff" width="100%" height="30" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" style="fill: rgb(255, 255, 255);"><polygon points="0,100 0,-5 100,-5 100,100 50,5"></polygon></svg> -->

			<div class="bg-overlay"></div>
    	<div class="nm-footer-widgets-inner">
            <div class="nm-row <?php echo esc_attr( $row_class ); ?>">
                <div class="col-xs-12">
                    <ul class="nm-footer-block-grid <?php echo esc_attr( $columns_class ); ?>">
                        <?php dynamic_sidebar( 'footer' ); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php
	// echo do_shortcode('[instashow id="1"]');