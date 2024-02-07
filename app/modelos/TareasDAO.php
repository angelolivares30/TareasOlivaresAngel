<?php
class TareasDAO
{
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    //OBTENER TODAS LAS TAREAS
    public function obtenerTodasLasTareas()
    {
        $query = "SELECT * FROM tareas";
        $resultados = $this->conn->query($query);
        $tareas = array();

        if ($resultados->num_rows > 0) {
            while ($tarea = $resultados->fetch_object(Tarea::class)) {
                $tareas[] = $tarea;
            }
        }
        return $tareas;
    }
    //OBTENER TAREA POR ID
    public function obtenerTareaPorID($id): Tarea|null
    {

        if (!$stmt = $this->conn->prepare("SELECT * FROM tareas WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        //si encuentra un resultado devuelve un objeto de la clase tarea , sino null
        if ($result->num_rows == 1) {
            $tarea = $result->fetch_object(Tarea::class);

            return $tarea;
        } else {
            return null;
        }
    }

    public function obtenerTareasPorUsuario($idUsuario)
    {
        $query = "SELECT * FROM tareas WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultados = $stmt->get_result();
        $tareas = array();
    
        if ($resultados->num_rows > 0) {
            while ($tarea = $resultados->fetch_object(Tarea::class)) {
                $tareas[] = $tarea;
            }
        return $tareas;

        }else{
            return null;
        }
    }
    
    //BORRAR TAREA
    public function borrarTarea($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $query = "delete from tareas where id=$id";

        $this->conn->query($query);
        if ($this->conn->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }
    //INSERTAR TAREA
    public function insertarTarea($tarea)
    {
        if (!$stmt = $this->conn->prepare("INSERT INTO tareas (texto, idUsuario) values (?,?)")) {
            die("Error al preparar la consulta update: " . $this->conn->error);
        }
        $texto = $tarea->getTexto();
        $idUsuario = $tarea->getIdUsuario();
        $stmt->bind_param('si', $texto, $idUsuario);

        if ($stmt->execute()) {
            $idInsertado = $this->conn->insert_id;
            $nuevaTarea = $this->obtenerTareaPorID($idInsertado);
            return $nuevaTarea;
        } else {
            return false;
        }
    }

    //MODIFICAR TAREA
    function updateTarea($tarea)
{
    if (!$stmt = $this->conn->prepare("UPDATE tareas SET texto=?, fecha=?, idUsuario=? WHERE id=?")) {
        die("Error al preparar la consulta update: " . $this->conn->error);
    }
    $texto = $tarea->getTexto();
    $fecha = $tarea->getFecha();
    $idUsuario = $tarea->getIdUsuario();
    $id = $tarea->getId();
    $stmt->bind_param('ssii', $texto, $fecha, $idUsuario, $id);
    
    if ($stmt->execute()) {
        // Si la actualización fue exitosa, obtén y devuelve la tarea actualizada
        $tareaActualizada = $this->ObtenerTareaPorId($id);
        return $tareaActualizada;
    } else {
        return null; // En caso de error, devuelve null o maneja el error según sea necesario
    }
}

}
