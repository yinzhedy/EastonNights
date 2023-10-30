<?php
// Get the slug from the URL
$slug = basename(get_permalink());
console_log(get_permalink());
console_log($slug);

// Set up the query to retrieve the gallery post based on the slug
$query = new WP_Query(array(
    'post_type' => 'gallery',
    'name' => $slug  // Use the slug to retrieve the specific gallery post
));

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();

    // Get the post ID
    $post_id = get_the_ID();
    // Get the background_color custom field of post using post id
    $background_color = get_post_meta($post_id, 'background_color', true);
?>
    <div id="sub-grid-main-item-title"><?php the_title(); ?></div>
    <div id="sub-grid-main-item-gallery" class="<?php add_background_color_class(); ?>">
        <?php
        // Get the post content
        $post_content = get_the_content();

        // Use a regular expression to extract image URLs
        $pattern = '/<img [^>]*src=["\']([^"\']+)["\'][^>]*>/i';
        preg_match_all($pattern, $post_content, $matches);

        if (!empty($matches[1])) {
            echo '<div id="inner-sub-grid-main-container">';
            foreach ($matches[1] as $image_url) {
                echo '<img class="inner-sub-grid-main-item-image" src="' . esc_url($image_url) . '" alt="">';
            }
            echo '</div>';
        }
        ?>
    </div>
    <?php
    endwhile;
endif;
wp_reset_postdata();
?>
