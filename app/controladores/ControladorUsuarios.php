<?php 
class ControladorUsuarios{
    public function inicio(){
        require 'app/vistas/login.php';
    }
    public function login(){
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //limpiamos los datos que vienen del usuario
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        

        //Validamos el usuario
        $usuariosDAO = new UsuariosDAO($conn);
        if($usuario = $usuariosDAO->getByEmail($email)){
           
            if($password == $usuario->getPassword())
            {
                //email y password correctos. Inciamos sesión
                Sesion::iniciarSesion($usuario);
                $tareasDAO = new TareasDAO($conn);
                $idUsuario= Sesion::getUsuario()->getId();
    
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
    public function registrar(){
        $error='';

        if($_SERVER['REQUEST_METHOD']=='POST'){

            //Limpiamos los datos
            $nombre = htmlentities($_POST['nombre']);
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            $foto = '';

            //Validación 

            //Conectamos con la BD
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            //Compruebo que no haya un usuario registrado con el mismo email
            $usuariosDAO = new UsuariosDAO($conn);
            if($usuariosDAO->getByEmail($email) != null ){
            $error = "Ya hay un usuario con ese email";
            }
            else{
                if($error == '')    //Si no hay error
                {
                    //Insertamos en la BD

                    $usuario = new Usuario();
                    $usuario ->setNombre($nombre);
                    $usuario->setEmail($email);

                    //encriptamos el password
                    $usuario->setPassword($password);
                    if($usuariosDAO->insert($usuario)){
                        header("location: index.php");
                        die();
                    }else{
                        $error = "No se ha podido insertar el usuario";
                    }
                }
            }
    
        }   
        require 'app/vistas/registrar.php';

    }
}