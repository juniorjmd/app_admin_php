console.log('JavaScript is working!');
$(document).ready(()=>{ 
    $('#form_crt_new_folder').on('submit', create_new_folder)   ; 
    $('.delete_folder').on('click', confirma_eliminar_folder)   ; 
}); 

function confirma_eliminar_folder(event){
    event.preventDefault();
    let id_elm = $(this).data('id');
    Swal.fire( {title: '¿Estás seguro?',
        text: "Esta acción eliminará el elemento. ¡No podrás revertirlo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar',
        reverseButtons: true // Invierte los botones para poner "Cancelar" a la izquierda
    }).then((result) =>{if(result.isConfirmed){ elimina_folder(id_elm); }});
}

function elimina_folder( id ){
     let urlPost = `${home}folder/${id}`    ;  
               // let datos = {id}; 
                 
    $.ajax({
         type: 'DELETE',
        dataType: 'json',   
        url: urlPost ,  
        success: function(response) {
            // Manejo de la respuesta del servidor
             Swal.fire(
                'Eliminado',
                'El elemento ha sido eliminado.' + id,
                'success'
            ).then(()=> window.location = `${home}folder` );

        },
        error: error_response
    });
}
function create_new_folder(event){
    event.preventDefault(); 
    if(valida_campos_new_form()){
           //  Swal.fire('usuario ' +idUsuario +' estado ' + estado ); 
        let urlPost = `${home}folder`    ;  
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
                }).then(()=>  
                 window.location = `${home}folder` );  
            },
            error: error_response
        });
    }
}
function valida_campos_new_form(){ 
    $('.msg-required-field').addClass('visually-hidden');
   // ['crt_new_usr_name' ,  'crt_new_usr_perfil' , 'crt_new_usr_login' ,  'crt_new_usr_mail'] 
    if ($('crt_new_folder_name').val() === '')
       {$('#name-msg-required-field').removeClass('visually-hidden'); return false; } 
    if ($('#crt_new_folder_description').val() === '' )
       {$('description-msg-required-field').removeClass('visually-hidden'); return false; }
    if ($('#crt_new_folder_display_name').val() === '')
       {$('#display_name-msg-required-field').removeClass('visually-hidden'); return false; }  
    return true;
}