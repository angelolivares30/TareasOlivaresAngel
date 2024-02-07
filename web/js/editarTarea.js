let idTarea = document.getElementById('formularioEditar').getAttribute('data-idTarea');
        //Para que se abra la ventana de seleccionar archivo al hacer click en el botón
        let botonAddImage = document.getElementById('addImage');
        botonAddImage.addEventListener('click',function(){
            document.getElementById('inputFileImage').click();
        });

        //Enviamos el archivo por AJAX cuando se modifique el campo input (cuando se seleccione un archivo)
        let inputFileImage = document.getElementById('inputFileImage');
        inputFileImage.addEventListener('change',function(){
            let formData = new FormData();
            formData.append('foto',inputFileImage.files[0]);

            fetch('index.php?accion=addImageTarea&idTarea='+ idTarea,{
                method: 'POST',
                body: formData
            })
            .then(datos => datos.json())
            .then(respuesta => {
                console.log(respuesta);
                let nuevaFoto = document.createElement("img");
                nuevaFoto.classList.add('imagenTarea');
                nuevaFoto.setAttribute("src",'web/images/'+respuesta.nombreArchivo);
                document.getElementById('fotos2').append(nuevaFoto);
            })
         });
         