<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="page-header">

    <?php the_post_thumbnail('dotorg_header',array('class' => 'standard grayscale grayscale-fade'));?>
    
    <div class="container">

        <h1 itemprop="headline" class="give-form-title entry-title"><?php the_title(); ?></h1>
    
    </div>
        
</div>

<div class="container_alt page">

    <div id="core">
    
        <div id="content" class="eightcol first">
        
            <div <?php post_class('item_inn  p-border'); ?>>
    
                <div class="entry">
                        
                        <?php the_content(); ?>
                        
                        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:','dotorg') . '</span>', 'after' => '</div>' ) ); ?>
                        
                        <?php the_tags( '<p class="tagssingle">','',  '</p>'); ?>
                    
                    </div>       
                            
                    <div class="clearfix"></div> 
                      
                    <?php comments_template(); ?>
                
            </div>
    
    
        <?php endwhile; else: ?>
    
            <p><?php esc_html_e('Sorry, no posts matched your criteria','dotorg');?>.</p>
    
        <?php endif; ?>
    
                    <div style="clear: both;"></div>
    
        </div><!-- #content -->
    
        <div id="sidebar"  class="fourcol woocommerce p-border">
        
            <?php if ( is_active_sidebar( 'tmnf-sidebar-pages' ) ) { ?>
            
                <div class="widgetable p-border">
        
                    <?php dynamic_sidebar('tmnf-sidebar-pages')?>
                
                </div>
                
            <?php } ?>
            
        </div><!-- #sidebar .fourcol -->
    
    </div><!-- end #core -->

</div><!-- end .container -->

<?php get_footer(); ?>