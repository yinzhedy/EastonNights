/*
    File for WP admin custom setting : Disable Inspect
    --disables inspect and drag and drop for site
    --can be toggled off for website maintenance etc.
 */
document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
}, false);

document.addEventListener('dragstart', function(e) {
        e.preventDefault();
}, false);