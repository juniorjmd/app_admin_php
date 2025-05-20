 <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Nuevo Usuario</h5>
                <i class="fas fa-close " style="cursor: pointer"   data-bs-dismiss="modal" aria-label="Close"></i> 
            </div>
        <!--    $_param = ['crt_new_usr_name' ,  'crt_new_usr_perfil' , 'crt_new_usr_login' ,  'crt_new_usr_mail'] ; -->
            <div class="modal-body">
                <form id="form-create-new-user">
                    <div class="form-group">
                        <label for="crt_new_usr_name">Nombre</label>
                        <input type="text" class="form-control" name="crt_new_usr_name" id="crt_new_usr_name" placeholder="Nombre del usuario">
                        <span id="name-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un nombre de usuario</span>
                    
                    </div>
                    <div class="form-group">
                        <label for="crt_new_usr_mail">Email</label>
                        <input type="email" class="form-control" name="crt_new_usr_mail" id="crt_new_usr_mail" placeholder="Email del usuario">
                    <span id="email-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un mail valido</span>
                    
                    </div>
                     <div class="form-group">
                        <label for="crt_new_usr_login">Usuario</label>
                        <input type="text" class="form-control" name="crt_new_usr_login" id="crt_new_usr_login" placeholder="Usuario">
                    <span id="login-msg-required-field"  class="msg-required-field text-danger visually-hidden">* es necesario suministrar un usuario</span>
                    
                     </div>
                     <div class="form-group">
                        <label for="crt_new_usr_numid">Identificación</label>
                        <input type="text" class="form-control" name="crt_new_usr_numid" id="crt_new_usr_numid" placeholder="Num. identificación">
                        <span id="numid-msg-required-field"  class="msg-required-field text-danger visually-hidden">* es necesario suministrar un número de identificacion</span>
                        <span id="numid-unique-msg-required-field"  class="msg-required-field text-danger visually-hidden">* El número de identificacion ya se encuentra asignado</span>
                    
                     </div>
                     <div class="form-group">
                        <label for="crt_new_usr_perfil">Perfil</label>
                        <select class="form-control" name="crt_new_usr_perfil" id="crt_new_usr_perfil"> 
                             <option value="0">Seleccionar un perfil</option> 
                            <?php foreach($listaPerfil as $key => $value) { ?>
                            <option value="<?=$value->id; ?>"><?=$value->nombre; ?></option> 
                                <?php } ?>
                        </select>
                       
                        <span id="perfil-msg-required-field"  class="msg-required-field text-danger visually-hidden">* es necesario suministrar un perfil de usuario</span>
                     </div>
                     <div class="form-group">
                        <label for="crt_new_usr_pass">Password</label>
                        <input type="text" class="form-control" name="crt_new_usr_pass" id="crt_new_usr_pass" placeholder="Password">
                        <span id="pass-msg-required-field"  class="msg-required-field text-danger visually-hidden">* es necesario suministrar una contraseña valida
                         <p> recuerde que la contraseña debe cumplir con las siguientes validaciones : </p>
                            <ul>
                                <li>Al menos una letra mayúscula</li>
                                <li>Al menos una letra minúscula</li>
                                <li>Al menos un número</li>
                                <li>Al menos un carácter especial( @ * # " $ % & - _ )</li>
                                <li>Tenga una longitud mínima de 14 caracteres</li>
                            </ul>
                        </span>
                    
                     </div>
                    
                    
                    <div class="form-group"><br>
                       <button type="submit" class="btn btn-primary" >Guardar</button>
                     </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>
 
