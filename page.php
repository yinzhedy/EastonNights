//single pages
<?php
get_header();
?>



<main>
    <?php
        if( have_posts() ) {
                while( have_posts() ) {
                    the_post();
                    get_template_part('template-parts/content' , 'page');
                }
        }
        
    ?>
</main>




<?php
get_footer();
?>