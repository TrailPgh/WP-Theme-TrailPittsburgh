<div class="postinfo p-border">    

<?php
	$themnific_redux = get_option( 'themnific_redux' );

	
	//tags/likes
	if (empty($themnific_redux['tmnf-post-likes-dis'])) {
		} else {
		the_tags( '<p class="meta taggs"> ', ' ', '</p>');?>
        <p class="modified small cntr" itemprop="dateModified" ><?php esc_html_e('Last modified','dotorg');?>: <?php the_modified_date(); ?></p>
	<?php echo '';}
	
	// prev/next	
	if (empty($themnific_redux['tmnf-post-nextprev-dis'])) {
	} else {
	get_template_part('/includes/mag-nextprev');
	echo '<div class="clearfix"></div>';}
	
	// author
	if (empty($themnific_redux['tmnf-post-author-dis'])) {
	} else {
	get_template_part('/includes/mag-authorinfo');
	echo '';}


	// related
	if (empty($themnific_redux['tmnf-post-related-dis'])) {
	} else {
	get_template_part('/includes/mag-relatedposts');}

	
?>
            
</div>

<div class="clearfix"></div>
 			
            

                        
