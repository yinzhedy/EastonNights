<?php

function eastonnights_theme_support(){
    //adds dynamic title tag support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme' , 'eastonnights_theme_support');

function eastonnights_menus(){

    $locations = array(
        'homepage-header' => "Homepage Header Navigation Menu",
        'homepage-center' => "Homepage Center Navigation Menu",
        'easton-nights-header' => 'Easton Nights Homepage Header Navigation Menu',
        'easton-nights-center' => 'Easton Nights Homepage Center Navigation Menu',
        'footer' => "Footer Menu Items"

    );

    register_nav_menus($locations);
}

add_action('init' , 'eastonnights_menus');

function eastonnights_register_styles(){

    $version = wp_get_theme()->get('Version');

    wp_enqueue_style('eastonnights-style' , get_template_directory_uri()."/style.css" , array('normalize-style') , $version , 'all' );
    wp_enqueue_style('normalize-style' , "https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css", array(), '8.0.1', 'all');
    wp_enqueue_style('eastonnights-fonts-nunito-sans' , "https://fonts.googleapis.com/css2?family=Antic+Didone&family=Cormorant+Garamond:wght@300;400;500;600;700&family=Cormorant+Infant:wght@300;400;500;600;700&family=Cormorant+SC:wght@300;500;600;700&family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,700&display=swap");
}

add_action('wp_enqueue_scripts', 'eastonnights_register_styles');

function eastonnights_register_scripts(){

    $version = wp_get_theme()->get('Version');
    wp_enqueue_script('eastonnights-script' , get_template_directory_uri()."/assets/js/main.js" , array() , $version , true );
}

add_action('wp_enqueue_scripts', 'eastonnights_register_scripts');

function eastonnights_widget_areas(){
    register_sidebar(
        array(
            'before_title' => '',
            'after_title' => '',
            'before_widget' => '',
            'after_widget' => '',
            'name' => 'Footer Area',
            'id' => 'footer-1',
            'description' => 'Footer Widget Area'
        )
    );
    
};

add_action('widgets_init' , 'eastonnights_widget_areas');

function create_gallery_post_type() {
    $labels = array(
        'name' => 'Galleries',
        'singular_name' => 'Gallery',
        'menu_name' => 'Galleries',
        'all_items' => 'All Images'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('gallery', $args);
}
add_action('init', 'create_gallery_post_type');


function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .');';
    if ($with_script_tags) {
    $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

add_filter('show_admin_bar', '__return_false');

?>
