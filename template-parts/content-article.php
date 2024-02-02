<article id= "post-details-container">
    <img class='post-details-img' src="<?php the_post_thumbnail_url('large'); ?>"/>
    <div class = 'post-details-title' >
        <p><?php the_title(); ?></p>
    </div>
    <div class = 'post-details-date' >
        <p><?php the_date(); ?></p>
    </div>
    <div class = 'post-details-text' >
        <p><?php the_content(); ?></p>
    </div>
</article>
