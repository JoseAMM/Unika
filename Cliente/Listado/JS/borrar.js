var main__borrar = document.getElementsByClassName("main__borrar");
var contador = 0;
console.log(main__borrar);

function menu() {
    contador++;

    

    if (contador % 2 != 0) {
        for(let i = 0; i < main__borrar.length; i++){
            main__borrar[i].style.zIndex = 300;
        }


    }

    else if (contador % 2 == 0) {
        for(let i = 0; i < main__borrar.length; i++){
            main__borrar[i].style.zIndex = -100;
        }
    }
}

var borrar = document.getElementsByClassName("input-borrar");

for(var i = 0; i < borrar.length; i++){
    borrar[i].addEventListener('click', menu);
}


