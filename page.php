//single pages
<?php
get_header();
?>



<main id='main-grid-item'>
    <div id='sub-grid-container-main'>
        <?php
        if( have_posts() ) {
                while( have_posts() ) {
                    the_post();
                    get_template_part('template-parts/content' , 'page');
                }
            }
        
        ?>
    </div>
    
</main>




<?php
get_footer();
?>