<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo( 'charset' ); ?>">

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

</head>

     
<body <?php body_class(); ?>>
<?php do_action('body_top'); ?>
<div class="<?php $themnific_redux = get_option( 'themnific_redux' ); 
	if (empty($themnific_redux['tmnf-uppercase'])) {} else {if($themnific_redux['tmnf-uppercase'] == '1') echo 'upper '; }
	if ( is_active_sidebar( 'tmnf-sidebar' ) ) {echo 'tmnf-sidebar-post-active ';} else { echo 'postbarNone-post ';};
	if ( is_active_sidebar( 'tmnf-sidebar-pages' ) ) {echo 'tmnf-sidebar-page-active ';} else { echo 'postbarNone-page ';};
?>">
   
    <div id="header" itemscope itemtype="http://schema.org/WPHeader">

		<div class="topnav">
            
            <div class="container head_container">

        		<?php get_template_part('/includes/uni-social' ); ?> 
                
            </div><!-- end .header icons  -->
            
    	</div>
        
        <div class="container head_container">
        
    		<div class="clearfix"></div>
            
            <div id="titles" class="tranz2">
                
                <?php if(empty($themnific_redux['tmnf-main-logo']['url'])) { ?>
                        
                        <h1><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name');?></a></h1>
                            
				<?php } 

				else { ?>

				<a class="logo" href="<?php echo esc_url(home_url('/')); ?>">

					<img class="tranz" src="<?php echo esc_url($themnific_redux['tmnf-main-logo']['url']);?>" alt="<?php bloginfo('name'); ?>"/>

				</a>

				<?php } ?>
            
            </div><!-- end #titles  -->
            
            <label for="show-menu" class="show-menu ribbon"><?php esc_html_e('Menu','dotorg');?></label>
			<input type="checkbox" id="show-menu" role="button">
            
            <nav id="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement"> 
            
                <?php get_template_part('/includes/mag-navigation'); ?>
                
            </nav>
       
       </div><!-- end .container  -->
            
       <div class="clearfix"></div>
            
    </div><!-- end #header  -->

<?php  ?>

<div class="wrapper p-border">