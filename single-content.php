<div <?php post_class('item normal tranz p-border'); ?>>
    
    <div class="meta-single p-border">
            
        <?php dotorg_meta_full(); ?>
        
    </div>
    
    <div class="clearfix"></div>
    
    <div class="item_inn tranz p-border">
                             
        <div class="entry" itemprop="text">
              
            <?php 
            
                the_content(); 
				
                echo '<div class="post-pagination">';
                wp_link_pages( array( 'before' => '<div class="page-link">', 'after' => '</div>',
				'link_before' => '<span>', 'link_after' => '</span>', ) );
				wp_link_pages(array(
					'before' => '<p>',
					'after' => '</p>',
					'next_or_number' => 'next_and_number', # activate parameter overloading
					'nextpagelink' => esc_html__('Next','dotorg'),
					'previouspagelink' => esc_html__('Previous','dotorg'),
					'pagelink' => '%',
					'echo' => 1 )
				);
				echo '</div>';
            
            ?>
            
            <div class="clearfix"></div>
            
        </div><!-- end .entry -->
        
            <?php 
                
                get_template_part('/includes/mag-adpost');
            
                get_template_part('/single-info');
                
                comments_template(); 
                
            ?>
        
	</div><!-- end .item_inn -->
      
</div>