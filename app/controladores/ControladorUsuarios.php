<?php
class ControladorUsuarios
{
    public function inicio()
    {
        require 'app/vistas/login.php';
    }
    public function login()
    {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //limpiamos los datos que vienen del usuario
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);


        //Validamos el usuario
        $usuariosDAO = new UsuariosDAO($conn);
        if ($usuario = $usuariosDAO->getByEmail($email)) {


            if ($password == $usuario->getPassword()) {
                //email y password correctos. Inciamos sesión
                Sesion::iniciarSesion($usuario);
                $tareasDAO = new TareasDAO($conn);
                $idUsuario = Sesion::getUsuario()->getId();
                $nombreCookie = "id";
                $valorCookie = $idUsuario;
                // Establece la duración de la cookie (en segundos), por ejemplo, un día
                $duracion = time() + (86400 * 30); // 86400 segundos = 1 día
                // Establece la ruta donde estará disponible la cookie ("/" significa que estará disponible en todo el sitio)
                $ruta = "/";
                // Crea la cookie usando la función setcookie()
                setcookie($nombreCookie, $valorCookie, $duracion, $ruta);
                $tareas = $tareasDAO->obtenerTareasPorUsuario($idUsuario);
                //Redirigimos a index.php
                require 'app/vistas/inicio.php';
                die();
            }
        }
        //email o password incorrectos, redirigir a index.php
        guardarMensaje("Email o password incorrectos");
        header('location: index.php');
    }
    public function logout() {
        // Define el nombre de la cookie que quieres borrar
        $nombreCookie = "id";
    
        // Establece la duración de la cookie en el pasado para que se elimine
        $duracion = time() - 3600; // Establece el tiempo a una hora antes
    
        // Establece la ruta de la cookie
        $ruta = "/";
    
        // Borra la cookie usando setcookie() con una duración en el pasado
        setcookie($nombreCookie, "", $duracion, $ruta);
    
        // Destruye la sesión actual
        session_start(); // Inicia la sesión si no está iniciada
        session_destroy(); // Destruye todas las variables de sesión
    
        // Redirige al usuario a alguna página después de cerrar sesión si es necesario
         header("Location: /TareasOlivaresAngel/index.php");
    }

    public function registrar()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Limpiamos los datos
            $nombre = htmlentities($_POST['nombre']);
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            $foto = '';

            //Validación 

            //Conectamos con la BD
            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            //Compruebo que no haya un usuario registrado con el mismo email
            $usuariosDAO = new UsuariosDAO($conn);
            if ($usuariosDAO->getByEmail($email) != null) {
                $error = "Ya hay un usuario con ese email";
            } else {
                if ($error == '')    //Si no hay error
                {
                    //Insertamos en la BD

                    $usuario = new Usuario();
                    $usuario->setNombre($nombre);
                    $usuario->setEmail($email);

                    //encriptamos el password
                    $usuario->setPassword($password);
                    if ($usuariosDAO->insert($usuario)) {
                        header("location: index.php");
                        die();
                    } else {
                        $error = "No se ha podido insertar el usuario";
                    }
                }
            }
        }
        require 'app/vistas/registrar.php';
    }
}
