<div id='container_edit_user' > 
  <div class="container mt-5" id="sub_container_edit_user" >
       <form id="form_update_password" class="mt-4"  >
      <div class="row">
          <div class="col-lg-2"></div>
          <div class="col-lg-6">
    <h2 class="text-center">Actualizar Contraseña</h2>
    <h5 class="text-center">
        <input type="hidden" value="<?php echo ($habilitarCambio)?'CAMBIOPSW':'NOCAMBIOPSW' ?>" id="accion" />
    <?php if($habilitarCambio){ ?>
            <span class="form-control">
                Una vez ejecutado el cambio de contraseña, al usuario, una vez que inicie session,
                se le pedira obligatoriamente que cambie la contraseña asignada por el operario por una que solo el sepa</span>
            <?php   } ?> </h5>
        <!-- Mostrar nombre de usuario -->
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de Usuario</label>
            <span class="form-control"><?php echo htmlspecialchars($userEdit->name); ?></span>
           
        </div>
        <!-- Nueva contraseña -->
        <div class="form-group">
            <label for="new_password" class="form-label">Nueva Contraseña</label>
            <div class="input-group">
                <input type="hidden"   value="<?=$userEdit->id;?>" id="edit_user_id" name="edit_user_id">
                <input type="password" class="form-control" id="new_password" name="new_password" required>
                <button class="btn btn-outline-secondary" type="button"  onmouseover="showPassword('new_password', this)" onmouseout="hidePassword('new_password', this)">
                    <i class="fas fa-eye"></i>
                </button>
                  
            </div><span id="pass-msg-required-field" class="msg-required-field text-danger visually-hidden">* Es necesario suministrar una contraseña</span>
                   <span id="pass-val-msg-required-field" class="msg-required-field text-danger visually-hidden">* La contraseña debe cumplir con las validaciones</span>
               
        </div>
        
        
        <!-- Confirmar nueva contraseña -->
        <div class="form-group">
            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
            <div class="input-group">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                <button class="btn btn-outline-secondary" type="button"  onmouseover="showPassword('confirm_password', this)" onmouseout="hidePassword('confirm_password', this)">
                    <i class="fas fa-eye"></i>
                </button></div> <span id="pass2-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario validar la contraseña</span>
                 <span id="passiqual-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario que las contraseñas coincidan</span>
              
        </div></div>
          <div class="col-lg-3">
        <!-- Botón de enviar -->
       
        <div class="d-grid">
            <p> recuerde que la contraseña debe cumplir con las siguientes validaciones : </p>
                <ul>
                    <li>Al menos una letra mayúscula</li>
                    <li>Al menos una letra minúscula</li>
                    <li>Al menos un número</li>
                    <li>Al menos un carácter especial( @ * # " $ % & - _ )</li>
                    <li>Tenga una longitud mínima de 14 caracteres</li>
                </ul>
             
        </div> <div class="d-grid">
            <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
        </div>
   
</div> </div></form>
  </div>
</div>

 