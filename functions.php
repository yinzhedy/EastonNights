<?php


function eastonnights_theme_support(){
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme' , 'eastonnights_theme_support');


add_action('init' , 'eastonnights_menus');

function eastonnights_register_styles(){

    $version = wp_get_theme()->get('Version');

    wp_enqueue_style('eastonnights-style' , get_template_directory_uri()."/style.css" , array('normalize-style') , $version , 'all' );
    //enqueue normalize css stylesheet
    wp_enqueue_style('normalize-style' , "https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css", array(), '8.0.1', 'all');
    //enqueue google fonts 
    wp_enqueue_style('eastonnights-fonts-nunito-sans' , "https://fonts.googleapis.com/css2?family=Antic+Didone&family=Cormorant+Garamond:wght@300;400;500;600;700&family=Cormorant+Infant:wght@300;400;500;600;700&family=Cormorant+SC:wght@300;500;600;700&family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,700&display=swap");
    //enqueue lighbox2 css
    wp_enqueue_style('lightbox2-css', get_template_directory_uri() . '/assets/css/lightbox.min.css');

}

add_action('wp_enqueue_scripts', 'eastonnights_register_styles');

function eastonnights_register_scripts(){

    $version = wp_get_theme()->get('Version');
    wp_enqueue_script('eastonnights-script' , get_template_directory_uri()."/assets/js/main.js" , array() , $version , true );
    wp_enqueue_script('eastonnights-customizer-script', get_template_directory_uri() . '/assets/js/customizer.js', array('jquery', 'customize-preview'), $version , true);
    //Equeue lightbox2 javascript
    wp_enqueue_script('lightbox2-js', get_template_directory_uri() . '/assets/js/lightbox/lightbox.min.js', array('jquery'), '', true);
    // Enqueue the script that includes the localized object
    wp_enqueue_script('eastonnights-localized-script', get_template_directory_uri() . '/assets/js/localized.js', array('jquery'), $version, true);
    // Localize the script with the data
    wp_localize_script('eastonnights-localized-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    
    // If custom setting disable_inspect is selected, enqueue corresponding js file
    if (get_option('disable_inspect', 'no') === 'yes') {
        wp_enqueue_script('disable-inspect-script', get_template_directory_uri() . '/assets/js/disable-inspect.js', array(), null, true);
    }
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

//CUSTOM SETTINGS
//****************************************************************************************************************************** */
//Register settings
function register_my_custom_settings() {
    // Add settings to general settings section
    register_setting('general', 'disable_inspect');
}
add_action('admin_init', 'register_my_custom_settings');

//Add field to general settings page
function disable_inspect_custom_setting_field() {
    $value = get_option('disable_inspect', 'no'); // Retrieves the setting value, default is 'no'.
    echo '<input type="checkbox" id="disable_inspect" name="disable_inspect" value="yes"' . checked($value, 'yes', false) . '/>';
    echo '<label for="disable_inspect">Disable Right-Click and Drag for Site</label>';
}

add_action('admin_menu', function() {
    add_settings_field('disable_inspect', 'Site Protection', 'disable_inspect_custom_setting_field', 'general');
});

// MENUS
//****************************************************************************************************************************** */

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

function get_menu_items_by_registered_slug($menu_slug) {
    $menu_items = array();

    if(($locations = get_nav_menu_locations() ) && isset($locations[$menu_slug])) {
        $menu = get_term( $locations[$menu_slug]);
        $menu_items = wp_get_nav_menu_items($menu->term_id);
    }
    return $menu_items;
}

function add_featured_image_to_menu_items($atts, $item, $args) {
    if ($args->theme_location === 'homepage-center' && $item->object == 'gallery') {
        $permalink = $item->url;
        $slug = basename($permalink);
        $query = new WP_Query(array(
            'post_type' => 'gallery',
            'name' => $slug
        ));
        if ($query->have_posts()) {
            while ($query->have_posts()) : $query->the_post();
                $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                console_log($featured_image_url);
                $atts['data-featured-image'] = esc_url($featured_image_url);
            endwhile;
            wp_reset_postdata(); // Reset the post data
        }
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_featured_image_to_menu_items', 10, 3);

// CUSTOM POST TYPES
//****************************************************************************************************************************** */
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


// CUSTOM FIELDS
//****************************************************************************************************************************** */
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
add_action('add_meta_boxes', 'add_gallery_custom_fields');

function display_gallery_background_color($post) {
    $background_color = get_post_meta($post->ID, 'background_color', true);
    ?>
    <label for="background_color">Background Color:</label>
    <select name="background_color" id="background_color">
        <option value="dark" <?php selected($background_color, 'dark'); ?>>Dark</option>
        <option value="light" <?php selected($background_color, 'light'); ?>>Light</option>
    </select>
    <?php
}

function save_gallery_custom_fields($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['background_color'])) {
        update_post_meta($post_id, 'background_color', sanitize_text_field($_POST['background_color']));
    }
}
add_action('save_post_gallery', 'save_gallery_custom_fields');

function add_page_custom_fields() {
    add_meta_box(
        'page_layout',
        'Page Layout',
        'display_page_layout_custom_field',
        'page',
        'normal',
        'default'
    );

    add_meta_box(
        'contact_form_email',
        'Addional Settings',
        'display_contact_form_email_field',
        'page',
        'normal',
        'default'
    );
}

add_action('add_meta_boxes', 'add_page_custom_fields');

function display_page_layout_custom_field($post) {
    $page_layout = get_post_meta($post->ID, 'page_layout', true);
    ?>

    <label for="page_layout">Page Layout:</label>
    <select name="page_layout" id="page_layout">
        <option value="default" <?php selected($page_layout, 'default'); ?>>Default</option>
        <option value="video_player" <?php selected($page_layout, 'video_player'); ?>>Video Player</option>
        <option value="contact_form" <?php selected($page_layout, 'contact_form'); ?>>Contact Form</option>
    </select>

    <?php
}

function save_page_layout_custom_field($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['page_layout'])) {
        update_post_meta($post_id, 'page_layout', sanitize_text_field($_POST['page_layout']));
    }
}

add_action('save_post_page', 'save_page_layout_custom_field');

function display_contact_form_email_field($post) {
    $page_layout = get_post_meta($post->ID, 'page_layout', true);
    $contact_form_email_option = get_post_meta($post->ID, 'contact_form_email_option', true);
    $custom_email_value = get_post_meta($post->ID, 'custom_email_value', true);
    ?>

    <?php if ($page_layout === 'contact_form') : ?>

        <label for="contact_form_email_option">Contact Form Associated Email Address:</label>
        <select name="contact_form_email_option" id="contact_form_email_option">
            <option value="default" <?php selected($contact_form_email_option, 'default'); ?>>Default Associated Admin Email</option>
            <option value="custom" <?php selected($contact_form_email_option, 'custom'); ?>>Custom Email</option>
        </select>

        <div id="custom_email_input" <?php echo ($contact_form_email_option === 'custom') ? '' : 'style="display: none;"'; ?>>
            <label for="custom_email_value">Custom Email Address:</label>
            <input type="email" name="custom_email_value" id="custom_email_value" placeholder="Enter custom contact form email" value="<?php echo esc_attr($custom_email_value); ?>">
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            var contactFormEmailOptionSelect = document.getElementById("contact_form_email_option");
            var customEmailInput = document.getElementById("custom_email_input");

            function toggleCustomEmailInput() {
                customEmailInput.style.display = (contactFormEmailOptionSelect.value === 'custom') ? '' : 'none';
            }

            // Initial toggle
            toggleCustomEmailInput();

            contactFormEmailOptionSelect.addEventListener("change", toggleCustomEmailInput);
        });
        </script>

    <?php endif; ?>
    <?php
}

