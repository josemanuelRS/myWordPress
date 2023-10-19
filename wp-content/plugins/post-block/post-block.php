<?php
/**
 * Plugin Name: My Post Block
 * Description: Block Post to select differents posts
*/

function register_post_block(){
	wp_enqueue_script('post-block', plugin_dir_url(__FILE__).'post-block.js', array('wp-blocks', 'wp-i18n', 'wp-editor'), true, false);
}

add_action('enqueue_block_editor_assets', 'register_post_block');

?>