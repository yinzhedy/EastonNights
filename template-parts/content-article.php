<article id="post-details-container">
    <img class='post-details-img' src="<?php the_post_thumbnail_url('large'); ?>"/>
    <div class='post-details-text'>
        <?php the_content(); ?>
    </div>

    <div id="post-info-sub-container">
        <div class='post-details-title'>
            <p><?php the_title(); ?></p>
        </div>
        <div class='post-details-date'>
            <p>
            <?php 
            // Attempt to get event date, fall back to post date if not available
            $event_date = get_post_meta(get_the_ID(), 'event_dates', true);
            if (!empty($event_date)) {
                echo esc_html($event_date);
            } else {
                the_date(); 
            }
            ?>
            </p>
        </div>
        <?php 
        // Check for and display event location if available
        $event_location = get_post_meta(get_the_ID(), 'event_location', true);
        if (!empty($event_location)) : ?>
            <div class='post-details-location'>
                <p>Location: <?php echo esc_html($event_location); ?></p>
            </div>
        <?php endif; ?>
    </div>
    

</article>