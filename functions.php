<?php

/*-----------------------------------------------------------------------------------
- Default
----------------------------------------------------------------------------------- */

add_action( 'after_setup_theme', 'dotorg_theme_setup' );

function dotorg_theme_setup() {
	global $content_width;

	/* Set the $content_width for things such as video embeds. */
	if ( !isset( $content_width ) )
		$content_width = 750;

	/* Add theme support for automatic feed links. */
	add_theme_support( 'post-formats', array( 'video','audio', 'gallery','quote', 'link', 'aside' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	
	
	/* Add theme support for post thumbnails (featured images). */	
	add_theme_support('post-thumbnails');
	add_image_size('dotorg_header', 1500, 400, true ); 		//(cropped)
	add_image_size('dotorg_single', 758, 9999 ); 				//(un-cropped)
	add_image_size('dotorg_small', 380, 301, true ); 			//(cropped)
	add_image_size('dotorg_tabs', 60, 60, true ); 			//(cropped)
	

	/* Add custom menus */
	register_nav_menus(array(
		'magazine-menu' => esc_html__( 'Main Menu','dotorg' ),
		'bottom-menu' => esc_html__( 'Footer Menu','dotorg' ),
	));

	/* Add your sidebars function to the 'widgets_init' action hook. */
	add_action( 'widgets_init', 'dotorg_register_sidebars' );
	
	/* Make theme available for translation */
	load_theme_textdomain('dotorg', get_template_directory() . '/lang' );

}

function dotorg_register_sidebars() {
	
	register_sidebar(array('name' => esc_html__( 'Sidebar','dotorg' ),'id' => 'tmnf-sidebar','description' => esc_html__( 'Sidebar widget section (displayed on posts / blog)','dotorg' ),'before_widget' => '<div class="sidebar_item">','after_widget' => '</div>','before_title' => '<h2 class="widget">','after_title' => '</h2>'));
	
	register_sidebar(array('name' => esc_html__( 'Sidebar (for Pages)','dotorg' ),'id' => 'tmnf-sidebar-pages','description' => esc_html__( 'Sidebar widget section (displayed on pages / donations)','dotorg' ),'before_widget' => '<div class="sidebar_item">','after_widget' => '</div>','before_title' => '<h2 class="widget">','after_title' => '</h2>'));
	

	//footer widgets
	register_sidebar(array('name' => esc_html__( 'Footer 1','dotorg' ),'id' => 'tmnf-footer-1','description' => esc_html__( 'Widget section in footer - left','dotorg' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget dekoline">','after_title' => '</h2>'));
	register_sidebar(array('name' => esc_html__( 'Footer 2','dotorg' ),'id' => 'tmnf-footer-2','description' => esc_html__( 'Widget section in footer - center/left','dotorg' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget dekoline">','after_title' => '</h2>'));
	register_sidebar(array('name' => esc_html__( 'Footer 3','dotorg' ),'id' => 'tmnf-footer-3','description' => esc_html__( 'Widget section in footer - center/right','dotorg' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget dekoline">','after_title' => '</h2>'));
	register_sidebar(array('name' => esc_html__( 'Footer 4','dotorg' ),'id' => 'tmnf-footer-4','description' => esc_html__( 'Widget section in footer - right','dotorg' ),'before_widget' => '','after_widget' => '','before_title' => '<h2 class="widget dekoline">','after_title' => '</h2>'));
	
	//woo widgets
	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(array('name' => esc_html__( 'Shop Sidebar','dotorg' ),'id' => 'tmnf-shop-sidebar','description' => esc_html__( 'Sidebar widget section (displayed on shop pages)','dotorg' ),'before_widget' => '<div class="sidebar_item">','after_widget' => '</div>','before_title' => '<h2 class="widget">','after_title' => '</h2>'));
	}
}

	
/*-----------------------------------------------------------------------------------
- Framework - Please refrain from editing this section 
----------------------------------------------------------------------------------- */


// Set path to Framework and theme specific functions
$functions_path = get_template_directory() . '/functions/';

// Theme specific functionality
require_once ($functions_path . 'admin-functions.php');					// Custom functions and plugins

require_once ($functions_path . 'posttypes/post-metabox.php'); 			// custom meta box

// Add Redux options panel
if ( !isset( $themnific_redux ) && file_exists( get_template_directory()  . '/redux-framework/redux-themnific.php' ) ) {
    require_once( get_template_directory()  . '/redux-framework/redux-themnific.php' );
}

	
/*-----------------------------------------------------------------------------------
- Enqueues scripts and styles for front end
----------------------------------------------------------------------------------- */ 

function dotorg_enqueue_style() {
	
	// Main stylesheet
	wp_enqueue_style( 'dotorg-style', get_stylesheet_uri());
	
	// Font Awesome css	
	wp_enqueue_style('fontawesome', get_template_directory_uri() .	'/styles/fontawesome.min.css');
	
}
add_action( 'wp_enqueue_scripts', 'dotorg_enqueue_style' );




// themnific custom css + chnage the order of how the sytlesheets are loaded, and overrides WooCommerce styles.
function dotorg_custom_order() {
	
	// place wooCommerce styles before our main stlesheet
	if ( class_exists( 'WooCommerce' ) ) {
		wp_dequeue_style( 'woocommerce_frontend_styles' );
		wp_enqueue_style('woocommerce_frontend_styles', plugins_url() .'/woocommerce/assets/css/woocommerce.css');
	
		wp_enqueue_style('dotorg-woo-custom', get_template_directory_uri().	'/styles/woo-custom.css');
		wp_enqueue_style('dotorg-mobile', get_template_directory_uri().'/style-mobile.css');
	} else {
		wp_enqueue_style('dotorg-mobile', get_template_directory_uri().'/style-mobile.css');
	}
}
add_action('wp_enqueue_scripts', 'dotorg_custom_order');


function dotorg_enqueue_script() {	

		// Load Common scripts	
		wp_enqueue_script('dotorg-ownscript', get_template_directory_uri() .'/js/ownScript.js',array( 'jquery' ),'', true);

		// Singular comment script		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

}
	
add_action('wp_enqueue_scripts', 'dotorg_enqueue_script');

/*-----------------------------------------------------------------------------------
- Include custom widgets
----------------------------------------------------------------------------------- */

include_once (get_template_directory() . '/functions/widgets/em-events.php');
include_once (get_template_directory() . '/functions/widgets/widget-social.php');
include_once (get_template_directory() . '/functions/widgets/widget-ads-300.php');
include_once (get_template_directory() . '/functions/widgets/widget-featured.php');
include_once (get_template_directory() . '/functions/widgets/widget-blog-list.php');


/*-----------------------------------------------------------------------------------
- TGM_Plugin_Activation class.
----------------------------------------------------------------------------------- */
require_once get_template_directory()  . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'dotorg_register_required_plugins' );
function dotorg_register_required_plugins() {

    $plugins = array(
	

        // REDUX
        array(
            'name'				=> esc_html__( 'Redux Framework','dotorg' ),
            'slug'      		=> 'redux-framework',
            'required'  		=> true,
        ),
        // ELEMENTOR
        array(
            'name'				=> esc_html__( 'Elementor','dotorg' ),
            'slug'      		=> 'elementor',
            'required'  		=> true,
        ),        
		// ELESLIDER
        array(
            'name'				=> esc_html__( 'Eleslider','dotorg' ),
            'slug'      		=> 'eleslider',
            'required'  		=> false,
        ),

    );
    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins','dotorg' ),
            'menu_title'                      => esc_html__( 'Install Plugins','dotorg' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s','dotorg' ), // %s = plugin name.
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.','dotorg' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.','This theme requires the following plugins: %1$s.','dotorg' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.','This theme recommends the following plugins: %1$s.','dotorg' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.','dotorg' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.','dotorg' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.','dotorg' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.','dotorg' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.','dotorg' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.','dotorg' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins','dotorg' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins','dotorg' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer','dotorg' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.','dotorg' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s','dotorg' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}
/*-----------------------------------------------------------------------------------
- Google Data
----------------------------------------------------------------------------------- */
/* Add Google Tag Manager javascript code as close to 
the opening <head> tag as possible
=====================================================*/
function add_gtm_head(){
?>
 
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TP2G9D4');</script>
<!-- End Google Tag Manager -->
 
<?php 
}
add_action( 'wp_head', 'add_gtm_head', 10 );
 
/* Add Google Tag Manager noscript codeimmediately after 
the opening <body> tag
========================================================*/
function add_gtm_body(){
?>
 
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TP2G9D4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
 
<?php 
}
add_action( 'body_top', 'add_gtm_body' );
	
/*-----------------------------------------------------------------------------------
- Other theme functions
----------------------------------------------------------------------------------- */

// icons - font awesome
function dotorg_icon() {
	
	if(has_post_format('audio')) {return '<i title="'. esc_html__('Audio','dotorg').'" class="tmnf_icon fas fa-volume-up"></i>';
	}elseif(has_post_format('gallery')) {return '<i title="'. esc_html__('Gallery','dotorg').'" class="tmnf_icon fas fa-camera"></i>';
	}elseif(has_post_format('image')) {return '<i title="'. esc_html__('Image','dotorg').'" class="tmnf_icon fas fa-camera"></i>';	
	}elseif(has_post_format('link')) {return '<i title="'. esc_html__('Link','dotorg').'" class="tmnf_icon fas fa-link"></i>';			
	}elseif(has_post_format('quote')) {return '<i title="'. esc_html__('Quote','dotorg').'" class="tmnf_icon fas fa-quote-right"></i>';		
	}elseif(has_post_format('video')) {return '<i title="'. esc_html__('Video','dotorg').'" class="tmnf_icon fas fa-play-circle"></i>';
	} else {}	
	
}


// link format
function dotorg_permalink() {
	$linkformat = get_post_meta(get_the_ID(), 'themnific_linkss', true);
	if($linkformat) echo esc_url($linkformat); else the_permalink();
}




// new excerpt function

// Old Shorten Excerpt text for use in theme
function dotorg_excerpt($text, $chars = 1620) {
	$text = $text." ";
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	$text = $text."";
	return $text;
}

function dotorg_trim_excerpt($text) {
     $text = str_replace('[', '', $text);
     $text = str_replace(']', '', $text);
     return $text;
    }
add_filter('get_the_excerpt', 'dotorg_trim_excerpt');





// automatically add prettyPhoto rel attributes to embedded images
function dotorg_gallery_prettyphoto ($content) {
	return str_replace("<a", "<a rel='prettyPhoto[gallery]'", $content);
}

function dotorg_insert_prettyphoto_rel($content) {
	$pattern = '/<a(.*?)href="(.*?).(bmp|gif|jpeg|jpg|png)"(.*?)>/i';
  	$replacement = '<a$1href="$2.$3" rel=\'prettyPhoto\'$4>';
	$content = preg_replace( $pattern, $replacement, $content );
	return $content;
}
add_filter( 'the_content', 'dotorg_insert_prettyphoto_rel' );
add_filter( 'wp_get_attachment_link', 'dotorg_gallery_prettyphoto');





// meta sections

function dotorg_meta_date() { ?>   
	<p class="meta meta_full <?php $themnific_redux = get_option( 'themnific_redux' ); if(isset($themnific_redux['tmnf-post-meta-dis']) ? $themnific_redux['tmnf-post-meta-dis'] : null) echo 'tmnf_hide';?>">
		<span class="post-date"><?php the_time(get_option('date_format')); ?></span>
    </p>
<?php }

function dotorg_meta_front() { ?>   
	<p class="meta meta_full <?php $themnific_redux = get_option( 'themnific_redux' ); if(isset($themnific_redux['tmnf-post-meta-dis']) ? $themnific_redux['tmnf-post-meta-dis'] : null) echo 'tmnf_hide';?>">
		<span class="post-date"><?php the_time(get_option('date_format')); ?></span>
    </p>
<?php }

function dotorg_meta_full() { ?>    
	<p class="meta meta_full <?php $themnific_redux = get_option( 'themnific_redux' ); if(isset($themnific_redux['tmnf-post-meta-dis']) ? $themnific_redux['tmnf-post-meta-dis'] : null) echo 'tmnf_hide';?>">
        <?php 
		echo '<span class="author"><i class="fas fa-user-circle" aria-hidden="true"></i> '; the_author_posts_link();echo '<span class="divider">|</span></span>';
		?>
		<span class="post-date"><i class="far fa-clock" aria-hidden="true"></i> <?php the_time(get_option('date_format')); ?><span class="divider">|</span></span>
		<span class="categs"><i class="far fa-file-alt" aria-hidden="true"></i> <?php the_category(', ') ?></span>
    </p>
<?php
}

function dotorg_meta_more() { ?>   
	<span class="meta meta_more <?php $themnific_redux = get_option( 'themnific_redux' ); if(isset($themnific_redux['tmnf-post-meta-dis']) ? $themnific_redux['tmnf-post-meta-dis'] : null) echo 'tmnf_hide';?>">
    		<a class="p-border" href="<?php dotorg_permalink() ?>"><?php esc_html_e('Read More','dotorg');?></a>

    </span>
<?php }


// overrride plugin's thumbnail

if ( class_exists( 'Eleslider' ) ) {
		add_image_size('ele_slider', 1800, 850, true );		//(cropped)
}


?>