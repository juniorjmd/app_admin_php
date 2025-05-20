function error_response(xhr, status, error) {
                        // Manejo de errores
                         console.error(xhr,'estatus', status, error);
                        let msg ='' ; 
                        if (xhr.responseJSON && xhr.responseJSON.message !== undefined) {
                             msg = xhr.responseJSON.message ; 
                             Swal.fire({
                                title: 'Error  - ' + xhr.status,
                                text: msg, 
                                icon: 'error'
                            }); 
                            } else {
                             msg =  xhr.statusText 
                        Swal.fire({
                                title: 'Error  - ' + xhr.status,
                                html: msg, 
                                icon: 'error'
                            });  
                        }
                        
                    }

  $(function () {
      let pathPadreAnterior = "";
      let paht_orden ; 
        // Enable drag and drop
        $("#sortable, .sort-element").sortable({
            connectWith: ".sort-element",
            placeholder: "ui-state-highlight",
            cancel: ".no-drag",
            start: function (event, ui) {
                const item = ui.item;  
                const padreAnterior = $(item[0]).parent().parent().find('.upload_file'); 
                const paht_orden_antes = $(item[0]).find('#paht_orden');   
                pathPadreAnterior = padreAnterior.data("path") || "Raíz"; 
                paht_orden = paht_orden_antes.val();
                
            },
            update: function (event, ui) {
                const item = ui.item;  
                const padreAnterior = $(item[0]).parent().parent().find('#paht_input');  
                let pathPadredespues = padreAnterior.val();  
                
                 if (pathPadreAnterior !== pathPadredespues) {
                console.log("El elemento se movió a una nueva ubicación."); }
            
             let listItems = $(item[0]).parent().children('.ui-sortable-handle'); 
            // Recalcular el orden según la posición en la lista
              let listado = [];
            listItems.each(function (index) {
                let order = index + 1; // El nuevo orden (empezando desde 1)
                $(this).find('#paht_orden').val(order); // Actualizar el valor de 'paht_orden'
                let name = $(this).find('#paht_input').val();
                let newName =  `${order}_fin_${$(this).find('#nombre_sin_orden').val()}`;
                listado.push({
                    name,  
                    order,
                    newName 
                });
            });
            
             
            let   datos = {
                archivos : listado , 
                pathContenedor : pathPadredespues   
            };
            modificarOrdenArchivos(datos);
            
                        }
        }).disableSelection();
    });
    
    function modificarOrdenArchivos(datos){
        let urlPost = `${home}contenido/orderAsing`    ;   
        //return;
        $.ajax({
             type: 'POST',
            dataType: 'json',   
            url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación
            data: datos, 
            success: function(response) {
                // Manejo de la respuesta del servidor
                  Swal.fire({
                    title: 'Directorio reordenado con exito.',
                    text: '¡ok!',
                    icon: 'success'
                }).then(()=>   window.location.reload(true) );  
            },
            error: error_response
        });
    }
    
    function generarJSONDesdeListado(listado) {
    const resultado = [];

    // Función recursiva para recorrer elementos
    function procesarElemento(ul, posicionPadre = '') {
        let posicion = 1; // Inicializa la posición para cada lista

        $(ul).children('li').each(function () {
            const nombre = $(this).find('i').next().text().trim(); // Nombre visible
            const rutaCompleta = $(this).attr('data-name'); // Ruta completa
            const posicionActual = posicionPadre ? `${posicionPadre}.${posicion}` : `${posicion}`;

            resultado.push({
                nombre: nombre,
                ruta: rutaCompleta,
                posicion: posicionActual,
            });

            // Verifica si tiene hijos (ul anidada)
            const sublista = $(this).children('ul');
            if (sublista.length > 0) {
                procesarElemento(sublista, posicionActual); // Procesar hijos recursivamente
            }

            posicion++; // Incrementa la posición para el siguiente elemento
        });
    }

    // Comienza el proceso con el listado principal
    procesarElemento(listado);

    return resultado;
}