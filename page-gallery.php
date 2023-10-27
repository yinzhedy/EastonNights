//page-gallery.php
<?php
/*
Template Name: Gallery Page
*/

get_header();
?>

<main id='grid-item-main'>
    <div id='sub-grid-container-main'>
        <?php
            if (have_posts()) {
                while (have_posts()) {
                the_post();
                get_template_part('template-parts/content', 'gallery');
                }
            }
        ?>
    </div>
</main>

<?php
get_footer();
?>