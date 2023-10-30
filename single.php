//single.php
<?php
get_header();
?>

<main id='grid-item-main'>
    <?php
    if (have_posts()) {
        $post_type = get_post_type();
        $post = get_post();
        console_log($post_type);
        console_log($post);
        if (get_post_type() == 'gallery') {
            // Get the background_color class for gallery post
            $background_color_class = '';
            $post_id = get_the_ID();
            $background_color = get_post_meta($post_id, 'background_color', true);
            if ($background_color) {
                $background_color_class = add_background_color_class(false);
                console_log(add_background_color_class(false));
            }

            echo '<div id="sub-grid-main-container" class="' . $background_color_class . '">';
            get_template_part('template-parts/content', 'gallery');
            echo '</div>';
        } else {
            echo '<div id="sub-grid-main-container">';
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/content', 'article');
            }
            echo '</div>';
        }
    }
    ?>
</main>

<?php
get_footer();
?>