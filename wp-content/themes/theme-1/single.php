<?php get_header(); ?>
	<div class="row"> 
		<div class="col-lg-6">
			<div class="card-body py-5">
				<h2><?php the_title(); ?></h2>
				<p class="small mb-0">Date: <?php the_time('F j, Y'); ?></p>
				<br />
				<!-- <?php echo '<p class="small mb-0">Author: ' . get_the_author() . '</p>'; ?> -->
				
				<?php the_content(); ?>
				<?php
				if (has_post_thumbnail()) {
	                the_post_thumbnail('post-thumbnails', array(
	                    'class' => 'img-fluid mb3'
                ));
            	} ?>
			</div>
		</div>
		<?php get_sidebar(); ?>
	</div>	
</div>
<?php get_footer(); ?>