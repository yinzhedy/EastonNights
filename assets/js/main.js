
// MOBILE - HEADER HAMBURGER MENU ICON ***************************************
console.log('hello')
const headerMenuIcon = document.querySelector('#sub-grid-header-item-icon');
const fullScreenMenu = document.querySelector('#grid-item-menu');
const headerGridItem = document.querySelector('#grid-item-header');
const footerItem = document.querySelector('.footer-item')

headerMenuIcon.addEventListener('click', () => {
    console.log('click');
    headerMenuIcon.classList.toggle('open'); //trigger icon animation
    headerGridItem.classList.toggle('background-off-black') //change the header bgcolor to off black
    footerItem.classList.toggle('background-off-black') //change footer item bgcolor to off black

    // display open and close animations for fullscreen menu
    if(fullScreenMenu.classList.contains('open')) {
        fullScreenMenu.classList.toggle('close')
        fullScreenMenu.classList.toggle('open')
    }
    else if(fullScreenMenu.classList.contains('close')) {
        fullScreenMenu.classList.toggle('open')
        fullScreenMenu.classList.toggle('close')
    }
    else if (fullScreenMenu.classList.contains('hidden')) {
        fullScreenMenu.classList.toggle('open');
        fullScreenMenu.classList.toggle('hidden');
    }
});
