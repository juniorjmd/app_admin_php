  $(document).ready(function() { 
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Evita el envío normal del formulario
                let datos = $(this).serialize();
                //console.log(JSON.stringify(datos));
                let urlPost = login ; 
                $.ajax({
                    type: 'POST',
                    dataType: 'json',   
                    url: urlPost , // Actualiza esta URL a la ruta correcta en tu aplicación
                    data: datos, // Serializa los datos del formulario
                    success: function(response) {
                        // Manejo de la respuesta del servidor
                          Swal.fire({
                            title: 'Login exitoso',
                            text: '¡Bienvenido!',
                            icon: 'success'
                        }).then(()=>window.location = home );  
                    },
                    error: error_response 
                });
            });
        });