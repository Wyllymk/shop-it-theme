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
                            <?php the_title(sprintf('<h2 class="text-center card-title h4"><a class="text-decoration-none"href="%s">', esc_url(get_permalink())), '</a></h2>');?>
                            <?php the_post_thumbnail('medium');?>
                            <p class="text-decoration-none"><?php the_category();?></p>
                            <?php the_tags();?>
                            <p class="card-text"><?php the_content();?></p>
                        </div>
                    </div>
                    <?php endwhile;
                            endif;
                    ?>
                
            </div>
        </div>
       

<?php get_footer(); ?>