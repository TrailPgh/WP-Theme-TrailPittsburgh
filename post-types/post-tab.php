<div class="tab-post p-border">

	<?php if ( has_post_thumbnail()) : ?>
    
        <div class="imgwrap">
        
            <a href="<?php dotorg_permalink(); ?>" title="<?php echo the_title(); ?>" >
            
              <?php the_post_thumbnail( 'dotorg_tabs',array('class' => "grayscale grayscale-fade")); ?>
              
            </a>
        
        </div>
         
    <?php endif; ?>
        
    <h4><a href="<?php dotorg_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
    
	<?php dotorg_meta_date();  ?>

</div>