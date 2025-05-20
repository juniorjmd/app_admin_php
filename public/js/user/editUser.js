 
$(document).ready(()=>{  
     window.scrollTo(0, document.body.scrollHeight);
$('#form_update_user').on('submit', update_user)   ; 
});

function update_user(event){
    event.preventDefault(); 
    if(valida_campos_update_usuario()){
           //  Swal.fire('usuario ' +idUsuario +' estado ' + estado ); 
                let urlPost = `${home}user`    ;  
                let datos = { 'edit_user_name' : $('#edit_user_name').val() ,
                  'edit_user_username' :  $('#edit_user_username').val() ,
                   'edit_user_mail' : $('#edit_user_mail').val() ,
                   'edit_user_perfil' : $('#edit_user_perfil').val() ,
                   'edit_user_id' :  $('#edit_user_id').val() 
                };
                
                console.log(urlPost , ' => ' , datos);
                $.ajax({
                     type: 'PUT',
                    dataType: 'json', 
                    contentType: 'application/json',
                    url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación
                    data: JSON.stringify(datos), 
                    success: function(response) {
                        // Manejo de la respuesta del servidor
                          Swal.fire({
                            title: 'Usuario editado con exito.',
                            text: '¡ok!',
                            icon: 'success'
                        }).then(() => window.location = `${home}user` );  
                    },
                     error: error_response
                });
    }
 
}


function valida_campos_update_usuario(){ 
    $('.msg-required-field').addClass('visually-hidden');
   // ['crt_new_usr_name' ,  'crt_new_usr_perfil' , 'crt_new_usr_login' ,  'crt_new_usr_mail'] 
    if ($('edit_user_name').val() === '')
    {
        $('#name-msg-required-field').removeClass('visually-hidden');
         return false;
    } 
    if ($('edit_user_username').val() === '')
    {
        $('#username-msg-required-field').removeClass('visually-hidden');
         return false;
    }
    if ($('#edit_user_mail').val() === '' || !validateEmail($('#edit_user_mail').val()))
    {
        $('#mail-msg-required-field').removeClass('visually-hidden');
        return false;
    }
   
    if ($('edit_user_perfil').val() === '')
    {
        $('#perfil-msg-required-field').removeClass('visually-hidden');
         return false;
    }
   
    return true;
}

function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
function changeStateUser( id , est){ 
                let urlPost = `${home}user/activate`    ; 
                let estado =  (est)? 1 : 0 ;  
                let datos = {id , estado}; 
                $.ajax({
                     type: 'POST',
                    dataType: 'json',   
                    url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación
                    data: datos, 
                    success: function(response) {
                        // Manejo de la respuesta del servidor
                          Swal.fire({
                            title: 'Cambio exitoso',
                            text: '¡ok!',
                            icon: 'success'
                        }).then(()=> window.location = `${home}user` );  
                    },
                    error:error_response
                });
    
}