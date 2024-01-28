
<?php
get_header();
?>



<main id='grid-item-main'>
    <div id='sub-grid-main-container'>
        <?php
        if( have_posts() ) {
                while( have_posts() ) {
                    the_post();
                    $page_layout = get_page_layout();
                    if ($page_layout === 'video_player') {
                        get_template_part('template-parts/content', 'video-player');
                    } elseif ($page_layout === 'contact_form') {
                        get_template_part('template-parts/content', 'contact-form');
                    } else {
                        get_template_part('template-parts/content' , 'page');
                    }
                }
            }
        
        ?>
    </div>
    
</main>




<?php
get_footer();
?>

