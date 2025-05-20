 
$(document).ready(()=>{  
    $('.delete_file').on('click', confirma_eliminar_file)   ; 
    $('.upload_file').on('click', subir_archivos)   ; 
     $('.create_folder').on('click', crear_nueva_carpeta); 
     $('.rename_file').on('click', renombrar_file); 
     $('.rename_dir').on('click', renombrar_carpeta); 
     
    $('.delete_dir').on('click', confirma_eliminar_dir)   ; 
    $('#form_crt_new_folder').on('submit', create_new_dir)   ; 
    $('#form_chg_nombre_dir').on('submit', cambiar_nombre_dir)   ; 
    $('#form_chg_nombre_file').on('submit', cambiar_nombre_file)   ; 
     $('#file_upload').on('change', enviar_archivos); 
}); 


function renombrar_carpeta(event){
    let path =  $(this).parent().find('#paht_input').val();
    let nombre_real = $(this).data('real');
    $('#chg_nombre_dir_padre').val(path);
    let nombreSinExtension = nombre_real.substring(0, nombre_real.lastIndexOf('.')) || nombre_real; // Nombre sin extensión
    let extension = nombre_real.substring(nombre_real.lastIndexOf('.') + 1) || ""; // Extensión

    $('#chg_nombre_dir_name').val(nombreSinExtension);
    $('#chg_nombre_dir_name_extension').val(extension);
    $("#btn_activa_modal_chnd").trigger('click');
}

function renombrar_file(event){
    let path =  $(this).parent().find('#paht_input').val();
    let nombre_real = $(this).data('real');
    $('#chg_nombre_file_padre').val(path);
    let nombreSinExtension = nombre_real.substring(0, nombre_real.lastIndexOf('.')) || nombre_real; // Nombre sin extensión
    let extension = nombre_real.substring(nombre_real.lastIndexOf('.') + 1) || ""; // Extensión

    $('#chg_nombre_file_name').val(nombreSinExtension);
    $('#chg_nombre_file_name_extension').val(extension);
    $("#btn_activa_modal_chnf").trigger('click');
}
function crear_nueva_carpeta(event){
    let path =  $(this).parent().find('#paht_input').val();
    $('#crt_new_folder_padre').val(path);
    $("#btn_activa_modal").trigger('click');
}
function subir_archivos(event){
     event.preventDefault();
     let path =  $(this).parent().find('#paht_input').val();
    $('#path_file').val( path);
    $('#file_upload').trigger('click');
}
function confirma_eliminar_dir(event){
    event.preventDefault(); 
      let id_elm =  $(this).parent().find('#paht_input').val(); 
    Swal.fire( {title: '¿Estás seguro?',
        text: "Esta acción eliminará el directorio y todo su contenido. ¡No podrás revertirlo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar',
        reverseButtons: true // Invierte los botones para poner "Cancelar" a la izquierda
    }).then((result) =>{if(result.isConfirmed){ elimina_dir(id_elm); }});
}

function confirma_eliminar_file(event){
    event.preventDefault(); 
      let id_elm =  $(this).parent().find('#paht_input').val(); 
    Swal.fire( {title: '¿Estás seguro?',
        text: "Esta acción eliminará el elemento. ¡No podrás revertirlo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar',
        reverseButtons: true // Invierte los botones para poner "Cancelar" a la izquierda
    }).then((result) =>{if(result.isConfirmed){ elimina_file(id_elm); }});
}

