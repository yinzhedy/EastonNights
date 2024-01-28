const gridItemMenu = document.querySelector('#grid-item-menu');

const gridItemHeader = document.querySelector('#grid-item-header');
const headerMenuLogo = document.querySelector('#sub-grid-header-item-logo');
const subGridHeaderItemLabel = document.querySelector('#sub-grid-header-item-label');

const gridItemMain = document.querySelector('#grid-item-main')
const subGridMainContainer = document.querySelector('#sub-grid-main-container')
const subGridMainItemGallery = document.querySelector('#sub-grid-main-item-gallery')
const subGridMainItemTitle = document.querySelector('#sub-grid-main-item-title')

const mobileFullScreenMenu = document.querySelector('.mobile-full-screen-menu')
const galleryImages = document.querySelectorAll('.inner-sub-grid-main-item-image')
const headerMenuIcon = document.querySelector('#sub-grid-header-item-icon');
const centerMenuItems = document.querySelectorAll('.center-menu li a');

const footerItem = document.querySelector('.footer-item')
const footerCopyright = document.querySelector('#footer-copyright')



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
    gridItemHeader.classList.toggle('background-off-black') //change the header bgcolor to off black
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


function LightMode() {
    if (subGridMainContainer.classList.contains('background-light')) {
        gridItemHeader.classList.add('background-off-white')
        subGridMainItemTitle.classList.add('font-accent-color')
        console.log(subGridMainItemGallery.classList)
    }
}

LightMode();

//modal 
function openModal(src) {
    var modal = document.getElementById("image-viewer");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementsByClassName("caption")[0];

    modal.style.display = "block";
    modalImg.src = src;
    captionText.innerHTML = ""; // You can set this to an appropriate caption if available

    // Close Modal Logic
    var span = document.getElementsByClassName("close-modal")[0];
    span.onclick = function() { 
        modal.style.display = "none";
    }
    //Find index of current image
    currentIndex = images.indexOf(src);
}

function changeImage(step) {
    currentIndex += step;
    if (currentIndex >= images.length) {
        currentIndex = 0;
    } else if (currentIndex < 0) {
        currentIndex = images.length - 1;
    }

    modalImg.src = images[currentIndex];
}

//Initialize images array
document.querySelectorAll(".inner-sub-grid-main-item-image").forEach(item => {
    images.push(item.src);
});