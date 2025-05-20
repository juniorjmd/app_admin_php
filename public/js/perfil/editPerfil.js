$(document).ready(()=>{   
     window.scrollTo(0, document.body.scrollHeight);
      
 $('.form-check-input').on('click', function() {
        check_input(this); // Pasar el elemento clickeado
    });
$('#form_update_perfil').on('submit', function(event){
    event.preventDefault();
      set_permisos_perfil('btn');
    }); 
}); 
const check_input = (event)=>{
    let val = $(event).prop('checked') ;  
    if(val){
        let papa =   `#permiso_${$(event).data('padre-id')}`;  
        $(papa).prop('checked' , true);
    }else{
       // $('[data-padre-id="1"]')
        let hijos = `[data-padre-id= "${$(event).data('id')}"]`; 
        $(hijos).prop('checked' , false);
    }
    set_permisos_perfil('');
    
};

const  set_permisos_perfil = (caller)=>{
    let urlPost = `${home}perfil`    ;
    const id_perfil = $("#edit_user_id").val();
    const nombre =  $("#edit_user_name").val().trim();
    if(nombre == '' ){
         Swal.fire({
                        title: 'Error' ,
                        text: 'El nombre no puede estar vacio', 
                        icon: 'error'
                    }); 
    }
    const permisos = $('.form-check-input:checked').map((_ , elm)=>$(elm).val()).get();
    // $requiredParams = ['id_perfil' , 'nombre' , 'permisos'] ; 

    const datos = {
        id_perfil , nombre ,permisos
    }; 
    
    $.ajax({
        type: 'PATCH',
        dataType: 'json', 
        contentType: 'application/json',
        data: JSON.stringify(datos), 
        url: urlPost , 
        success: function(response) {
            if(caller !== ''){   
            Swal.fire({
                            title: 'Permisos agregados con exito.',
                            text: '¡ok!',
                            icon: 'success'
                        }); } 
            },
            error:error_response
        });
} ; 

