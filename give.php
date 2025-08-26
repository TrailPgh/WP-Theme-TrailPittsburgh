<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>

	<div id="primary" class="content-area dotorg_single_give">
		<main id="main" class="site-main" role="main">

		<?php

		// Start the loop.
		while ( have_posts() ) : the_post();

			give_get_template_part( 'single-give-form/content', 'single-give-form' );

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
    
<div class="clearfix"></div>
    
<?php get_footer(); ?>