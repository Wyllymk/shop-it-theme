<?php get_header(); ?>

<section id="hero" class="d-flex align-items-center">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1 class="text-light">Welcome to <span>MobiMax</span></h1>
      <h2 class="text-light">Shop in Style </h2>
      <div class="d-flex">
        <a href="?post_type=product" class="btn btn-primary px-4">Get Started</a>
      </div>
    </div>
</section><!-- End Hero -->
<h1 class="my-3 fw-bold text-center">Featured Products</h1>
	<div class="container">
		<div class="row">
			<div class="card mb-4">
                <div class="card-body">
					<?php echo do_shortcode('[products limit="4" columns="4" visibility="featured"]'); ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>