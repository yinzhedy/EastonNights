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

            // Use a regular expression to extract image tags
            $pattern = '/<img [^>]*wp-image-(\d+)[^>]*>/i';
            preg_match_all($pattern, $post_content, $matches);

            if (!empty($matches[1])) {
                echo '<div id="inner-sub-grid-main-container">';
                foreach ($matches[1] as $image_id) {
                    // Get low-res and high-res image URLs for each image ID
                    $low_res_image_url = wp_get_attachment_image_src($image_id, 'medium')[0]; // change 'medium' to desired low-res size
                    $high_res_image_url = wp_get_attachment_image_src($image_id, 'full')[0]; // 'full' for high-res
                    $image_title = get_the_title($image_id); // Get the image title
                    $image_description = get_post($image_id)->post_content; // Get the image description

                    // Display each image with custom modal functionality, description, & title attribute
                    echo '<img class="inner-sub-grid-main-item-image" src="' . esc_url($low_res_image_url) . '" data-high-res="' . esc_url($high_res_image_url) . '" title="' . esc_attr($image_title) . '" data-description="' . esc_attr($image_description) . '" alt="" onclick="openModal(this, \'' . esc_attr($background_color) . '\')">';
                    }
                echo '</div>';
            }
            ?>
        </div>

        <!-- Modal Structure -->
            <div id="sub-grid-item-image-viewer" class="modal">
            <span class="close-modal">&times;</span>
            <img class="modal-content" id="img01">
            <div class="modal-text">
                <p class="modal-title"></p>
                <p class="modal-description"></p>
            </div>
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