</div><!-- /.wrapper  -->

    <div id="footer">
    
        <div class="container container_alt woocommerce"> 
        
			<?php get_template_part('/includes/uni-bottombox'); ?>
                    
		</div>
        
		<div class="clearfix"></div>
    
		<?php
		$themnific_redux = get_option( 'themnific_redux' );
		if (empty($themnific_redux['tmnf-search-bottom-dis'])) {
		} else {?>
        
        <div class="landing-section">
    
    		<div class="container">

        		<?php get_template_part('/includes/uni-social' ); ?>        
        
        	</div>
        
    	</div>
        <?php } ?>
        
		<div class="clearfix"></div>

		<div class="footer-logo">
        
			<div class="container">
    
                 <?php  $themnific_redux = get_option( 'themnific_redux' ); if(empty($themnific_redux['tmnf-footer-logo']['url'])) { }
                        
                    else { ?>
                                
                        <a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
                        
                            <img class="tranz" src="<?php echo esc_url($themnific_redux['tmnf-footer-logo']['url']);?>" alt="<?php bloginfo('name'); ?>"/>
                                
                        </a>
                        
                <?php } ?>
            
                <?php $themnific_redux = get_option( 'themnific_redux' );
					if(empty($themnific_redux['tmnf-footer-editor'])) { } else {
						echo '<div class="footer_text">' . wp_kses_post($themnific_redux['tmnf-footer-editor']). '</div>';
					}
				?>
                
            	<?php if ( function_exists('has_nav_menu') && has_nav_menu('bottom-menu') ) {wp_nav_menu( array( 'depth' => 1, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_class' => 'bottom-menu', 'menu_id' => '' , 'theme_location' => 'bottom-menu') );}  ?>
                
            </div>   
            
		</div>
            
    </div><!-- /#footer  -->
    
<div id="curtain" class="tranz">
	
	<?php get_search_form();?>
    
    <a class='curtainclose rad' href="#" ><i class="fa fa-times"></i></a>
    
</div>
    
<div class="scrollTo_top ribbon rad">

    <a title="<?php esc_attr_e('Scroll to top','dotorg');?>" class="rad" href="#">&uarr;</a>
    
</div>
</div><!-- /.upper class  -->
<?php wp_footer(); ?>

</body>
</html>