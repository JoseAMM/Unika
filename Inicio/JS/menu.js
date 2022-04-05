var down__menu = document.getElementById("down__menu");
var ul__menu = document.getElementById("ul__menu");
var contador = 0;

function menu() {
    contador++;

    if (contador % 2 != 0) {
        down__menu.style.width = "90%";
        down__menu.style.paddingLeft = "70%";
        down__menu.style.backgroundColor = "rgb(179, 138, 76)";
        down__menu.style.borderRadius = "2rem";

        ul__menu.style.zIndex = 300;

    }

    else if (contador % 2 == 0) {
        down__menu.style.width = "25%";
        down__menu.style.paddingLeft = "10%";
        ul__menu.style.zIndex = -300;
    }
}

document.getElementById("button_open").addEventListener("click", menu);
