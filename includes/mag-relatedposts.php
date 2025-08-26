            <ul class="related">
				
			<?php
			$backup = $post;
			$tags = wp_get_post_tags($post->ID);
			if ($tags) { $tag_ids = array();
				foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

				$args=array(
					'tag__in' => $tag_ids,
					'post__not_in' => array($post->ID),
					'showposts'=>4, // Number of related posts that will be shown.
					'ignore_sticky_posts'=>1
				);
				$my_query = new wp_query($args);
				if( $my_query->have_posts() ) { echo '<li class="related_title"><h3 class="additional">' . esc_html__( 'You might also like','dotorg').'</h3></li>'; while ($my_query->have_posts()) { $my_query->the_post();if(has_post_format('aside')){ } else {
			?>
            <li class="">
                        
				<?php if ( has_post_thumbnail()) : ?>
                
                	<div class="imgwrap">
                
                         <a href="<?php dotorg_permalink(); ?>" title="<?php the_title();?>" >
                         
                                <?php the_post_thumbnail( 'thumbnail',array('class' => "grayscale grayscale-fade tranz")); ?>
                                
                         </a>
                     
                     </div>
                     
                <?php endif; ?>
                    
                <h5><a href="<?php dotorg_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>

			</li>
			<?php }
					}
					echo '';
				}
			}
			$post = $backup;
			wp_reset_postdata();
			?>
		</ul>
		<div class="clearfix"></div>