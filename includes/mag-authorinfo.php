        <?php 
		$user_description = get_the_author_meta( 'user_description', $post->post_author );
		if ( ! empty( $user_description ) ) { ?>
        <div class="postauthor vcard author p-border"  itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
        	<h3 class="additional"><?php esc_html_e('About the Author','dotorg');?> / <span class="fn" itemprop="name"><?php the_author_posts_link(); ?></span></h3>
            <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
				<?php  echo get_avatar( get_the_author_meta('ID'), '80' );   ?>
            </div>
            
 			<div class="authordesc"><?php the_author_meta('description'); ?></div>
            
		</div>
		<div class="clearfix"></div>
        <?php }  ?>