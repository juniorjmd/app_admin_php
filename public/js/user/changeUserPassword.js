 
$(document).ready(()=>{  
     window.scrollTo(0, document.body.scrollHeight);
$('#form_update_password').on('submit', update_user)   ; 
});

function update_user(event){
    event.preventDefault(); 
    if(valida_campos_update_usuario()){ 
                let urlPost = `${home}user/setchangePass`    ;   
                let accion = $('#accion').val();
                let datos = {
                   'edit_user_pass'  :  $('#new_password').val() ,
                   'edit_user_pass2' :  $('#confirm_password').val() , 
                   'edit_user_id'    :  $('#edit_user_id').val() ,
                   'accion_al_inicio': accion
                };
                console.log(urlPost , ' => ' , datos);
                $.ajax({
                     type: 'PATCH',
                    dataType: 'json', 
                    contentType: 'application/json',
                    url: urlPost ,  
                    data: JSON.stringify( datos ) , 
                    success: function(response) {
                        // Manejo de la respuesta del servidor
                          Swal.fire({
                            title: 'Usuario actualizado con exito.',
                            text: '¡ok!',
                            icon: 'success'
                        }).then(() => {
                            if (document.referrer) {
                                window.location = document.referrer;
                            } else {
                                window.location = home; // Redirigir a home si no hay referencia
                            }
                        } );
                    },
                    error: error_response
                });
    }
 
}


function valida_campos_update_usuario(){ 
    $('.msg-required-field').addClass('visually-hidden'); 
    if ($('#new_password').val() === '')
    {
        $('#pass-msg-required-field').removeClass('visually-hidden');
         return false;
    } 
    if (!validatePassword($('#new_password').val()) )
    {
        $('#pass-val-msg-required-field').removeClass('visually-hidden');
         return false;
    } 
    if ($('#confirm_password').val() === '')
    {
        $('#pass2-msg-required-field').removeClass('visually-hidden');
         return false;
    }
    if ($('#confirm_password').val() !== $('#new_password').val())
    {
        $('#passiqual-msg-required-field').removeClass('visually-hidden');
        return false;
    } 
    return true;
}

function validatePassword(password) {
    // Expresión regular para validar la contraseña
    const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@*#"$%&-_])[A-Za-z\d@*#"$%&-_]{14,}$/; 
    return re.test(password);
}

function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function showPassword(inputId, element) {
        const input = document.getElementById(inputId);
        const icon = element.querySelector('i');
        input.type = "text"; // Cambiar a texto
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash'); // Cambiar ícono a "ocultar"
    }

    // Ocultar la contraseña cuando se quita el mouse
    function hidePassword(inputId, element) {
        const input = document.getElementById(inputId);
        const icon = element.querySelector('i');
        input.type = "password"; // Cambiar a contraseña
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye'); // Cambiar ícono a "mostrar"
    }