jQuery(document).ready(function(){
    console.log("prueba");
    
    // Load image using AJAX
    slideWrapper.on('click', '.upload-image-button', function(e) {
        e.preventDefault();
        var upload_button = jQuery(this);
        var frame;
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
            jQuery("#img").val(attachment.url);
            jQuery("#link").val(attachment.url);
        });
        frame.open();
    });


});