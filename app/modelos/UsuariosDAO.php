<?php 
    class UsuariosDAO{
        private mysqli $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        //OBTENER USUARIO POR ID
        public function getById($id):Usuario|null {
            if(!$stmt = $this->conn->prepare("SELECT * FROM usuario WHERE id = ?"))
            {
                echo "Error en la SQL: " . $this->conn->error;
            }
            //Asociar las variables a las interrogaciones(parámetros)
            $stmt->bind_param('s',$id);
            //Ejecutamos la SQL
            $stmt->execute();
            //Obtener el objeto mysql_result
            $result = $stmt->get_result();
    
            //Si ha encontrado algún resultado devolvemos un objeto de la clase Usuario, sino null
            if($result->num_rows >= 1){
                $usuario = $result->fetch_object(Usuario::class);
                return $usuario;
            }
            else{
                return null;
            }
        } 

        //INSERTAR USUARIO
        function insert(Usuario $usuario): int|bool{
            if(!$stmt = $this->conn->prepare("INSERT INTO usuario (nombre, email, password) VALUES (?,?,?)")){
                die("Error al preparar la consulta insert: " . $this->conn->error );
            }
            $nombre = $usuario->getNombre();
            $email = $usuario -> getEmail();
            $password = $usuario->getPassword();
            $stmt->bind_param('sss',$nombre, $email, $password);
            if($stmt->execute()){
                return $stmt->insert_id;
            }
            else{
                return false;
            }
        }


        //Recoger usuario por email
        public function getByEmail($email):Usuario|null {
            if(!$stmt = $this->conn->prepare("SELECT * FROM usuario WHERE email = ?"))
            {
                echo "Error en la SQL: " . $this->conn->error;
            }
            //Asociar las variables a las interrogaciones(parámetros)
            $stmt->bind_param('s',$email);
            //Ejecutamos la SQL
            $stmt->execute();
            //Obtener el objeto mysql_result
            $result = $stmt->get_result();
    
            //Si ha encontrado algún resultado devolvemos un objeto de la clase Mensaje, sino null
            if($result->num_rows >= 1){
                $usuario = $result->fetch_object(Usuario::class);
                return $usuario;
            }
            else{
                return null;
            }
        }

            /**
     * Obtiene todos los usuarios de la tabla mensajes
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuario"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_tareas = array();
        
        while($usuario = $result->fetch_object(Usuario::class)){
            $array_usuarios[] = $usuario;
        }
        return $array_usuarios;
    }
        
    }



    


?>