<?php



    require 'limpieza.php';

    if($_POST['enviar'] != NULL){
        $name = limpieza($_POST['name']);
        $email = limpieza($_POST['email']);
        $cellphone = limpieza($_POST['cellphone']);
        $asunto = limpieza($_POST['asunto']);
        $contenido = limpieza($_POST['contenido']);
        $mail = "vicvans@hotmail.com";
        $contenido = "Telefono:" . $cellphone . "\r\n" . "Nombre: ". $name. "\r\n". $contenido;
        $header = "From: " . $email . "\r\n";
        $header.= "Reply-to: contacto@unika.com" ."\r\n";
        $header.= "X-Mailer: PHP/" . phpversion();
        $mail = @mail($mail, $asunto, $contenido, $header);

        if($mail){
            header('Location: index.html');
        }
        else {
            echo "Mensaje no enviado";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Inicio/contacto/CSS/MOBILE/medium.css"  media="(max-width: 950px)">
    <link rel="stylesheet" href="Inicio/contacto/CSS/MEDIUM/medium.css" media="(min-width: 950px)">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    <title>Unika|Contacto</title>
</head>
<body>
    <header>
      <section class="header__content">

          <section class="header__up">
              <section class="header__up--logo">
                  <img src="Assets/logo.png" alt="">
              </section>
              <section class="header__up--slogan">
                  <p>Cumplir tus sueños es nuestra misión!</p>
              </section>
              <section class="header__up--buttons">
                  <section class="buttons__contacto">
                      <a href="contacto.php">Contacto</a>
                  </section>
                  <section class="buttons__login">
                      <section>
                          <a href="login/index.php">Soy Cliente</a>
                      </section>
                      <section>
                          <a href="login/index.php">Soy Asesor</a>
                      </section>
                  </section>
              </section>
          </section>
          <section class="header__down">
              <nav>
                  <section class="menu" id="down__menu">
                      <i class="i" id="button_open"></i>
                  </section>
                  <ul id="ul__menu">
                      <li class="nav__left"><a href="index.html">Inicio</a></li>
                      <li><a href="acerca.html">Acerca de</a></li>
                      <li><a href="servicios.html">Nuestros Servicios</a></li>
                      <li><a href="vender.html">¿Quieres Vender?</a></li>
                      <li><a href="rentar.html">¿Quieres Rentar?</a></li>
                      <li><a href="comprar.html">¿Quieres Comprar?</a></li>
                      <li class="nav__right"><a href="preguntas.html">Preguntas Frecuentes</a></li>
                  </ul>
              </nav>
          </section>
      </section>


  </header>

    <main>
        <section class="main__formulario">
            <h1>Contáctanos</h1>
                <form action="" method="POST">
                    <input class="input__complete" type="text" name="name" placeholder="Nombre" required>
                    <section class="datos">
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="text" name="cellphone" placeholder="Teléfono" required maxlength="10">
                    </section>
                    <input class="input__complete" type="text" name="asunto" placeholder="Asunto" required maxlength="50">
                    <textarea class="input__big" required name="contenido" id="" cols="30" rows="10" placeholder="Escribe tu mensaje aquí..."></textarea>
                    <input class="input__submit" type="submit" name="enviar" value="Enviar">
                </form>
        </section>

        <section class="main__oficinas">
            <section>
                <ul>
                    <li class="main__oficinas--li">
                        <p class="oficina__title">Ciudad de México</p>
                        <section class="oficina__content">
                            <i class="mail"></i>
                            <p>unikacdmx@gmail.com</p>
                        </section>
                        <section class="oficina__content">
                            <i class="whatsapp"></i>
                            <p>5525658081</p>
                        </section>
                        <section class="oficina__content">
                            <i class="telephone"></i>
                            <p>5556828888</p>
                        </section>
                    </li>
                    <li class="main__oficinas--li">
                        <p class="oficina__title">Toluca</p>
                        <section class="oficina__content">
                            <i  class="mail"></i>
                            <p>unikacdmx@gmail.com</p>
                        </section>
                        <section class="oficina__content">
                            <i  class="whatsapp"></i>
                            <p>5525658081</p>
                        </section>
                        <section class="oficina__content">
                            <i class="telephone"></i>
                            <p>5556828888</p>
                        </section>
                    </li>
                    <li class="main__oficinas--li">
                        <p class="oficina__title">Guadalajara</p>
                        <section class="oficina__content">
                            <i  class="mail"></i>
                            <p>unikacdmx@gmail.com</p>
                        </section>
                        <section class="oficina__content">
                            <i  class="whatsapp"></i>
                            <p>5525658081</p>
                        </section>
                        <section class="oficina__content">
                            <i  class="telephone"></i>
                            <p>5556828888</p>
                        </section>
                    </li>
                    <li class="main__oficinas--li">
                        <p class="oficina__title">Querétaro</p>
                        <section class="oficina__content">
                            <i  class="mail"></i>
                            <p>unikacdmx@gmail.com</p>
                        </section>
                        <section class="oficina__content">
                            <i  class="whatsapp"></i>
                            <p>5525658081</p>
                        </section>
                        <section class="oficina__content">
                            <i class="telephone"></i>
                            <p>5556828888</p>
                        </section>
                    </li>
                </ul>
            </section>
        </section>
    </main>

    <footer>
        <section>
            <img src="Assets/logo.png" alt="" rows="5" cols="80">
        </section>
    </footer>
    <script src="Inicio/JS/menu.js" ></script>
</body>
</html>