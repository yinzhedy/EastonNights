<?php
    get_header();
?>
<?php
    $featured_image = get_the_post_thumbnail_url();
    console_log($featured_image);
?>
    <main id='grid-item-main'>
        <div id='sub-grid-container-main-front-page'>
            <img id="sub-grid-main-front-page-item-image" src="<?php echo $featured_image ?>">
                
            </img>
            <div id="sub-grid-main-front-page-item-center"></div>
            <div id="sub-grid-main-front-page-item-menu">
                <div id="inner-sub-grid-main-front-page-container">
                <?php
                    wp_nav_menu(
                        array(
                            'menu' => 'homepage-center',
                            'container' => '',
                            'theme_location' => 'homepage-center',
                            'items_wrap' => '<ul id="inner-sub-grid-main-front-page-item-menu" class="menu center-menu fade-items"  >%3$s</ul>',
                            )
                    );
                ?>
            </div>
            
        </div>
    </main>
<?php
    get_footer();
?>