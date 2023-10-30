<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Peter Ydeen - Easton Nights Inc.">
    <meta name="author" content="https://github.com/yinzhedy">

    <!-- CSS stylesheets -->
    <link rel="stylesheet" href="style.css">

    <!-- Optional: Bootstrap or other CSS frameworks -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->

    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Additional metadata or styles -->
    <meta name="description" content="Your website description">
    <meta name="keywords" content="your, keywords, here">

    <!-- External scripts (optional) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Your custom JavaScript file -->
    <script src="assets/main.js"></script>
    <?php
    wp_head();
    ?>
</head>

<body id="grid-container-body">
    <div id="grid-item-menu" class="hidden">
        <div id="sub-grid-menu-container">
            <?php
                wp_nav_menu(
                    array(
                        'menu' => 'mobile-homepage-full-screen',
                        'container' => '',
                        'theme_location' => 'mobile-homepage-full-screen',
                        'items_wrap' => '<ul id="sub-grid-menu-item-menu" class="menu mobile-full-screen-menu display-none"  >%3$s</ul>'
                    )
                );
            ?>
        </div>
    </div>

    <header id="grid-item-header">
        <div id="sub-grid-container-header">
            <div id="sub-grid-header-item-logo">
            <?php
                // Fetch menu items from the 'mobile-homepage-full-screen' menu.
                $menu_items = get_menu_items_by_registered_slug('homepage-header');
                if ($menu_items) {
                // Get the first menu item.
                $first_menu_item = $menu_items[0];
                echo '<a href="' . esc_url($first_menu_item->url) . '" class="logo-text" ;">' . esc_html($first_menu_item->title) . '</a>';
                };
            ?>
        </div>
        <?php
            wp_nav_menu(
                array(
                    'menu' => 'homepage-header',
                    'container' => '',
                    'theme_location' => 'homepage-header',
                    'items_wrap' => '<ul id="sub-grid-header-item-menu" class="menu header-menu"  >%3$s</ul>',
                )
            );
        ?>
            <div id="sub-grid-header-item-label">
                <?php
                    if (!is_front_page()) {
                    // Check if the current page is not the homepage
                    $current_title = get_the_title(); // Get the title of the current page
                    echo esc_html($current_title);
                    }
                ?>
            </div>
            <div id="sub-grid-header-item-icon" class="mobile-menu-icon">
                <div class="top-line line"></div>
                <div class="bottom-line line"></div>
            </div>
            
        </div>

        

    </header>