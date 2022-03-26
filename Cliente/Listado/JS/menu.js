var main__menu = document.getElementById("main__menu");
var main__nav = document.getElementById("main__nav");
var contador = 0;

function menu() {
    contador++;

    if (contador % 2 != 0) {
        main__menu.classList.toggle("menu__move");
        main__nav.style.zIndex = 300;

    }

    else if (contador % 2 == 0) {
        main__menu.classList.toggle("menu__move");
        main__nav.style.zIndex = -100;
    }
}

document.getElementById("button_open").addEventListener("click", menu);
