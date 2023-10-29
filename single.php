//single.php
<?php
get_header();
?>



<main id='grid-item-main'>
    <div id='sub-grid-container-main'>
        <?php
        if( have_posts() ) {
            $post_type = get_post_type();
            $post = get_post();
            console_log($post_type);
            console_log($post);
            if(get_post_type() == 'gallery') {
                
                get_template_part( 'template-parts/content', 'gallery' );
                
            }else{

                while( have_posts() ) {
                    the_post();
                    get_template_part('template-parts/content' , 'article');
                    }

                }


            }
        
        ?>
    </div>
</main>




<?php
get_footer();
?>