//pages.php
<?php
get_header();
?>



<main id='grid-item-main'>
    <div id='sub-grid-main-container'>
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