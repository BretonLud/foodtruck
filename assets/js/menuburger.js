let menuButton = document.querySelector('#menu-button');
let menu = document.querySelector('#menu-burger');


menuButton.addEventListener('click', function() { 
    event.stopPropagation();
 
menu.classList.toggle('show-menu');
menuButton.classList.toggle('close');

if (menu.classList.contains('show-menu')) {
    document.addEventListener('click', function() {
        menu.classList.remove('show-menu');
        menuButton.classList.add('close');

    })
}

})




