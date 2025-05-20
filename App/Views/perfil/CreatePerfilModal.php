  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Nuevo Perfil</h5>
                <i class="fas fa-close " style="cursor: pointer"   data-bs-dismiss="modal" aria-label="Close"></i> 
            </div>
        <!--    $_param = ['crt_new_perfil_name' ,  'crt_new_perfil_perfil' , 'crt_new_perfil_login' ,  'crt_new_perfil_mail'] ; -->
            <div class="modal-body">
                <form id="form-create-new-user">
                    <div class="form-group">
                        <label for="crt_new_perfil_name">Nombre</label>
                        <input type="text" class="form-control" name="crt_new_perfil_name" id="crt_new_perfil_name" placeholder="Nombre del usuario">
                        <span id="name-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un nombre de usuario</span>
                    
                    </div> 
                    
                    
                    <div class="form-group"><br>
                       <button type="submit" class="btn btn-primary" >Guardar</button>
                     </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>
 
