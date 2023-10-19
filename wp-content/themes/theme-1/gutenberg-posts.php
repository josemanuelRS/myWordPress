<?php get_header(); 

/* Template Name:Gutenberg-Posts */

?>

    <div class="row">

        <!-- Posts -->
        <div class="col-lg-7 py-5">

            <h2><?php the_title(); ?></h2>

            <?php the_content(); ?>

            

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