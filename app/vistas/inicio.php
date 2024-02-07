<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
        }

        #tareas {
            max-width: 800px;
            margin: 0 auto;
        }

        .tarea {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s ease;
        }

        .tarea:hover {
            transform: translateY(-5px);
        }

        .texto {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .fa-trash {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #888;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .fa-trash:hover {
            color: #e74c3c;
        }

        .preloaderBorrar {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #nuevaTarea {
            width: calc(100% - 160px);
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px 0 0 8px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        #nuevaTarea:focus {
            border-color: #007bff;
        }

        #botonNuevaTarea {
            padding: 15px 25px;
            border: none;
            border-radius: 0 8px 8px 0;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #botonNuevaTarea:hover {
            background-color: #0056b3;
        }

        #preloaderInsertar {
            display: none;
            margin-left: 10px;
            vertical-align: middle;
        }
        .color{
            background-color:green;
        }
    </style>
</head>

<body>
    <h1>Todas tus tareas</h1>

    <div id="tareas">
        <?php foreach ($tareas as $tarea) : ?>
            <?php 
                $ticksDAO = new TicksDAO($conn);
                $idTarea = $tarea->getId();
                
                    $idUsuario = Sesion::getUsuario()->getId();
                    $existeTick = $ticksDAO->existByIdUsuarioIdTarea($idUsuario, $idTarea);
                
                ?>
            <div class="tarea <?php  echo $existeTick ?'color': ""?>">
                <div class="texto"><?= $tarea->getTexto() ?></div>
                <i class="fa-solid fa-trash papelera" data-idTarea="<?= $tarea->getId() ?>" onclick="manejadorBorrar(this)"></i>
                <img src="web/images/preloader.gif" class="preloaderBorrar">
                <a href="index.php?accion=editar_tarea&id=<?= $tarea->getId() ?>"><i class="fa-solid fa-pen-to-square color_gris" data-idTarea="<?= $tarea->getId() ?>"></i></a>
                <?php if($existeTick): ?>
                    <i class="fa-solid fa-square-check iconoTickOn" data-idTarea='<?=$tarea->getId()?>' onclick="quitarTick(this)" ></i>
                    <?php else:  ?>
                        <i class="fa-regular fa-square-check iconoTickOff"data-idTarea='<?=$tarea->getId()?>'onclick="ponerTick(this)" ></i>
                    <?php endif?>
            </div>
        <?php endforeach; ?>
    </div>

    <input type="text" id="nuevaTarea">
    <button id="crearTarea">Crear Tarea</button><img src="web/images/preloader.gif" id="preloaderInsertar">
    <script src="./web/js/crearTarea.js"></script>
    <script src="web/js/ticks.js"></script>
    <script src="web/js/borrar.js" type="text/javascript"></script>
</body>

</html>