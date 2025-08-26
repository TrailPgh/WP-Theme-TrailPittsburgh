<?php get_header();
$themnific_redux = get_option( 'themnific_redux' );?>
	
	<div class="page-header">

		<?php if(empty($themnific_redux['tmnf-header-image']['url'])) {} else { ?>
            
                <img class="page-header-img" src="<?php echo esc_url($themnific_redux['tmnf-header-image']['url']);?>" alt="<?php the_title(); ?>"/>
                
        <?php }  ?>
          
        <div class="container">
    
            <h1 itemprop="headline" class="entry-title"><?php esc_html_e('News','dotorg');?></h1>
        
        </div>
          
     </div>
    
<?php // blog content - start ?>

<div id="core">
                        
    <div class="container container_alt">
    
        <div id="content" class="eightcol first">
                
              <div class="blogger">
              
				  <?php if (have_posts()) :  while (have_posts()) : the_post();
                  
                      if(has_post_format('aside')){} else {
                          
                           get_template_part('/post-types/post-classic');
                           
                      }
                  
                  endwhile; ?><!-- end post -->
                  
                  <div class="clearfix"></div>
                        
              </div><!-- end latest posts section-->
              
              <div class="clearfix"></div>
    
                        <div class="pagination"><?php the_posts_pagination(); ?></div>
    
                        <?php else : ?>
                
    
                                <div class="errorentry entry ghost">
                    
                                    <h1 class="post entry-title" itemprop="headline"><?php esc_html_e('Nothing found here','dotorg');?></h1>
                                
                                    <h4><?php esc_html_e('Perhaps You will find something interesting from these lists...','dotorg');?></h4>
                                
                                    <div class="hrline"></div>
                                
                                    <?php get_template_part('/includes/uni-404-content');?>
                                
                                </div>
                            
                            
                            </div><!-- end latest posts section-->
                            
                            
                        <?php endif; ?>               
        
            </div><!-- end #content -->
            
            <?php get_sidebar(); ?>
            
            <div class="clearfix"></div>
            
    </div><!-- end .container -->
        
</div><!-- end #core -->	

<?php // blog content - end ?>

<?php get_footer(); ?>