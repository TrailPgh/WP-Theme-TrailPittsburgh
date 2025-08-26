          	<div <?php post_class('item small_post tranz p-border'); ?>>               	
			
				<?php if ( has_post_thumbnail()){?>
            
                    <div class="entryhead">
                        
                        <?php echo dotorg_icon();?>
                    
                        <div class="icon-rating tranz"><?php if (function_exists('wp_review_show_total')) wp_review_show_total(); ?></div>
                        
                        <div class="imgwrap">
                            
                            <a href="<?php dotorg_permalink(); ?>">
                                <?php the_post_thumbnail('dotorg_small',array('class' => 'standard grayscale grayscale-fade'));  ?>
                            </a>
                    
                        </div>
                    
                    </div><!-- end .entryhead -->
                    
                <?php }  ?>    
    
            	<div class="item_inn tranz">
                
                	<h2 class="posttitle"><a class="link link--forsure" href="<?php dotorg_permalink(); ?>"><?php the_title(); ?></a></h2>
                    
                    <p class="teaser"><?php echo dotorg_excerpt( get_the_excerpt(), '140'); ?><span class="helip">...</span></p>
                    
                	<?php dotorg_meta_front(); dotorg_meta_more(); ?>
                     
                
                </div><!-- end .item_inn -->
        
            </div>