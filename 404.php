<?php get_header(); 
$themnific_redux = get_option( 'themnific_redux' );?>
	
<div class="page-header">

	<?php if(empty($themnific_redux['tmnf-header-image']['url'])) {} else { ?>
        
            <img class="page-header-img" src="<?php echo esc_url($themnific_redux['tmnf-header-image']['url']);?>" alt="<?php the_title(); ?>"/>
            
    <?php }  ?>
      
    <div class="container">
        
        <div class="error-titles cntr">
        
            <h2><?php esc_html_e('404 • Page not found ','dotorg');?></h2>
        
            <p>&nbsp;
            <?php esc_html_e('Oops! The page you are looking for does not exist. It might have been moved or deleted. ','dotorg');?></p>
        
        </div>
    
    </div>
    
</div>

<div class="container">

<div id="core" class="blogger postbarNone">

    <div id="content">
    
    	<div class="page">
            
            <div class="errorentry entry item_inn">
                    
                <div class="cntr error-search"><?php get_search_form();?></div>
            
            </div>
    
    	</div>
            
    </div><!-- #content -->
        
</div>

</div>
    
<?php get_footer(); ?>