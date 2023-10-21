const menu = document.querySelector('.hamburger-menu');

menu.addEventListener('click', () => {
    console.log('click')
  menu.classList.toggle('close');
});

console.log('hello')