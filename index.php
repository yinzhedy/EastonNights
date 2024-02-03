
<?php
get_header();
?>


<main id='grid-item-main'>
    <div id="sub-grid-main-container">
        <div id="sub-grid-main-item-archive">
    <?php
        if( have_posts() ) {
            while( have_posts() ) {
                the_post();
                get_template_part('template-parts/content' , 'archive');
            }
        }
        
    ?>
    <div class='pagination-text'>
        <?php
            the_posts_pagination();
        ?>
    </div>
    </div>
    </div>
</main>




<?php
get_footer();
?>