function save_contact_form_email_field($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['contact_form_email_option'])) {
        $contact_form_email_option = sanitize_text_field($_POST['contact_form_email_option']);
        $custom_email_value = sanitize_email($_POST['custom_email_value']);

        update_post_meta($post_id, 'contact_form_email_option', $contact_form_email_option);
        if ($contact_form_email_option === 'custom') {
            update_post_meta($post_id, 'custom_email_value', $custom_email_value);
        }
    }
}

add_action('save_post_page', 'save_contact_form_email_field');

// CUSTOMIZER
//****************************************************************************************************************************** */

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
            'Nunito Sans, sans-serif' => 'Nunito',
            'Moon Light, sans-serif' => 'Moon Light',
            'Moon Bold, sans-serif' => 'Moon Bold',
            'Driver Gothic, sans-serif' => 'Driver Gothic',
            '"Times New Roman", Times, serif' => 'Times New Roman',
        ),
    ));

    $wp_customize->add_setting('center_menu_font', array(
        'default' => 'Nunito Sans, sans-serif', // Set a default font option
    ));

    $wp_customize->add_control('center_menu_font', array(
        'label' => 'Select Font for Center Menu',
        'section' => 'custom_style_options',
        'type' => 'select',
        'choices' => array(
            'Nunito Sans, sans-serif' => 'Nunito',
            'Moon Light, sans-serif' => 'Moon Light',
            'Moon Bold, sans-serif' => 'Moon Bold',
            'Driver Gothic, sans-serif' => 'Driver Gothic',
            '"Times New Roman", Times, serif' => 'Times New Roman',
        ),
    ));

    $wp_customize->add_setting('link_decoration', array(
        'default' => 'none',
    ));

    $wp_customize->add_control('link_decoration', array(
        'label' => 'Link Decoration',
        'section' => 'custom_style_options',
        'type' => 'radio',
        'choices' => array(
            'none' => 'None',
            'underline' => 'Underline',
        ),
    ));

    $wp_customize->add_setting('link_text_color', array(
        'default' => 'inherit',
        'sanitize_callback' => 'sanitize_hex_color', // For custom color
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'link_text_color', 
        array(
            'label' => 'Custom Link Text Color',
            'section' => 'custom_style_options',
            'settings' => 'link_text_color',
        )
    ));

}
add_action('customize_register', 'eastonnights_theme_customize_register');
add_action('customize_preview_init', 'eastonnights_register_scripts');

