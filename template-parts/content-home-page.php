<?php
$featured_image = get_the_post_thumbnail_url();
console_log($featured_image);

// Get the ID of the selected menu
$selected_menu_id = get_post_meta(get_the_ID(), 'selected_home_page_menu', true);

// Get the menu object using the selected menu ID
$selected_menu = ($selected_menu_id) ? wp_get_nav_menu_object($selected_menu_id) : null;

// Determine the menu location to use
$menu_location = ($selected_menu) ? $selected_menu->slug : 'homepage-center'; // Fallback to 'homepage-center' if no menu is selected
?>
<main id='grid-item-main'>
    <div id='sub-grid-main-container-front-page'>
        <img id="sub-grid-main-front-page-item-image" src="<?php echo esc_url($featured_image); ?>"></img>
        <div id="sub-grid-main-front-page-item-center"></div>
        <div id="sub-grid-main-front-page-item-menu">
            <div id="inner-sub-grid-main-front-page-container">
                <?php
                wp_nav_menu(
                    array(
                        'container' => '',
                        'menu' => $menu_location,
                        'items_wrap' => '<ul id="inner-sub-grid-main-front-page-item-menu" class="menu center-menu fade-items uppercase">%3$s</ul>',
                    )
                );
                ?>
            </div>
        </div>
    </div>
</main>