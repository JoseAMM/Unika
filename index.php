<?php

    //Conexión a la base de datos

    require 'includes/config/database.php';

    $db = conectarDB();

    require 'includes/header.php';

    $errores = [];
    $ruta = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $errores = [];
        $correo = mysqli_real_escape_string($db, $_POST['correo']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        $queryComprobacion = "SELECT * FROM usuarios WHERE Correo = '$correo'";
        $resultadoComprobacion = mysqli_query($db, $queryComprobacion);

        


        if($resultadoComprobacion -> num_rows){

            $resultadoComprobacion = mysqli_fetch_assoc($resultadoComprobacion);

            $resultadoPassword = password_verify($password, $resultadoComprobacion['Contrasena']);

            if($resultadoPassword){


                $queryRol = "SELECT Rol_idRol FROM empleado WHERE Usuarios_idUsuarios ='$resultadoComprobacion[idUsuarios]'";
                $resultadoRol = mysqli_fetch_assoc( mysqli_query($db, $queryRol));

                if ($resultadoRol['Rol_idRol'] == 1){
                    session_start();
                    header('Location:admin/Propiedades/Listado/index.php');
                    $_SESSION['usuario'] = $resultadoComprobacion['Correo'];
                    $_SESSION['idUsuarios'] = $resultadoComprobacion['idUsuarios'];
                    $_SESSION['login'] = true;
                } else if ($resultadoRol['Rol_idRol'] == 2){
                    session_start();
                    header('Location:admin/Asesores/index.php');
                    $_SESSION['usuario'] = $resultadoComprobacion['Correo'];
                    $_SESSION['idUsuarios'] = $resultadoComprobacion['idUsuarios'];
                    $_SESSION['login'] = true;

                } else if ($resultadoRol['Rol_idRol'] == 3 ){
                    header('Location:admin/');
                    session_start();
                    $_SESSION['usuario'] = $resultadoComprobacion['Correo'];
                    $_SESSION['idUsuarios'] = $resultadoComprobacion['idUsuarios'];
                    $_SESSION['login'] = true;
                }
            } else {
                $errores[] = "La contraseña es incorrecta";
            }
        } else {

            $errores[] = "El usuario no existe";


        }
    }
?>
    <main class="main__login">

        <?php foreach($errores as $error):?>
            
            <div class="error"><p><?php  echo $error ?></p></div>
            
            <?php endforeach?>
            
            <section>
                <form action="" method="POST">
            <label for="correo">

                

                <input type="email" id= "correo" name="correo" placeholder = "Correo" required>
            </label>
            <label for="password">
               
                <input type="password" id="password" name="password" placeholder = "Contraseña" required>
            </label>
            <section class="content__buttons">
            <input type="submit" value = "Entrar" class = "login__submit">
            <a class="login__submit"href="singup/index.php">Registrarme</a>
            </section>
        </form>

    </section>

    </main>
<?php

    require 'includes/footer.php'

?>

</body>
</html>