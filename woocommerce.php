<?php get_header(); ?>


        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <div class="row mt-4">
                        <?php
                        if(have_posts()):
                            $post_counter = 0;
                            $posts_per_column = ceil($wp_query->post_count / 3);
                            while(have_posts()):
                                the_post();
                                $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'thumbnail');
                        ?>
                        <!-- Blog post-->
                        <div class="col-lg-4 mt-4">
                            <div class="card mb-4 h-100 d-flex flex-column">
                                <a href="#!"><img class="card-img-top flex-grow-1" src="<?php echo $url;?>" alt="" style="object-fit:cover; object-position:center;"/></a>
                                <div class="card-body">
                                    <div class="small text-muted"><?php the_time('F j, Y'); ?></div>
                                    <?php the_title(sprintf('<h2 class="card-title h4"><a href="%s">', esc_url(get_permalink())), '</a></h2>');?>
                                    <p class="card-text"><?php the_excerpt();?></p>
                                    <div class="text-center">
                                        <?php
                                        /**
                                         * Hook: woocommerce_after_shop_loop_item.
                                         *
                                         * @hooked woocommerce_template_loop_add_to_cart - 10
                                         */
                                        do_action( 'woocommerce_after_shop_loop_item' );
                                        ?>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <?php
                            $post_counter++;
                            if ($post_counter == $posts_per_column && $wp_query->post_count > $posts_per_column) {
                                echo '</div><div class="row">';
                            }
                            endwhile;
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                            </div>
                        </div>
                    </div>
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">Web Design</a></li>
                                        <li><a href="#!">HTML</a></li>
                                        <li><a href="#!">Freebies</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">JavaScript</a></li>
                                        <li><a href="#!">CSS</a></li>
                                        <li><a href="#!">Tutorials</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">Side Widget</div>
                        <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                    </div>
                </div>
            </div>
        </div>
       

<?php get_footer(); ?>