function eastonnights_theme_customize_css() {
    ?>
    <style type="text/css">
        /* Header Menu */
        .header-menu {
            font-family: <?php echo get_theme_mod('header_menu_font', 'Nunito Sans, sans-serif'); ?>;
        }

        /* Center Menu */
        .center-menu {
            font-family: <?php echo get_theme_mod('center_menu_font', 'Nunito Sans, sans-serif'); ?>;
        }
        /* Links */
        a {
            color: <?php echo get_theme_mod('link_text_color', 'inherit'); ?>;
            text-decoration: <?php echo get_theme_mod('link_decoration', 'none'); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'eastonnights_theme_customize_css');

// UPDATE META DATA VIA CUSTOM FIELDS
//****************************************************************************************************************************** */

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

function add_background_color_class($return_echo=true) {
    $post_id = get_the_ID();
    $background_color = get_post_meta($post_id, 'background_color', true);
    if ($return_echo === true) {
        if ($background_color === 'light') {
            echo 'background-light';
        } 
        elseif ($background_color === 'dark') {
            echo 'background-dark';
        }
    }
    elseif ($return_echo === false) {
        if ($background_color === 'light') {
            return 'background-light';
        } 
        elseif ($background_color === 'dark') {
            return 'background-dark';
        }
    }
}

// CONTACT FORM
//****************************************************************************************************************************** */
function get_page_email($post_id) {
    if (!$post_id) {
        wp_send_json_error('Invalid post ID.');
        return false;
    }

    $email = get_post_meta($post_id, 'custom_email_value', true);

    if (empty($email)) {
        wp_send_json_error('Email not found for post ID ' . $post_id);
        return false;
    }

    return $email;
}

function custom_contact_form_handler() {
    // Check if it's a POST request and the required parameters are set
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'custom_contact_form') {
        // Check nonce
        if (!isset($_POST['custom_contact_form_nonce']) || !wp_verify_nonce($_POST['custom_contact_form_nonce'], 'custom_contact_form_nonce')) {
            // Nonce verification failed
            error_log('Nonce verification failed.');
            wp_send_json_error('Nonce verification failed.');
        }

        // Sanitize form data
        $name    = sanitize_text_field($_POST['name']);
        $email   = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : null;

        $to = get_page_email($post_id);
        error_log('Retrieved email: ' . $to);

        // Check if the admin email is available
        if (empty($to)) {
            // Admin email not available
            wp_send_json_error("Sorry, there was an error sending your message. Could not retrieve administrator email address, recieved: $to. Please try again later.");
        }

        // Set email subject and headers
        $subject = 'New Contact Form Submission';
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',);

        // Email body
        $body = "<p><strong>Name:</strong> $name</p>";
        $body .= "<p><strong>Email:</strong> $email</p>";
        $body .= "<p><strong>Message:</strong><br>$message</p>";

        // Send the email
        $success = wp_mail($to, $subject, $body, $headers);

        if ($success) {
            // Email sent successfully
            wp_send_json_success("Thank you, $name! Your message has been sent.");
            console_log('hello');
        } else {
            // Email failed to send
            console_log('hello');
            wp_send_json_error("Sorry, there was an error sending your message. Email failed to send to $to. Please try again later.");
        }
    } else {
        // Invalid request
        $error_message = error_get_last();
        wp_send_json_error('Sorry, there was an error sending your message. Invalid Request. Please try again later. ' . print_r($error_message, true));
    }
}

// Hook to handle the form submission
add_action('wp_ajax_custom_contact_form', 'custom_contact_form_handler');
add_action('wp_ajax_nopriv_custom_contact_form', 'custom_contact_form_handler');


// OTHER FUNCTIONS
//****************************************************************************************************************************** */
function get_page_layout() {
    $page_layout = get_post_meta(get_the_ID(), 'page_layout', true);
    return $page_layout;
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
