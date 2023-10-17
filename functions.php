<?php

function eastonnights_register_styles(){

    $version = wp_get_theme()->get('Version');

    wp_enqueue_style('eastonnights-style' , get_template_directory_uri()."/style.css" , array('normalize-style') , $version , 'all' );
    wp_enqueue_style('normalize-style' , "https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css", array(), '8.0.1', 'all');
}

add_action('wp_enqueue_scripts', 'eastonnights_register_styles');

function eastonnights_register_scripts(){

    $version = wp_get_theme()->get('Version');
    wp_enqueue_script('eastonnights-script' , get_template_directory_uri()."/assets/js/main.js" , array() , $version , true );
}

add_action('wp_enqueue_scripts', 'eastonnights_register_scripts');

add_filter('show_admin_bar', '__return_false');

?>