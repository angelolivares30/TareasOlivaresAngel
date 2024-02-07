<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estilos para el Formulario de Registro</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
        }
        /* Estilos para el contenedor del modal */
        .modal {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
        }
        /* Estilos para el título del modal */
        .modal h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        /* Estilos para los campos del formulario */
        .modal input[type="text"],
        .modal input[type="email"],
        .modal input[type="password"],
        .modal input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        /* Estilos para el botón de enviar */
        .modal input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            
        }
        /* Estilos para el botón de enviar al pasar el cursor */
        .modal input[type="submit"]:hover {
            background-color: #0056b3;
        }
        
    </style>
</head>
<body>
    <div class="modal">
        <h1>Registro</h1>
        <?= $error ?>
        <form action="index.php?accion=registrar" method="post" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Contraseña">
            <input type="submit" value="Registrar" id="registrar">
            <div class="link-login">
                <a href="index.php?accion=inicio">Iniciar sesion</a>
            </div>
        </form>
    </div>
</body>
</html>
