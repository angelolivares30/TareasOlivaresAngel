<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="ver_tarea">
        <?php if($tarea!= null): ?>
            <div class="texto"><?= $tarea->getTexto() ?></div>
            <div class="fecha"><?= $tarea ->getFecha() ?></div>
            <?php else:?>
                <strong>Mensaje con id <?= $id ?> no encontrado</strong>
                <?php endif; ?>
                <br>
                <a href="">Volver al listado</a>
    </div>
</body>
</html>