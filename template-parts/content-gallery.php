<?php
// Get the slug from the URL
$slug = basename(get_permalink());

// Set up the query to retrieve the gallery post based on the slug
$query = new WP_Query(array(
    'post_type' => 'gallery',
    'name' => $slug  // Use the slug to retrieve the specific gallery post
));

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
?>
        <h2><?php the_title(); ?></h2>
        <div class="gallery-title"><?php get_post_field('gallery_title'); ?></div>

        <?php
        $gallery_images = get_post_field('gallery_image');
        if ($gallery_images) {
            echo '<div class="gallery-images">';
            foreach ($gallery_images as $image) {
                echo '<img src="' . esc_url($image['url']) . '" alt="">';
            }
            echo '</div>';
        }
        ?>
<?php
    endwhile;
endif;
wp_reset_postdata();
?>