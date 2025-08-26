<?php

/*-----------------------------------------------------------------------------------*/
/* REDUX - speciable */
/*-----------------------------------------------------------------------------------*/

// editor style

add_action( 'init', 'dotorg_add_editor_styles' );
function dotorg_add_editor_styles() {
	$font_url = add_query_arg( 'family', urlencode( 'Lora:400,700,400italic,700italic|Libre Franklin:400|Poppins:400,500,600,700&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
 	add_editor_style(  array($font_url, 'styles/reduxfall.css') );
}

// detect plugin 
if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
} else {
	
	function tmnf_enqueue_reduxfall() {
		
		// Redux fallback
		wp_enqueue_style('tmnf-reduxfall', get_template_directory_uri() . '/styles/reduxfall.css');
		
		// google link
		function tmnf_fonts_url() {
			$font_url = '';
			if ( 'off' !== esc_html( _x( 'on', 'Google font: on or off','dotorg')) ) {
				$font_url = add_query_arg( 'family', urlencode( 'Libre Franklin:400,700,400italic,700italic,800italic,900italic|Poppins:400,700,400italic,700italic&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
			}
			return $font_url;
		}
    	wp_enqueue_style( 'tmnf-fonts', tmnf_fonts_url(), array(), '1.0.0' );

		
	}
	add_action( 'wp_enqueue_scripts', 'tmnf_enqueue_reduxfall' );
	
}

/*-----------------------------------------------------------------------------------*/
/* THE END */
/*-----------------------------------------------------------------------------------*/
?>