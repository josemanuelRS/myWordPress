<?php 

// get styles and js
function register_styles(){
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('owl-css', get_template_directory_uri() . '/assets/owlcarousel/owl.carousel.min.css');
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/assets/owlcarousel/owl.theme.default.min.css');
    wp_enqueue_style('wpb-google-fontss', get_template_directory_uri() . '/assets/fonts/BlackOpsOne-Regular.ttf');
}
add_action('wp_enqueue_scripts', 'register_styles');

function register_scripts(){
    wp_enqueue_script('pooper', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js:2:30460', array(
        'jquery', '3.6', true
        )   
    );
    wp_enqueue_script('pooper', 'https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js', array(
        'jquery', '1.12', true
        )
    );
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js');
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js');
    wp_enqueue_script('owl-js', get_template_directory_uri() . '/assets/owlcarousel/owl.carousel.min.js');
}
add_action('wp_enqueue_scripts', 'register_scripts');

function enqueue_editor_assets() {
    wp_enqueue_editor();
}
add_action( 'admin_enqueue_scripts', 'enqueue_editor_assets' );

// get feauted images
if ( function_exists('add_theme_support')){
    add_theme_support('wp-block-styles');
    add_theme_support('post-thumbnails'); 
}

function menus(){
    $locations = array(
        'primary' => "Navbar Menu",
        'footer' => "Footer Menu Items"
    );
    register_nav_menus($locations);
}
add_action('init', 'menus');

// add sidebar
function theme1_widgets(){
    register_sidebar(array(
        'id' => 'widgets-right',
        'name' => __('Right Widget'),
        'descrpition' => __(''),
        'before_widget' => '<div class="card-body">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4><hr />'
    ));
}
add_action('widgets_init', 'theme1_widgets');


// CUSTOM POST MITARBEITER
function custom_post_mitarbeiter() {
    $labels = array(
        'name' => 'Mitarbeiter',
        'singular_name' => 'Mitarbeiter',
        'add_new' => 'Add new',
        'add_new_item' => 'Add new Mitarbeiter',
        'edit_item' => 'Edit Mitarbeiter',
        'new_item' => 'New Mitarbeiter',
        'view_item' => 'Show Mitarbeiter',
        'search_items' => 'Search Mitarbeiter',
        'not_found' => 'No Mitarbeiter found',
        'not_found_in_trash' => 'No Mitarbeiter found in trash',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-businessman',
        'supports' => array('nachname', 'vorname', 'telefon', 'mail'),
        'rewrite' => array('slug' => 'mitarbeiter'),
    );

    register_post_type('mitarbeiter', $args);
}
add_action('init', 'custom_post_mitarbeiter', 0);


// ADD CUSTOM FIELDS
function add_custom_fields_mitarbeiter() {
    add_meta_box('custom_fields_mitarbeiter', 'Mitarbeiter info', 'show_custom_fields_mitarbeiter', 'mitarbeiter', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_custom_fields_mitarbeiter');

function show_custom_fields_mitarbeiter($post) {
    $nachname = get_post_meta($post->ID, 'nachname', true);
    $vorname = get_post_meta($post->ID, 'vorname', true);
    $telefon = get_post_meta($post->ID, 'telefon', true);
    $mail = get_post_meta($post->ID, 'mail', true);

    echo '<label for="nombre">Nachname:</label>';
    echo '<input type="text" id="nachname" name="nachname" value="' . esc_attr($nachname) . '"><br>';

    echo 'Vorname: <input type="text" name="vorname" value="' . esc_attr($vorname) . '"><br>';
    echo 'Telefon: <input type="text" name="telefon" value="' . esc_attr($telefon) . '"><br>';
    echo 'Mail: <input type="email" name="mail" value="' . esc_attr($mail) . '"><br>';
}

function save_custom_fields_mitarbeiter($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['nachname'])) {
        update_post_meta($post_id, 'nachname', sanitize_text_field($_POST['nachname']));
    }

    if (isset($_POST['vorname'])) {
        update_post_meta($post_id, 'vorname', sanitize_text_field($_POST['vorname']));
    }

    if (isset($_POST['telefon'])) {
        update_post_meta($post_id, 'telefon', sanitize_text_field($_POST['telefon']));
    }

    if (isset($_POST['mail'])) {
        update_post_meta($post_id, 'mail', sanitize_email($_POST['mail']));
    }
}
add_action('save_post', 'save_custom_fields_mitarbeiter');

function custom_posts_per_page($query){
    if(is_post_type_archive('mitarbeiter') && $query->is_main_query()){
        $query->set('posts_per_page', 5);
    }
}
add_action('pre_get_posts', 'custom_posts_per_page');

// Replace columns
add_filter('manage_edit-mitarbeiter_columns', 'custom_columns_mitarbeiter');
function custom_columns_mitarbeiter($columns) {
    unset($columns['title']);
    $columns['nachname'] = 'Nachname';
    $columns['vorname'] = 'Vorname'; 
    $columns['telefon'] = 'Telefon'; 
    $columns['mail'] = 'Mail';
    return $columns;
}

