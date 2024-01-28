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
        // Get the post ID
        $post_id = get_the_ID();
        // Get the background_color custom field of post using post id
        $background_color = get_post_meta($post_id, 'background_color', true);
?>
        <div id="sub-grid-main-item-title" class="uppercase"><?php the_title(); ?></div>
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
                    // Display each image with custom modal functionality
                    echo '<img class="inner-sub-grid-main-item-image" src="' . esc_url($image_url) . '" alt="" onclick="openModal(this.src)">';
                }
                echo '</div>';
            }
            ?>
        </div>

        <!-- Modal Structure -->
            <div id="sub-grid-item-image-viewer" class="modal">
            <span class="close-modal">&times;</span>
            <img class="modal-content" id="img01">
            <div class="caption"></div>
            <!-- Navigation Buttons -->
            <a class="prev" onclick="changeImage(-1)">&#10094;</a>
            <a class="next" onclick="changeImage(1)">&#10095;</a>
            </div>

        <?php
    endwhile;
endif;
wp_reset_postdata();
?>