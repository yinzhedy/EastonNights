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

function get_menu_items_by_registered_slug($menu_slug) {
    $menu_items = array();

    if(($locations = get_nav_menu_locations() ) && isset($locations[$menu_slug])) {
        $menu = get_term( $locations[$menu_slug]);
        $menu_items = wp_get_nav_menu_items($menu->term_id);
    }
    return $menu_items;
}

function create_gallery_post_type() {
    $labels = array(
        'name' => 'Galleries',
        'singular_name' => 'Gallery',
        'menu_name' => 'Galleries',
        'all_items' => 'All Galleries'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type('gallery', $args);
}
add_action('init', 'create_gallery_post_type');

function add_gallery_custom_fields() {
    add_meta_box(
        'gallery_background_color',
        'Background Color',
        'display_gallery_background_color',
        'gallery',
        'normal',
        'default'
    );
}

function display_gallery_background_color($post) {
    $background_color = get_post_meta($post->ID, 'background_color', true);
    ?>
    <label for="background_color">Background Color:</label>
    <select name="background_color" id="background_color">
        <option value="light" <?php selected($background_color, 'light'); ?>>Light</option>
        <option value="dark" <?php selected($background_color, 'dark'); ?>>Dark</option>
    </select>
    <?php
}

function save_gallery_custom_fields($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['background_color'])) {
        update_post_meta($post_id, 'background_color', sanitize_text_field($_POST['background_color']));
    }
}

add_action('add_meta_boxes', 'add_gallery_custom_fields');
add_action('save_post_gallery', 'save_gallery_custom_fields');

function eastonnights_theme_customize_register($wp_customize) {
    // Add section for custom font selection
    $wp_customize->add_section('custom_style_options', array(
        'title' => 'Custom Style Options',
    ));

    // Add control to select the custom font for header menu
    $wp_customize->add_setting('header_menu_font', array(
        'default' => 'Nunito Sans, sans-serif', // Set a default font option
    ));

    $wp_customize->add_control('header_menu_font', array(
        'label' => 'Select Font for Header Menu',
        'section' => 'custom_style_options',
        'type' => 'select',
        'choices' => array(
            'Nunito Sans, sans-serif' => 'Nunito Font',
            '"Times New Roman", Times, serif' => 'Times New Roman',
        ),
    ));

    $wp_customize->add_setting('page_background_color', array(
        'default' => 'black',
    ));

    $wp_customize->add_control('page_background_color', array(
        'label' => 'Select Background Color for Current Page',
        'section' => 'custom_style_options',
        'type' => 'radio',
        'choices' => array(
            'light' => 'Light',
            'dark' => 'Dark',
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

function update_background_color_meta_data() {
    if (isset($_POST['post_id'], $_POST['background_color'])) {
        $post_id = intval($_POST['post_id']);
        $background_color = sanitize_text_field($_POST['background_color']);

        // Update the custom field for the specified post
        update_post_meta($post_id, 'background_color', $background_color);

        // Optionally, return a response if needed
        wp_send_json_success('Background color updated successfully.');
    }

    // Handle errors if needed
    wp_send_json_error('Invalid data.');
}

add_action('wp_ajax_update_background_color', 'update_background_color_meta_data');
add_action('wp_ajax_nopriv_update_background_color', 'update_background_color_meta_data');

function add_background_color_class() {
    $post_id = get_the_ID();
    $background_color = get_post_meta($post_id, 'background_color', true);

    if ($background_color === 'light') {
        echo 'background-light';
    } elseif ($background_color === 'dark') {
        echo 'background-dark';
    }
}

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .');';
    if ($with_script_tags) {
    $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

add_filter('show_admin_bar', '__return_false');

?>