add_action('manage_mitarbeiter_posts_custom_column', 'show_value_columns_mitarbeiter', 10, 2);
function show_value_columns_mitarbeiter($column, $post_id) {
    switch ($column) {
        case 'nachname':
            echo get_post_meta($post_id, 'nachname', true);
            break;
        case 'vorname':
            echo get_post_meta($post_id, 'vorname', true);
            break;
        case 'telefon':
            echo get_post_meta($post_id, 'telefon', true);
            break;
        case 'mail':
            echo get_post_meta($post_id, 'mail', true);
            break;
    }
}

// CUSTOM POST SLIDER
function custom_post_slider() {
    $labels = array(
        'name'               => 'Sliders',
        'singular_name'      => 'Slider',
        'add_new'            => 'Add new Slider',
        'add_new_item'       => 'Add New Slider',
        'new_item'           => 'New Slider',
        'edit_item'          => 'Edit Slider',
        'view_item'          => 'Show Slider',
        'all_items'          => 'All Sliders',
        'search_items'       => 'Search Sliders',
        'parent_item_colon'  => 'Slider Father:',
        'not_found'          => 'No Sliders found.',
        'not_found_in_trash' => 'No Sliders found in trash'
    );

    $args = array(
        'labels' => $labels,
        'public'              => true,
        'menu_position'       => 6,
        'menu_icon' => 'dashicons-format-gallery',
        'has_archive'         => true,
        'supports'            => array( 'title', 'thumbnail' ),
        'rewrite'             => array( 'slug' => 'slider' )
    );

    register_post_type( 'slider', $args );
}

add_action( 'init', 'custom_post_slider', 0);


function slider_custom_fields() {
    add_meta_box(
        'slides_meta_box',
        'Slides',
        'slider_show_customFields',
        'slider',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'slider_custom_fields' );

function slider_show_customFields( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'slides_nonce' );

    $slides = get_post_meta( $post->ID, 'slides', true );

    if ( empty( $slides ) ) {
        $slides = array(
            array(
                'name' => '',
                'text' => '',
                'image' => '',
                'link' => ''
            )
        );
    }

    // Show slider custom fields
    echo '<div class="slides-wrap">';
    foreach ( $slides as $index => $slide ) {
        echo '<div class="slide">';
        echo '<h4>Slide ' . ( $index + 1 ) . '</h4>';
        echo '<label>Name: </label>';
        echo '<input type="text" name="slides[' . $index . '][name]" value="' . esc_attr( $slide['name'] ) . '" />';

        
        $content = $slide['text'];
        $editor_id = 'text_' . $index;
        wp_editor($content, $editor_id, array(
            'textarea_name' => 'slides[' . $index . '][text]',
            'media_buttons' => false,
            'textarea_rows' => 5
        ));

        
        echo '<label>Image: </label>';
        echo '<input type="text" name="slides[' . $index . '][image]" value="' . esc_url( $slide['image'] ) . '" id="img" />';

        echo '<button class="upload-image-button button">Upload Image</button><br />';
        echo '<label>Link: </label>';
        echo '<input type="text" name="slides[' . $index . '][link]" value="' . esc_url( $slide['link'] ) . '" id="link" />';
        echo '<a href="#" class="delete_slide">Delete Slide</a>';
        echo '</div>';
    }
    echo '</div>';

    echo '<button class="button" id="add_slide">Add Slide</button>';


    // Script to load images und add/delete slides
    ?>
    <script>
    jQuery(document).ready(function($) {

        var slideWrapper = $('.slides-wrap');
        var slideTemplate = $('.slide:first').clone();
        var slideIndex = $('.slide').length;

        // Add Slide
        $('#add_slide').click(function(e) {

            e.preventDefault();
            var newSlide = slideTemplate.clone();
            newSlide.find('input, textarea').val('');
            slideIndex++;
            newSlide.find('h4').text('Slide ' + slideIndex);

            // Update names from cloned fields
            newSlide.find('[name^="slides"]').each(function() {
                var newName = $(this).attr('name').replace('[0]', '[' + (slideIndex - 1) + ']');
                $(this).attr('name', newName);
            });

        newSlide.appendTo(slideWrapper);
        });

        // Delete Slide
        slideWrapper.on('click', '.delete_slide', function(e) {
            e.preventDefault();
            $(this).closest('.slide').remove();
            $('.slide').each(function(index) {
                $(this).find('h4').text('Slide ' + (index + 1));
            });
        });

        // Load image using AJAX
        slideWrapper.on('click', '.upload-image-button', function(e) {
            e.preventDefault();
            var upload_button = jQuery(this);
            var frame;
            var imgField = $(this).siblings('#img');
            var urlField = $(this).siblings('#link');

            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: 'Select image',
                button: {
                text: 'Use this image'
                },
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                imgField.val(attachment.url);
                urlField.val(attachment.url);
            });

            frame.open();
        });
    });
    </script>
    <?php
}

function save_fields_slider( $post_id ) {
    if ( ! isset( $_POST['slides_nonce'] ) || ! wp_verify_nonce( $_POST['slides_nonce'], basename( __FILE__ ) ) ) {
        return;
    }
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    }
    if ( 'slider' === $_POST['post_type'] ) {
        if ( current_user_can( 'edit_page', $post_id ) ) {
            $slides = isset( $_POST['slides'] ) ? $_POST['slides'] : array();
            update_post_meta( $post_id, 'slides', $slides );
        }
    }
}
add_action( 'save_post', 'save_fields_slider' );


?>