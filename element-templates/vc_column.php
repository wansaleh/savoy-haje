<?php

	$output = $font_color = $el_class = $width = $offset = '';
	extract(shortcode_atts(array(
		'font_color'	=> '',
		'el_class' 		=> '',
		'width' 		=> '1/1',
		'css' 			=> '',
		'offset' 		=> '',
        'css_animation' => ''
	), $atts));
	
    //$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
	$el_class = $this->getExtraClass($el_class);
    // Fix: $css_animation should be empty when animation is disabled but returns "none" instead (see "getCSSAnimation()" in "../js_composer/include/classes/shortcodes/shortcodes.php")
    if ( $css_animation !== 'none' ) {
        $el_class .= $this->getCSSAnimation( $css_animation );
    }
	$el_class .= ' nm_column';
	
	$width = wpb_translateColumnWidthToSpan($width);
	$width = vc_column_offset_class_merge($offset, $width);
	$width = str_replace( 'vc_', '', $width ); // Remove 'vc_' prefix(es)
	
	$style = $this->buildStyle( $font_color );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
	
	$output .= "\n\t".'<div class="'.$css_class.'"'.$style.'>';
	$output .= "\n\t\t".'<div class="wpb_wrapper">';
	$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
	$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
	$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";
	
	echo $output;
