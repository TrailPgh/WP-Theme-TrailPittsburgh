<?php
/**
 * The template for displaying product content in the single-give-form.php template
 *
 * Override this template by copying it to yourtheme/give/content-single-give-form.php
 *
 * @package       Give/Templates
 * @version       1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php
/**
 *  give_before_single_product hook
 *
 *  Available hook for Add-ons to add content before the form.
 */
do_action( 'give_before_single_form' );
if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}
?>

<?php
/*
 * Getting the featured image to apply to Title
 */
?>
<div class="page-header">

    <?php the_post_thumbnail('dotorg_header',array('class' => 'standard grayscale grayscale-fade'));?>
    
    <div class="container">

        <h1 itemprop="name" class="give-form-title entry-title"><?php the_title(); ?></h1>
    
    </div>
        
</div>

<div class="container_alt page">
    
    <div id="content" class="eightcol first">
    
        <div <?php post_class('item_inn p-border'); ?>>
    
            <div class="entry give_entry">
    
                <div id="give-form-<?php the_ID(); ?>-content">
                
					<?php
                    /**
                     *  give_get_donation_form()
                     *  Get's the form goal, content and actual form element
                     *
                     *  The give_single_form_summary hook outputs all of that
                     *  plus the form title as the first element
                     */
                        give_get_donation_form( $args = array() );
                    ?>
                
                    <?php
                    /**
                     * give_after_single_form_summary hook
                     */
                    do_action( 'give_after_single_form_summary' );
                    ?>
                
                </div><!-- #give-form-<?php the_ID(); ?> -->
    
                <?php do_action( 'give_after_single_form' ); ?>
                
            </div>       
        
        </div><!-- .item_inn tranz p-border ghost -->
        
    </div><!-- #content .eightcol -->
    
	<div id="sidebar"  class="fourcol woocommerce p-border">
    
    	<?php if ( is_active_sidebar( 'tmnf-sidebar-pages' ) ) { ?>
        
            <div class="widgetable p-border">
    
                <?php dynamic_sidebar('tmnf-sidebar-pages')?>
            
            </div>
            
		<?php } ?>
        
    </div><!-- #sidebar .fourcol --> 
    
</div>   <!-- .container --> 