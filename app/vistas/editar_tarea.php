<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        form {
            background-color: #fff;
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #fotos {
            margin-bottom: 20px;
        }

        .imagenTarea {
            width: 100px;
            height: 100px;
            margin-right: 10px;
            margin-bottom: 10px;
            object-fit: cover;
            border-radius: 5px;
        }

        #addImage {
            display: inline-block;
            width: 100px;
            height: 100px;
            line-height: 100px;
            text-align: center;
            background-color: #eee;
            color: #555;
            font-size: 24px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="file"] {
            display: none;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Editar Tarea</h1>
    <?= $error ?>
    <form action="index.php?accion=editar_tarea&id=<?= $idTarea ?>" method="post" data-idTarea="<?= $idTarea ?>" id="formularioEditar">
        <input type="text" name="texto" placeholder="Texto" value="<?= $tarea->getTexto() ?>"><br>
        <div id="fotos">
            <div id="fotos2">
                <?php foreach ($fotos as $foto) : ?>
                    <img src="web/images/<?= $foto->getNombreArchivo() ?>" class="imagenTarea" ;>
                <?php endforeach; ?>
            </div>
            <div id="addImage">+</div>
            <input type="file" style="display: none;" id="inputFileImage">
        </div>

        <input type="submit">
        

    </form>
    <script src="./web/js/editarTarea.js"></script>

</body>

</html>