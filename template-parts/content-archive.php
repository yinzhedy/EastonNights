
<article class='archive-post'>

    <img class='post-thumbnail' src="<?php the_post_thumbnail_url('large'); ?>"/>


    <div class='post-title'>
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </div>


    <div class='post-date'>
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


    <div class='post-excerpt'>
        <p>
            <?php the_excerpt(); ?>
        </p>
    </div>

    <div class='post-read-more' >
        <a href="<?php the_permalink(); ?>"> Read more -> </a>
    </div>
    
</article>
