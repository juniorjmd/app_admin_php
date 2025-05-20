 
$(document).ready(()=>{  
     window.scrollTo(0, document.body.scrollHeight); 
});
 
function changeRelationUserFolder( id , folder , est){
  //  Swal.fire('usuario ' +idUsuario +' estado ' + estado ); 
                let estado =  (est)? 1 : 0 ;  
                let urlPost = `${home}user/mUserMenuRel/${id}/${folder}/${estado}`    ; 
                let datos = {id , folder , est};  
                $.ajax({
                     type: 'GET',
                    dataType: 'json',   
                    url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación 
                    success: function(response) { window.location = `${home}user/userFolder/${id}`  ;  
                    },
                    error:error_response
                });
    
}