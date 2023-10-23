
// MOBILE - HEADER HAMBURGER MENU ICON ***************************************
console.log('hello')
const headerMenuIcon = document.querySelector('#sub-grid-header-item-icon');
const gridItemMenu = document.querySelector('#grid-item-menu');
const headerGridItem = document.querySelector('#grid-item-header');
const footerItem = document.querySelector('.footer-item')
const footerCopyright = document.querySelector('#footer-copyright')
const mobileFullScreenMenu = document.querySelector('.mobile-full-screen-menu')
const headerMenuLogo = document.querySelector('#sub-grid-header-item-logo')

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
