function manejadorBorrar( xthis ){
    var papelera =  document.querySelectorAll('.papelera');
    
        //this referencia al elementos del DOM sobre el que hemos hecho click
    let idTarea = xthis.getAttribute('data-idTarea');
    //Mostramos preloader
    let preloader = xthis.nextElementSibling;
    preloader.style.visibility="visible";
    xthis.style.visibility='hidden';
    //Llamamos al script del servidor que borra la tarea pasándole el idTarea como parámetro
    fetch('index.php?accion=borrar_tarea&id='+idTarea,{method:'GET'})
    .then(datos => datos.json())
    .then(respuesta =>{
        if(respuesta.respuesta=='ok'){
            xthis.parentElement.remove();
        }
        else{
            alert("No se ha encontrado la tarea en el servidor");
            xthis.style.visibility='visible';
        }
    })
    .finally(function(){
        //Ocultamos preloader
       // preloader.style.visibility="hidden";
      //  xthis.style.visibility='visible';
    });
    
    
}