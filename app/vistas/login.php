<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estilos para el Encabezado</title>
    <style>
        /* Estilos para el cuerpo de la página */
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

        /* Estilos para el contenedor modal */
        .modal {
            background-color: #f0f0f0;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
        }

        /* Estilos para el encabezado */
        .modal-header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Estilos para el título de la página */
        .tituloPagina {
            margin: 0;
            font-size: 24px;
        }

        /* Estilos para el formulario */
        .formulario {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Estilos para los campos del formulario */
        .formulario input[type="email"],
        .formulario input[type="password"] {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Estilos para el botón de inicio de sesión */
        .formulario input[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Estilos para el botón de inicio de sesión al pasar el cursor */
        .formulario input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Estilos para el enlace de registro */
        .link-registro a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="modal">
        <div class="modal-header">
            <h1 class="tituloPagina">Iniciar Sesion</h1>
        </div>
        <form action="index.php?accion=login" method="post" class="formulario">
            <input type="email" name="email" placeholder="email">
            <input type="password" name="password" placeholder="password">
            <input type="submit" value="Iniciar sesión">
            <div class="link-registro">
                <a href="index.php?accion=registrar">Registrarse</a>
            </div>
        </form>

    </div>
</body>

</html>