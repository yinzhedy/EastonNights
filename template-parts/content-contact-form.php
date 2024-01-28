<?php 
    $featured_image = get_the_post_thumbnail_url(); 
    $post_id = get_the_ID();
    $to = get_page_email($post_id);
    console_log($to);
?>

<article>
    <div id="contact-form" class="contact-form">
        <h2><?php the_title(); ?></h2>
        <form id="form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <?php wp_nonce_field('custom_contact_form_nonce', 'custom_contact_form_nonce'); ?>
            <input type="hidden" name="action" value="custom_contact_form">

            <label for="name">Your Name:</label>
            <input type="text" name="name" required>

            <label for="email">Your Email:</label>
            <input type="email" name="email" required>

            <label for="message">Your Message:</label>
            <textarea name="message" required></textarea>

            <!-- Hidden field for post ID -->
            <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">

            <input type="submit" value="Submit">
        </form>
    </div>
</article>