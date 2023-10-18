
<?php
get_header();
?>



<main>
    <h1>
        Page Not Found
    </h1>

    <?php
    $post_type = get_post_type();
    console_log($post_type);
    get_search_form();
    ?>
</main>




<?php
get_footer();
?>