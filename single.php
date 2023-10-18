<?php
get_header();
?>



<main>
    <?php
        if( have_posts() ) {
            $post_type = get_post_type();
            console_log($post_type);
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
</main>




<?php
get_footer();
?>