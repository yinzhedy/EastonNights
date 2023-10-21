
// MOBILE - HEADER HAMBURGER MENU ICON ***************************************
console.log('hello')
const menu = document.querySelector('#sub-grid-header-item-icon');

menu.addEventListener('click', () => {
    console.log('click')
    menu.classList.toggle('close');
});