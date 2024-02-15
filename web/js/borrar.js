function manejadorBorrar(xthis) {
    var papelera = document.querySelectorAll('.papelera');
    xthis.nextElementSibling.classList.remove('preloaderBorrar');
    //this referencia al elementos del DOM sobre el que hemos hecho click
    let idTarea = xthis.getAttribute('data-idTarea');
    //Mostramos preloader
    // Selecciona el preloader usando la clase correcta
    let preloader = xthis.parentElement.querySelector('.preloaderBorrar');

    //preloader.style.visibility = "visible";
   // xthis.style.visibility = 'hidden';
    //Llamamos al script del servidor que borra la tarea pasándole el idTarea como parámetro
    fetch('index.php?accion=borrar_tarea&id=' + idTarea, { method: 'GET' })
        .then(datos => datos.json())
        .then(respuesta => {
            if (respuesta.respuesta == 'ok') {
                xthis.parentElement.remove();
            }
            else {
                alert("No se ha encontrado la tarea en el servidor");
                xthis.style.visibility = 'visible';
            }
            xthis.nextElementSibling.classList.add('preloaderBorrar');
        })
        .catch(function () {
             xthis.nextElementSibling.classList.add('preloaderBorrar');
            // //Ocultamos preloader
            // preloader.style.visibility = "hidden";
            // xthis.style.visibility = 'visible';
        });


}