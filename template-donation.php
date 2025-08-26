<?php
/*
Template Name: Donations
*/
?>
<?php get_header(); ?>

<div class="page-header">

    <?php the_post_thumbnail('dotorg_header',array('class' => 'standard grayscale grayscale-fade'));?>
    
    <div class="container">

        <h1 itemprop="name" class="give-form-title entry-title"><?php the_title(); ?></h1>
    
    </div>
        
</div>

<div class="container_alt page tmnf-donations-page">
	<?php
    if ( have_posts() ) : ?>
    
        <?php
        do_action('my-give-before-archive-loop');
        
        $args = array(
			'post_type' => 'give_forms',
			'posts_per_page' => 10
		);
        
        $wp_query = new WP_Query( $args );
    
        while ( have_posts() ) : the_post();?>
            <div <?php post_class('give-archive-item'); ?>>
            
                <h2 class="give-form-title">
                    <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                </h2>
                
                <div class="image-wrap">
                    <?php 
					$id = get_the_ID();
					the_post_thumbnail('dotorg_small',array('class' => 'standard grayscale grayscale-fade')); 
					
                    $shortcode = '[give_goal id="' . $id . '"]'; echo do_shortcode( $shortcode );
                     ?>
                </div>
    
                <p class="teaser"><?php the_excerpt(); ?></p>
                
                <a class="mainbutton" href="<?php echo get_the_permalink(); ?>"><?php esc_html_e('Donate Now','dotorg');?></a>
    
            </div>
        <?php endwhile;
    else : ?>
    
        <h2><?php esc_html_e('Sorry, no donation forms found.','dotorg');?></h2>
    
    <?php endif;
    wp_reset_postdata();
    do_action('my-give-after-archive-loop');
    ?>


</div><!-- end .container -->
    
<div class="clearfix"></div>
    
<?php get_footer(); ?>