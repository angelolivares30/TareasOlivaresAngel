var botonInsertar = document.getElementById('crearTarea');
botonInsertar.addEventListener('click', function () {
    var texto = document.getElementById('nuevaTarea').value;
    fetch('index.php?accion=insertar_tarea&texto=' + texto)
        .then(respuesta => respuesta.json())
        .then(tarea => {
            var divTarea = document.createElement('div');
            divTarea.classList.add('tarea');

            // Crear el div para el texto de la tarea
            var divTexto = document.createElement('div');
            divTexto.classList.add('texto');
            divTexto.innerHTML = tarea.texto;
            divTarea.appendChild(divTexto);

            // Crear el ícono de papelera para eliminar la tarea
            var iconElement = document.createElement("i");
            iconElement.classList.add("fa-solid", "fa-trash", "papelera");
            iconElement.setAttribute("data-idTarea", tarea.id);
            iconElement.setAttribute('onclick', 'manejadorBorrar(this)');
            divTarea.appendChild(iconElement);

            // Crear la imagen de preloader
            var imgElement = document.createElement("img");
            imgElement.src = "web/images/preloader.gif";
            imgElement.classList.add("preloaderBorrar");
            divTarea.appendChild(imgElement);

            // Crear el enlace para editar la tarea
            var editarLink = document.createElement("a");
            editarLink.href = "index.php?accion=editar_tarea&id=" + tarea.id;
            var editarIcon = document.createElement("i");
            editarIcon.classList.add("fa-solid", "fa-pen-to-square", "color_gris");
            editarIcon.setAttribute("data-idTarea", tarea.id);
            editarLink.appendChild(editarIcon);
            divTarea.appendChild(editarLink);

            // Crear el ícono de tick según la existencia de tick
            var tickIcon = document.createElement("i");
            tickIcon.setAttribute('onclick', 'ponerTick(this)');
            tickIcon.classList.add("fa-regular", "fa-square-check","iconoTickOff");
            tickIcon.setAttribute("data-idTarea", tarea.id);
            divTarea.appendChild(tickIcon);

            // Agregar la tarea creada al DOM
            var parentElement = document.getElementById("tareas");
            parentElement.appendChild(divTarea);
            tickOn = document.querySelectorAll('.iconoTickOn');
            tickOff = document.querySelectorAll('.iconoTickOff');
            console.log(tickOn);
            console.log(tickOff);

        })
        .catch(
            error => console.log(error)
        )
});
