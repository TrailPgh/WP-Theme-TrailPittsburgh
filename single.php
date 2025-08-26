<?php get_header();  
$sidebar_opt = get_post_meta($post->ID, 'themnific_sidebar', true);
if (have_posts()) : while (have_posts()) : the_post();
?>

<?php if(has_post_format('quote'))  { ?>
    <div class="container">
    <?php get_template_part('/post-types/post-quote-post' );} else {?>  
    
      
<div itemscope itemtype="http://schema.org/NewsArticle">
<meta itemscope itemprop="mainEntityOfPage"  content=""  itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>"/>

<div class="page-header">

    <?php the_post_thumbnail('dotorg_header',array('class' => 'standard grayscale grayscale-fade'));?>
    
    <div class="container">

        <h1 class="entry-title" itemprop="headline"><span itemprop="name"><?php the_title(); ?></span></h1>
    
    </div>
        
</div>

<div id="core" <?php post_class('container_alt'); ?>>
   
    <div class="postbar postbar<?php echo esc_attr($sidebar_opt);?>">

        <div id="content" class="eightcol first">
            
            <?php get_template_part('/single-content' ); ?>
               
        </div><!-- end #content -->
    
        <?php if($sidebar_opt == 'None'){ } else { get_sidebar();} ?>
   
    </div><!-- end .postbar -->
    
</div> 

<?php }?>
        
        <?php endwhile; else: ?>
        
            <p><?php esc_html_e('Sorry, no posts matched your criteria','dotorg');?>.</p>
        
        <?php endif; ?>

</div><!-- end NewsArticle -->
   
<?php get_footer(); ?>