<?php




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/MOBILE/mobile.css" media="(max-width: 840px)">
    <link rel="stylesheet" href="CSS/MEDIUM/mobile.css" media="(min-width: 840px )">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;700;900&display=swap" rel="stylesheet"/>
    <title>Sign Up</title>
</head>
<body>
    <header class="header__global">
            <section><img src="../Assets/logo.png" alt=""></section>
            <nav>
                <ul>
                    <li><a href="" target="_blanck">Inicio</a></li>
                    <li><a href="" target="_blanck">Nosotros</a></li>
                    <li><a href="" target="_blanck">Contacto</a></li>
                    <li><a href="" target="_blanck">Servicios</a></li>
                </ul>
            </nav>
    </header>

    <main class="main__signup">

        <section>

        <form action="" method="POST">

            <label for="nombre">
                <span>El administrador aún no ha activado tu usuario, intentelo más tarde.</span>
            </label>


            <section class="content__buttons">

                <a class="signup__submit" href="../index.php">Volver</a>


            </section>

        </form>
        </section>

    </main>


<?php

require '../includes/footer.php'

?>

</body>
</html>