function enviar_archivos(event){    
     event.preventDefault(); 
    let files = $('#file_upload')[0].files; // Obtener los archivos seleccionados
    let path = $('#path_file').val(); // Obtener el path del atributo oculto
    let formData = new FormData(); 
    // Añadir los archivos al FormData
    for (let i = 0; i < files.length; i++) {
        formData.append('files[]', files[i]);
    } 
    // Añadir el path al FormData
    formData.append('path', path);
  $.ajax({
        url: `${home}contenido`, // Actualiza esta URL según la ruta de tu aplicación
        type: 'POST',
        data: formData,
        processData: false, // No procesar datos como string
        contentType: false, // No establecer tipo de contenido
        success: function(response) {
            Swal.fire({
                title: '¡Archivos subidos!',
                text: 'Los archivos se han subido correctamente.',
                icon: 'success'
            }).then(() => window.location.reload(true));
        },
        error: function(xhr, status, error) {
           
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al subir los archivos.'+ error,
                icon: 'error'
            });
        }
    });

}
function elimina_file(path){
    let urlPost = `${home}contenido/dltf`    ;  
               let datos = {path}; 
    
    $.ajax({
         type: 'POST',
        dataType: 'json',  
        data: datos, 
        url: urlPost ,  
        success: function(response) {
            // Manejo de la respuesta del servidor
             Swal.fire(
                'Eliminado',
                'El elemento ha sido eliminado.' + path ,
                'success'
            ).then(()=> window.location.reload(true) );

        },
        error: error_response
    });
}
function elimina_dir( path ){
     let urlPost = `${home}contenido/dltd`    ; 
     let datos = {path}; 
   
    $.ajax({
         type: 'POST',
        dataType: 'json',  
        data: datos, 
        url: urlPost ,  
        success: function(response) {
            // Manejo de la respuesta del servidor
             Swal.fire(
                'Eliminado',
                'El elemento ha sido eliminado.' + path ,
                'success'
            ).then(()=> window.location.reload(true) );

        },
        error: error_response
    });
}
function create_new_dir(event){
    event.preventDefault(); 
    if(valida_campos_new_form()){
           //  Swal.fire('usuario ' +idUsuario +' estado ' + estado ); 
        let urlPost = `${home}contenido/directory`    ;  
        let datos = $("#form_crt_new_folder").serialize(); 
        
        $.ajax({
             type: 'POST',
            dataType: 'json',   
            url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación
            data: datos, 
            success: function(response) {
                // Manejo de la respuesta del servidor
                  Swal.fire({
                    title: 'Directorio creado con exito.',
                    text: '¡ok!',
                    icon: 'success'
                }).then(()=>   window.location.reload(true) );  
            },
            error: error_response
        });
    }
}
function valida_campos_new_form(){ 
    $('.msg-required-field').addClass('visually-hidden');
   // ['crt_new_usr_name' ,  'crt_new_usr_perfil' , 'crt_new_usr_login' ,  'crt_new_usr_mail'] 
    if ($('#crt_new_folder_padre').val() === '')
       {$('#folder_padre-msg-required-field').removeClass('visually-hidden'); return false; } 
    if ($('#crt_new_folder_name').val() === '' )
       {$('#folder_name-msg-required-field').removeClass('visually-hidden'); return false; } 
    return true;
}
function cambiar_nombre_dir(event){
    event.preventDefault(); 
    if(valida_campos_cnd_form()){
           //  Swal.fire('usuario ' +idUsuario +' estado ' + estado ); 
        let urlPost = `${home}contenido/chgNameDir`    ;  
        let datos = $("#form_chg_nombre_dir").serialize(); 
        
        $.ajax({
             type: 'POST',
            dataType: 'json',   
            url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación
            data: datos, 
            success: function(response) {
                // Manejo de la respuesta del servidor
                  Swal.fire({
                    title: 'Directorio modificado con exito.',
                    text: '¡ok!',
                    icon: 'success'
                }).then(()=>   window.location.reload(true) );  
            },
            error: error_response
        });
    }
} 
function valida_campos_cnd_form(){ 
    $('.msg-required-field').addClass('visually-hidden');
   // ['crt_new_usr_name' ,  'crt_new_usr_perfil' , 'crt_new_usr_login' ,  'crt_new_usr_mail'] 
    if ($('#chg_nombre_dir_padre').val() === '')
       {$('#folder_padre-msg-required-field').removeClass('visually-hidden'); return false; } 
    if ($('#chg_nombre_dir_name').val() === '' )
       {$('#folder_name-msg-required-field').removeClass('visually-hidden'); return false; } 
    return true;
}

function cambiar_nombre_file(event){
    event.preventDefault(); 
    if(valida_campos_cnf_form()){
           //  Swal.fire('usuario ' +idUsuario +' estado ' + estado ); 
        let urlPost = `${home}contenido/chgNameFile`    ;  
        let datos = $("#form_chg_nombre_file").serialize();  
        $.ajax({
             type: 'POST',
            dataType: 'json',   
            url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación
            data: datos, 
            success: function(response) {
                // Manejo de la respuesta del servidor
                  Swal.fire({
                    title: 'Archivo modificado con exito.',
                    text: '¡ok!',
                    icon: 'success'
                }).then(()=>   window.location.reload(true) );  
            },
            error: error_response
        });
    }
} 
function valida_campos_cnf_form(){ 
    $('.msg-required-field').addClass('visually-hidden');
   // ['crt_new_usr_name' ,  'crt_new_usr_perfil' , 'crt_new_usr_login' ,  'crt_new_usr_mail'] 
    if ($('#chg_nombre_file_padre').val() === '')
       {$('#folder_padre-msg-required-field').removeClass('visually-hidden'); return false; } 
    if ($('#chg_nombre_file_name').val() === '' )
       {$('#folder_name-msg-required-field').removeClass('visually-hidden'); return false; } 
    return true;
}