<article class='archive-post'>

    <img class='post-thumbnail' src="<?php the_post_thumbnail_url('large'); ?>"/>


    <div class='post-title'>
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </div>


    <div class='post-date'>
        <span>
            <?php the_date(); ?>
        </span>
    </div>


    <div class='post-excerpt'>
        <span>
            <?php the_excerpt(); ?>
        </span>
    </div>

    <div class='post-read-more' >
        <a href="<?php the_permalink(); ?>"> Read more -> </a>
    </div>
    
</article>
