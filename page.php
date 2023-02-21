<?php get_header(); ?>


        <!-- Page content-->
        <div class="container mt-3">
            <div class="row">
                <!-- Blog entries-->
                    
                    <?php
                            if(have_posts()):
                                while(have_posts()): 
                                    the_post();
                                    $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'thumbnail');

                            ?>
                    <!-- Featured blog post-->
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php the_title(sprintf('<h2 class="card-title h4"><a href="%s">', esc_url(get_permalink())), '</a></h2>');?>
                            <p class="card-text"><?php the_content();?></p>
                        </div>
                    </div>
                    <?php endwhile;
                            endif;
                            ?>
                
            </div>
        </div>
       

<?php get_footer(); ?>