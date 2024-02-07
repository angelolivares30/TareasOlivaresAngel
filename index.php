<?php
require_once 'app/config/config.php';
require_once 'app/modelos/ConexionDB.php';
require_once 'app/modelos/Tarea.php';
require_once 'app/modelos/TareasDAO.php';
require_once 'app/modelos/Usuario.php';
require_once 'app/modelos/UsuariosDAO.php';
require_once 'app/modelos/Tick.php';
require_once 'app/modelos/TicksDAO.php';
require_once 'app/modelos/Foto.php';
require_once 'app/modelos/FotosDAO.php';
require_once 'app/controladores/ControladorTareas.php';
require_once 'app/controladores/ControladorUsuarios.php';
require_once 'app/controladores/ControladorTicks.php';
require_once 'app/utils/funciones.php';
require_once 'app/modelos/Sesion.php';
session_start();

$mapa = array(
    'inicio' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'inicio',
        'privada' => false
    ),
    'ver_tarea' => array(
        "controlador" => 'ControladorTareas',
        'metodo' => 'verTarea',
        'privada' => false
    ),
    'insertar_tarea' => array(
        "controlador" => 'ControladorTareas',
        'metodo' => 'insertarTarea',
        'privada' => false
    ),
    'editar_tarea' => array(
        "controlador" => 'ControladorTareas',
        'metodo' => 'modificarTarea',
        'privada' => false
    ),
    'borrar_tarea' => array(
        'controlador' => 'ControladorTareas',
        'metodo' => 'borrarTarea',
        'privada' => false
    ),
    'login'=> array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'login',
        'privada'=> false
    ),
    'registrar' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'registrar',
        'privada' => false 
    ),
    'addImageTarea'=>array(
        'controlador'=>'ControladorTareas',
        'metodo'=>'addImageTarea',
        'privada' => false
    ),
    'deleteImageTarea' => array(
        'controlador'=> 'ControladorTareas',
        'metodo'=>'deleteImageTarea',
        'privada'=> false
    ),
    'insertar_tick'=>array(
        'controlador'=>'ControladorTicks',
        'metodo'=>'insertarTick',
        'privada'=>false
    ),
    'borrar_tick'=>array(
        'controlador'=>'ControladorTicks',
        'metodo'=>'borrarTick',
        'privada'=>false
    ),

);


//Parseo de la ruta
if (isset($_GET['accion'])) { //Compruebo si me han pasado una acción concreta, sino pongo la accción por defecto inicio
    if (isset($mapa[$_GET['accion']])) {  //Compruebo si la accción existe en el mapa, sino muestro error 404
        $accion = $_GET['accion'];
    } else {
        //La acción no existe
        header('Status: 404 Not found');
        echo 'Página no encontrada';
        die();
    }
} else {
    $accion = 'inicio';   //Acción por defecto
}

//Si la acción es privada compruebo que ha iniciado sesión, sino, lo echamos a index
// if(!isset($_SESSION['email']) && $mapa[$accion]['privada']){
if (!Sesion::existeSesion() && $mapa[$accion]['privada']) {
    header('location: index.php');
    guardarMensaje("Debes iniciar sesión para acceder a $accion");
    die();
}

//$acción ya tiene la acción a ejecutar, cogemos el controlador y metodo a ejecutar del mapa
$controlador = $mapa[$accion]['controlador'];
$metodo = $mapa[$accion]['metodo'];

//Ejecutamos el método de la clase controlador
$objeto = new $controlador();
$objeto->$metodo();
