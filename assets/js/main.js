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
const frontPageMainImg = document.getElementById('sub-grid-main-front-page-item-image')

/****************************************************************************** /
    Image Protection
    - preventative measures 
    -- prevent casual visitors from inspecting and saving images from the site
    -- whole site security can be applied via custom setting disable_inspect
*******************************************************************************/

//Disable right-click context menu on images - prevent saving of images
document.addEventListener('contextmenu', function(e) {
    if (e.target.nodeName === 'IMG') {
        e.preventDefault();
    }
}, false);

//Disable drag and drop - dragging of images onto desktops or other applications
document.addEventListener('dragstart', function(e) {
    if (e.target.nodeName === 'IMG') {
        e.preventDefault();
    }
}, false);


/****************************************************************************** /
    Animations
*******************************************************************************/

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
    item.addEventListener('mouseover', function (e) {
        e.preventDefault(); // Prevent the link from navigating

        // Get the featured image URL from the link's href attribute
        const featuredImage = this.getAttribute('data-featured-image');

        // Fade the image in and out
        frontPageMainImg.classList.add('close-fade-out')
        frontPageMainImg.classList.remove('fadein');
        setTimeout(() => {
            frontPageMainImg.classList.remove('close-fade-out')
            frontPageMainImg.src = featuredImage;
            frontPageMainImg.classList.add('fadein');
        }, 100);
    });
});

/****************************************************************************** /
    Color Modes / Themes
*******************************************************************************/


function LightMode() {
    if (subGridMainContainer.classList.contains('background-light')) {
        gridItemHeader.classList.add('background-off-white')
        subGridMainItemTitle.classList.add('font-accent-color')
        console.log(subGridMainItemGallery.classList)
    }
}

LightMode();

/****************************************************************************** /
    Gallery Page Modal / Theatre mode
*******************************************************************************/

let modalImages = []; // array container for high res urls for gallery images

function openModal(imageElement, backgroundColor) {
    var modal = document.getElementById("sub-grid-item-image-viewer");
    var modalImg = document.getElementById("img01");
    var modalTitle = document.querySelector(".modal-title"); // Get the modal title element
    var modalDescription = document.querySelector(".modal-description"); // Get the modal description element

    modal.style.display = "grid";
    
    // Use the high-res URL from the data attribute
    var highResSrc = imageElement.getAttribute('data-high-res');
    var imageTitle = imageElement.getAttribute('title'); // Get the title attribute
    var imageDescription = imageElement.getAttribute('data-description'); // Get the description attribute
    modalImg.src = highResSrc;
    modalDescription.textContent = imageDescription; // Set the modal description
    modalTitle.textContent = imageTitle; // Set the modal title

    // Close Modal Logic
    var span = document.getElementsByClassName("close-modal")[0];
    span.onclick = function() { 
        modal.style.display = "none";
    }

    // Reset and populate the images array
    modalImages = [];
    document.querySelectorAll(".inner-sub-grid-main-item-image").forEach(item => {
        modalImages.push({
            url: item.getAttribute('data-high-res'), //get high res img
            title: item.getAttribute('title'), //get title
            description: item.getAttribute('data-description') //get description
        });
        
    // Set modal background/span/text color based on gallery post's backgroundColor custom field 
    if (backgroundColor === 'light') {

        modal.style.backgroundColor = 'rgba(255, 255, 255, 0.9)'; // Light background
        modalTitle.style.color = 'black';
        modalDescription.style.color = 'black';
        span.style.color = 'black';
    } else {
        modal.style.backgroundColor = 'rgba(0, 0, 0, 0.9)'; // Dark background (default)
        modalTitle.style.color = 'white';
        modalDescription.style.color = 'white';
        span.style.color = 'white';
    }
    });

    //Find index of current image
    currentIndexGallery = modalImages.indexOf(highResSrc);
}

let currentIndexGallery = 0; //  Tracks current galleryImages index while in theatre/modal mode

//Pagination - change image src/descript/title via pagination 
function changeImage(step) {
    if (!modalImages.length) return; // return if images array is empty

    currentIndexGallery += step;
    if (currentIndexGallery >= modalImages.length) {
        currentIndexGallery = 0;
    } else if (currentIndexGallery < 0) {
        currentIndexGallery = modalImages.length - 1;
    }

    var modalImg = document.getElementById("img01");
    var modalTitle = document.querySelector(".modal-title");
    var modalDescription = document.querySelector(".modal-description");

    var currentImage = modalImages[currentIndexGallery];
    modalImg.src = currentImage.url; //update img src
    modalTitle.textContent = currentImage.title; // Update the modal title
    modalDescription.textContent = currentImage.description; // Update the modal description
}