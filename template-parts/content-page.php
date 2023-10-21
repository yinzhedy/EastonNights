<?php
    $featured_image = get_the_post_thumbnail_url()
?>

<article 
    style="background-image: url('<?php $featured_image ?>');">
    <div>Hello</div>
    <?php the_content(); ?>
</article>