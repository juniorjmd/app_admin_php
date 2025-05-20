$(document).ready(()=>{ console.log('JavaScript is working! y el jquery');
$('#form-create-new-user').on('submit', createNewPerfil)   ; 
}); 
function changeStatePerfil( id , est){
  //  Swal.fire('usuario ' +idUsuario +' estado ' + estado ); 
                let estado =  (est)? 1 : 0 ;  
                let urlPost = `${home}perfil/${id}/${estado}`    ; 
                let datos = {id , estado};  
                $.ajax({
                     type: 'DELETE',
                    dataType: 'json',   
                    url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación 
                    success: function(response) {
                        // Manejo de la respuesta del servidor
                          Swal.fire({
                            title: 'Cambio exitoso',
                            text: '¡Bienvenido!',
                            icon: 'success'
                        });
                       // window.location = `${home}user` ;  
                    },
                    error:  error_response 
                });
    
}

function createNewPerfil(){
     
    event.preventDefault(); 
    let nameNewPerfil = $('#crt_new_perfil_name').val();
    if(nameNewPerfil.trim() === ''){
        Swal.fire('El nombre del perfil no debe estar vacio').then(()=> $('#crt_new_perfil_name').focus());
        
        return ; 
        
        
    }
}