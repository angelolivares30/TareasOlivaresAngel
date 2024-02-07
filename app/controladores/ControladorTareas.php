<?php 
    class ControladorTareas{
        public function verTareasUsuarios(){
            $conexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $conexionDB->getConnexion();

            $tareasDAO = new TareasDAO($conn);
            $idUsuario= Sesion::getUsuario()->getId();

            $tareasUsuario = $tareasDAO -> obtenerTareasPorUsuario($idUsuario);
            require 'app/vistas/inicio.php';            

        }

        public function verTarea(){
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();
            $tareasDAO = new TareasDAO($conn);
            $idTarea= htmlspecialchars($_GET['id']);
            $tarea = $tareasDAO->obtenerTareaPorID($idTarea);
            
            require 'app/vistas/ver_tarea.php';
        }
        public function insertarTarea(){
            $error ="";
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            $usuariosDAO = new UsuariosDAO($conn);
            $usuarios = $usuariosDAO->getAll();

            if($_SERVER['REQUEST_METHOD']=='GET'){
                $texto = htmlspecialchars($_GET['texto']);
                if(empty($texto)){
                    $error="El campo no puede estar vacío.";
                }else{
                    $tareasDAO = new TareasDAO($conn);
                    $tarea = new Tarea();
                    $tarea -> setTexto($texto);
                    $tarea -> setIdUsuario(Sesion::getUsuario()->getId());
                    $tareaDevuelta= $tareasDAO ->insertarTarea($tarea);
                    print $tareaDevuelta -> toJSON();
                }
            }
        } 
        public function borrarTarea(){
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();
            
            $tareasDAO = new TareasDAO($conn);
            $idTarea = htmlspecialchars($_GET['id']);
            $tarea = $tareasDAO->obtenerTareaPorID($idTarea);

            if(Sesion::getUsuario()->getId()==$tarea->getIdUsuario()){
                if($tarea = $tareasDAO->borrarTarea($idTarea)){
                    print json_encode(['respuesta'=>'ok']);
                }else{
                    print json_encode(['respuesta'=>'error', 'mensaje'=>'Tarea no encontrada']);
                }
            }else{
                guardarMensaje('No puedes borrar esta tarea');

            }



        }
        // public function modificarTarea(){
        //     $error = "";
        //     $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        //     $conn = $connexionDB->getConnexion();
        
        //     $usuariosDAO = new UsuariosDAO($conn);
        //     $usuarios = $usuariosDAO->getAll();
        
        //     if($_SERVER['REQUEST_METHOD']=='POST'){ // Cambiado a POST ya que estamos modificando una tarea
        //         $idTarea = htmlspecialchars($_POST['id']); // Suponiendo que se pasa el id de la tarea a modificar
        //         $texto = htmlspecialchars($_POST['texto']);
                
        //         if(empty($texto)){
        //             $error = "El campo no puede estar vacío.";
        //         } else {
        //             $tareasDAO = new TareasDAO($conn);
        //             $tarea = new Tarea();
        //             $tarea->setId($idTarea); // Setear el id de la tarea a modificar
        //             $tarea->setTexto($texto);
        //             // Puedes añadir más campos para modificar aquí
                    
        //             // Suponiendo que la función modificarTarea($tarea) existe en TareasDAO
        //             $tareaModificada = $tareasDAO->updateTarea($tarea);
                    
        //             // Manejo de errores o retorno de datos modificado
        //             if($tareaModificada) {
        //                 print $tareaModificada->toJSON();
        //             } else {
        //                 $error = "Error al modificar la tarea.";
        //                 // Puedes manejar el error de alguna manera apropiada aquí
        //             }
        //         }
        //     }
        // }
        public function modificarTarea(){
            $error ='';
    
    
            //Conectamos con la bD
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();
    
            //Obtengo el id del mensaje que viene por GET
            $idTarea = htmlspecialchars($_GET['id']);
            //Obtengo el mensaje de la BD
            $tareasDAO = new TareasDAO($conn);
            $tarea = $tareasDAO->obtenerTareaPorID($idTarea);
    
            //Obtengo las fotos de la BD
            $fotosDAO = new FotosDAO($conn);
            $fotos = $fotosDAO->getAllByIdTarea($idTarea);
    
            //Cuando se envíe el formulario actualizo el mensaje en la BD
            if($_SERVER['REQUEST_METHOD']=='POST'){
    
                //Limpiamos los datos que vienen del usuario
                $texto = htmlspecialchars($_POST['texto']);
                $idUsuario = Sesion::getUsuario()->getId();
    
                //Validamos los datos
                if(empty($texto)){
                    $error = "Los dos campos son obligatorios";
                }
                else{
                    $tarea->setTexto($texto);
                    $tarea->setIdUsuario($idUsuario);
    
                    $tareasDAO->updateTarea($tarea);
                    $tareas =  $tareasDAO ->obtenerTareasPorUsuario(Sesion::getUsuario() -> getId());
                    require 'app/vistas/inicio.php';
                    die();
                }
    
            } //if($_SERVER['REQUEST_METHOD']=='POST'){
            
                require 'app/vistas/editar_tarea.php';
        }
        
        function addImageTarea(){
            $idTarea = htmlentities($_GET['idTarea']);
            $nombreArchivo = htmlentities($_FILES['foto']['name']);
            $informacionPath = pathinfo($nombreArchivo);
            $extension = $informacionPath['extension'];
            $nombreArchivo = md5(time()+rand()) . '.' . $extension;
            move_uploaded_file($_FILES['foto']['tmp_name'],"web/images/$nombreArchivo");
    
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();
            $fotosDAO = new FotosDAO($conn);
            $foto = new Foto();
            $foto->setIdTarea($idTarea);
            $foto->setNombreArchivo($nombreArchivo);
            $fotosDAO->insert($foto);
            print json_encode(['respuesta'=>'ok', 'nombreArchivo'=> $nombreArchivo]);
    
        }

        function deleteImageMensaje(){
            $idFoto = htmlentities($_GET['idFoto']);
            $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
            $conn = $connexionDB->getConnexion();
            $fotosDAO = new FotosDAO($conn);
            $foto = new Foto();
            $foto->setId($idFoto);
            if($fotosDAO->delete($foto))
            {
                print json_encode(['respuesta'=>'ok']);
            }
            else{
                print json_encode(['respuesta'=>'error', 'mensaje'=>'No se ha encontrado la foto']);
            }
        }
    }



?>