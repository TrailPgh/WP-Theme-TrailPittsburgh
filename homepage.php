<?php
/*
Template Name: Builder
*/
?>
<?php get_header(); ?> 

<div class="homebuilder builder">
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <?php the_content(); ?>
    
    <?php endwhile; endif; ?>

</div>        

<div class="clearfix"></div>

<?php get_footer(); ?>

