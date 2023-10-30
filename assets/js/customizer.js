(function ($) {
    // Listen for changes in the background color setting
    wp.customize('page_background_color', function (value) {
        value.bind(function (newColor) {
            // Update the container's class based on the new color
            var container = $('#sub-grid-main-item-gallery');
            container.removeClass('background-light background-dark');
            if (newColor === 'light') {
                container.addClass('background-light');
            } else if (newColor === 'dark') {
                container.addClass('background-dark');
            }
        });
    });
})(jQuery);