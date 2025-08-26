

            <h4><?php esc_html_e('All Blog Posts','dotorg');?>:</h4>

            <ul style="list-style:decimal inside"><?php $archive_query = new WP_Query('showposts=1000');
while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
                <li style="margin-bottom:10px">
                    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?>

                    </a>
                </li>

                <?php endwhile; ?>
            </ul>

            <div class="hrlineB"></div>