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

    <header id="grid-item-header">
        <div id="sub-grid-container-header">
            <?php
                wp_nav_menu(
                    array(
                        'menu' => 'homepage-top',
                        'container' => '',
                        'theme_location' => 'homepage-top',
                        'items_wrap' => '<ul id="sub-grid-header-item-menu" class="menu header-menu"  >%3$s</ul>'
                    )
                );
            ?>
            <div id="sub-grid-header-item-icon" class="mobile-menu-icon">
                <div class="top-line line"></div>
                <div class="bottom-line line"></div>
            </div>
            
        </div>

        

    </header>