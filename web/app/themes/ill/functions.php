<?php
/**
* I'LL function
* @package WordPress
* @subpackage I'LL
* @since I'LL 1.0
*/
function my_theme_enqueue_styles() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/dist/css/main.min.css');
}

function my_theme_enqueue_scripts() {
    wp_enqueue_script('main-script', get_template_directory_uri() . '/dist/js/main.min.js', array(), false, true);
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

