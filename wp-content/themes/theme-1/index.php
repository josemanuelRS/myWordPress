<?php get_header(); ?>

	<div class="row">

		<!-- Posts -->
		<div class="col-lg-7">

			<?php
			$post_type = get_post_type();		
			switch ($post_type) {
		    	case 'mitarbeiter':
		    		echo '<h1 class="my-5 text-center text-primary">Our Team</h1><hr />';
		    		break;
	    		case 'slider':
	    			echo '<h1 class="my-5 text-center text-primary">Slider Gallery</h1><hr />';
	    			break;
	    		default:
	    			echo '<h1 class="my-5 text-center myFont">Welcome to my Wordpress!</h1><hr />';
	    			break;
		    } 


			if (have_posts()) : while (have_posts()) : the_post();

		    

		    switch ($post_type) {
		        case 'mitarbeiter':
		            echo '<div class="my-3"><h2 class="my-1">';
		            echo get_post_meta(get_the_ID(), 'vorname', true) . ' ' . get_post_meta(get_the_ID(), 'nachname', true);
		            echo '</h2>';
		            echo '<br>';
		            echo '<strong class="small mb-0">Telefon: ';
		            echo get_post_meta(get_the_ID(), 'telefon', true);
		            echo '</strong>';
		            echo '<br>';
		            echo '<strong class="small">E-mail: ';
		            echo get_post_meta(get_the_ID(), 'mail', true);
		            echo '</strong>';
		            echo '<br></div><hr />';
		            break;

		        case 'slider':
					$slides = get_post_meta( get_the_ID(), 'slides', true );

					if ( $slides ) {
						echo '<h2>' . get_the_title() . '</h2>';
						echo '<div class="owl-carousel owl-theme">';


						foreach ($slides as $slide){

							echo '<div class="item">';
							if ( ! empty( $slide['imagen'] ) ) {
								echo '<img src="' . esc_url( $slide['imagen'] ) . '" class="img-fluid mb3" alt="' . esc_attr( $slide['titulo'] ) . '" />';
							}
							echo '<div class="carousel-caption d-none d-md-block">';
							if ( ! empty( $slide['titulo'] ) ) {
								echo '<h2>' . esc_html( $slide['titulo'] ) . '</h2>';
							}
							if ( ! empty( $slide['texto'] ) ) {
								echo '<p>' . esc_html( $slide['texto'] ) . '</p>';
							}

							echo '</div>';

							if ( ! empty( $slide['enlace'] ) ) {
								$target = ! empty( $slide['nueva_ventana'] ) ? 'target="_blank"' : '';
								echo '<div class="button-container">';
									echo '<button type="button" class="btn btn-secondary"><a href="' . esc_url( $slide['enlace'] ) . '" ' . $target . ' target=”_blank”">Open Image</a></button>';
								echo '</div>';
							}
							echo '</div>';
						}
						echo '</div><br />';
					}
					break;

		        default:
		            echo '<div class="card-body py-5">';
		            echo '<a href="' . get_the_permalink() . '">';
		            echo '<h2>' . get_the_title() . '</h2>';
		            echo '</a>';
		            echo '<p class="small mb-0">Date: ' . get_the_time('F j, Y') . '</p>';
		            echo '<p class="small mb-0">Author: ' . get_the_author() . '</p>';
		            the_excerpt();
		            echo '<a href="' . get_the_permalink() . '" class="btn btn-success">More info...</a>';
		            echo '</div>';
		            break;
		    }
			endwhile;
			endif;
			?>

			<! -- Pagination -->
			<div class="card-body">
			<?php get_template_part('template-parts/content',
			'pagination'); ?>
			</div>
		</div>
		<?php get_sidebar(); ?>
	</div>	
</div>
<?php get_footer(); ?>