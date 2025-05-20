$(document).ready(()=>{  
$('#form-create-new-user').on('submit', create_new_user)   ; 
}); 

async function create_new_user(event){
    event.preventDefault();  
     console.log('en create_new_user inicia la espera de valida_campos_new_usuario' );
    let isValid = await valida_campos_new_usuario();
    console.log('en create_new_user finaliza la espera de valida_campos_new_usuario' , isValid);
    if(isValid) {
           //  Swal.fire('usuario ' +idUsuario +' estado ' + estado ); 
                let urlPost = `${home}user`    ;  
                let datos = $("#form-create-new-user").serialize();  
                //console.log(datos);
                $.ajax({
                     type: 'POST',
                    dataType: 'json',   
                    url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación
                    data: datos, 
                    success: function(response) {
                        // Manejo de la respuesta del servidor
                          Swal.fire({
                            title: 'Usuario creado con exito.',
                            text: '¡ok!',
                            icon: 'success'
                        }).then( ()=> window.location = `${home}user` ) ;  
                    },
                   error:  error_response 
                });
    }
 
} 
function validate_new_usr_numid(crt_new_usr_numid) { 
    let urlPost = `${home}user/validateNumId`;
    let datos = { crt_new_usr_numid };

    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: urlPost,
            data: datos,
            success: function(response) {
                console.log(response);
                resolve(response.status === 'ok');
            },
            error: function(error) {
                error_response(error);
                resolve(false); // o reject(error) si quieres que el error se propague
            }
        });
    });
}
async function valida_campos_new_usuario(){ 
    $('.msg-required-field').addClass('visually-hidden');
   // ['crt_new_usr_name' ,  'crt_new_usr_perfil' , 'crt_new_usr_login' ,  'crt_new_usr_mail'] 
    if ($('#crt_new_usr_name').val() === '')
    {
        $('#name-msg-required-field').removeClass('visually-hidden');
         return false;
    } 
    if ($('#crt_new_usr_mail').val() === '' || !validateEmail($('#crt_new_usr_mail').val()))
    {
        $('#email-msg-required-field').removeClass('visually-hidden');
        return false;
    }
   
    if ($('#crt_new_usr_login').val() === '')
    {
        $('#login-msg-required-field').removeClass('visually-hidden');
         return false;
    }
     if ($('#crt_new_usr_numid').val() === '')
    {
        $('#numid-msg-required-field').removeClass('visually-hidden');
         return false;
    }
      if ($('#crt_new_usr_numid').val() !== '')
    {
       // $('#numid-unique-msg-required-field').removeClass('visually-hidden');
       //  return false;
        console.log('inicio valida numid');
        let esValido = await validate_new_usr_numid($('#crt_new_usr_numid').val() ); 
        console.log('fin  valida numid');
        console.log('resultado validar numid ' ,  esValido);
        if (!esValido)
        {  
           $('#numid-unique-msg-required-field').removeClass('visually-hidden');  
            return false;
        } 
       
       
    }
    
    if ($('#crt_new_usr_perfil').val() === '')
    {
        $('#perfil-msg-required-field').removeClass('visually-hidden');
         return false;
    }
       if ($('#crt_new_usr_pass').val() === '' || !validatePassword($('#crt_new_usr_pass').val()))
    {
        $('#pass-msg-required-field').removeClass('visually-hidden');
        return false;
    }
   
    return true;
}

function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    
function validatePassword(password) {
    // Expresión regular para validar la contraseña
    const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@*#"$%&-_])[A-Za-z\d@*#"$%&-_]{14,}$/; 
    return re.test(password);
}
function changeStateUser( id , est){
  //  Swal.fire('usuario ' +idUsuario +' estado ' + estado ); 
                let estado =  (est)? 1 : 0 ;  
                let resp = (est)? 'Usuario Activo' : 'Usuario Inactivo' ; 
                let urlPost = `${home}user/${id}/${estado}`    ; 
                let datos = {id , estado}; 
                $.ajax({
                     type: 'DELETE',
                    dataType: 'json',   
                    url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación 
                    success: function(response) {
                        // Manejo de la respuesta del servidor
                          Swal.fire({
                            title: 'Cambio exitoso',
                            text: '¡'+resp+'!',
                            icon: 'success'
                        });
                       // window.location = `${home}user` ;  
                    },
                   error:  error_response
                });
    
}