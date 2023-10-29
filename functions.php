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
        'mobile-homepage-full-screen' => "Mobile Homepage Full Screen Navigation Menu",
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
    wp_enqueue_script('eastonnights-customizer-script', get_template_directory_uri() . '/assets/js/customizer.js', array('jquery', 'customize-preview'), $version , true);
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

function get_menu_items_by_registered_slug($menu_slug) {
    $menu_items = array();

    if(($locations = get_nav_menu_locations() ) && isset($locations[$menu_slug])) {
        $menu = get_term( $locations[$menu_slug]);
        $menu_items = wp_get_nav_menu_items($menu->term_id);
    }
    return $menu_items;
}

function eastonnights_theme_customize_register($wp_customize) {
    // Add section for custom font selection
    $wp_customize->add_section('custom_fonts', array(
        'title' => 'Custom Font Options',
    ));

    // Add control to select the custom font
    $wp_customize->add_setting('header_menu_font', array(
        'default' => 'Nunito Sans, sans-serif', // Set a default font option
    ));

    $wp_customize->add_control('header_menu_font', array(
        'label' => 'Select Font for Header Menu',
        'section' => 'custom_fonts',
        'type' => 'select',
        'choices' => array(
            'Nunito Sans, sans-serif' => 'Nunito Font',
            '"Times New Roman", Times, serif' => 'Times New Roman',
        ),
    ));
}
add_action('customize_register', 'eastonnights_theme_customize_register');
add_action('customize_preview_init', 'eastonnights_register_scripts');

function eastonnights_theme_customize_css() {
    ?>
        <style type="text/css">
            .header-menu { font-family : <?php echo get_theme_mod('header_menu_font', 'Nunito Sans, sans-serif'); ?>; }
        </style>
    <?php
};

add_action( 'wp_head', 'eastonnights_theme_customize_css');


function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .');';
    if ($with_script_tags) {
    $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

add_filter('show_admin_bar', '__return_false');

?>
