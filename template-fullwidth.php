<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>

<div class="page-header">

    <?php the_post_thumbnail('dotorg_header',array('class' => 'standard grayscale grayscale-fade'));?>
    
    <div class="container">

        <h1 itemprop="headline" class="give-form-title entry-title"><?php the_title(); ?></h1>
    
    </div>
        
</div>

<div class="container">

	<div id="core">
    
    	<div class="fullcontent">
            
            <div class="entry entryfull">
                
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                
                <?php the_content(); ?>
                
                <?php wp_link_pages(array('before' => '<p><strong>' . esc_html__( 'Pages:','dotorg') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                
                <?php endwhile; endif; ?>
                
            </div>
        
        </div>
        
    </div><!-- end #core -->

</div><!-- end .container -->
    
<div class="clearfix"></div>
    
<?php get_footer(); ?>