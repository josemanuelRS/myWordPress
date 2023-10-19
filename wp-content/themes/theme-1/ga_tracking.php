<?php get_header(); 

/* Template Name:Google Analytics Tracking */

?>

    <div class="row">

        <!-- Posts -->
        <div class="col-lg-7">

            <div class="container-fluid py-5">
                <h2>Google Tag Manager and Google Analytics tracking</h2>
                <img class="img-fluid py-2" src="<?php bloginfo('template_directory'); ?>/assets/images/servlet.jpg" />
                <p>The number of clicks on the button will be displayed in Google Analytics through Google Tag Manager.</p>
                <button type="button" class="btn btn-success" id="btn-track">Click me!</button>
            </div>

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