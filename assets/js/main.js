
// MOBILE - HEADER HAMBURGER MENU ICON ***************************************
console.log('hello')
const headerMenuIcon = document.querySelector('#sub-grid-header-item-icon');
const gridItemMenu = document.querySelector('#grid-item-menu');
const headerGridItem = document.querySelector('#grid-item-header');
const footerItem = document.querySelector('.footer-item')
const footerCopyright = document.querySelector('#footer-copyright')
const mobileFullScreenMenu = document.querySelector('.mobile-full-screen-menu')
const headerMenuLogo = document.querySelector('#sub-grid-header-item-logo')
const galleryImages = document.querySelectorAll('.inner-sub-grid-main-item-image')
const centerMenuItems = document.querySelectorAll('.center-menu li a');

//function loading in menu items via fade in animation
function fadeInMenuItems() {
    let menuItems = document.querySelectorAll('.fade-items > *');
    for (let i = 0; i < menuItems.length; ++i) {
        fadeIn(menuItems[i], i * 150)
        }
    function fadeIn (menuItem, delay) {
        setTimeout(() => {
            menuItem.classList.add('fadein')
        }, delay)
        }
}
fadeInMenuItems()

//Click event listener for mobile menu icon - control animations/styles 
headerMenuIcon.addEventListener('click', () => {
    console.log('click');
    headerMenuIcon.classList.toggle('open'); //trigger icon animation
    headerGridItem.classList.toggle('background-off-black') //change the header bgcolor to off black
    footerItem.classList.toggle('background-off-black') //change footer item bgcolor to off black
    mobileFullScreenMenu.classList.toggle('display-none')
    headerMenuLogo.classList.toggle('display-none')

    // display open and close animations for fullscreen menu
    if(gridItemMenu.classList.contains('open')) { 
        gridItemMenu.classList.toggle('close')
        gridItemMenu.classList.toggle('open')
        footerCopyright.classList.toggle('close-fade-out')
        footerCopyright.classList.toggle('open-fade-in')
    }
    else if(gridItemMenu.classList.contains('close')) {
        gridItemMenu.classList.toggle('open')
        gridItemMenu.classList.toggle('close')
        footerCopyright.classList.toggle('open-fade-in')
        footerCopyright.classList.toggle('close-fade-out');
    }
    else if (gridItemMenu.classList.contains('hidden')) {
        gridItemMenu.classList.toggle('open');
        gridItemMenu.classList.toggle('hidden');
        footerCopyright.classList.toggle('close-fade-out');
    }
});

//change front page image to gallery featured image associated w center menu item attribute
centerMenuItems.forEach(item => {
    const mainImage = document.getElementById('sub-grid-main-front-page-item-image');
    item.addEventListener('mouseover', function (e) {
        e.preventDefault(); // Prevent the link from navigating

        // Get the featured image URL from the link's href attribute
        const featuredImage = this.getAttribute('data-featured-image');

        // Select the image element and change its src attribute
        mainImage.classList.add('close-fade-out')
        mainImage.classList.remove('fadein');
        setTimeout(() => {
            mainImage.classList.remove('close-fade-out')
            mainImage.src = featuredImage;
            mainImage.classList.add('fadein');
        }, 100);
    });
});

//gallery image on click -> fullscreen image view
galleryImages.forEach(image => {
    image.addEventListener('mouseover', function(e) {

    })
})