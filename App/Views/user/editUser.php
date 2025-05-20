<div id='container_edit_user' > 
  <div class="container mt-5" id="sub_container_edit_user" >
    <form id='form_update_user' autocomplete="false">
    <div class='row'>
        <div class="col-md-12 text-center">
            <h1 class="mb-4">editar Usuarios</h1>
        </div> 
    </div>
    <div class='row'>
        <div class="col-md-2  "></div>
        <div class="col-md-8  "> 
    <table class="table table-striped">
        <thead>
            <input type='hidden' id="edit_user_id" name="edit_user_id" value="<?=$userEdit->id;?>" />
            <tr><th>Nombre</th><td><input class="form-control" id="edit_user_name" name="edit_user_name" value="<?=$userEdit->name;?>" />
                  <span id="name-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un nombre de usuario</span>
                 </td></tr>
            <tr>
                <th>Usuario</th><td><input class="form-control" id="edit_user_username" name="edit_user_username" value="<?=$userEdit->login;?>" />
                  <span id="username-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un usuario</span>
                 </td></tr>
            <tr>
                <th>Email</th><td><input class="form-control" id="edit_user_mail" name="edit_user_mail" value="<?=$userEdit->mail;?>" />
                  <span id="mail-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un correo electronico valido</span>
                 </td></tr>
            <tr>
                <th>Perfil</th><td> 
                
                  <select   class="form-control" id="edit_user_perfil" name="edit_user_perfil"> 
                             <option value="0">Seleccionar un perfil</option> 
                            <?php  foreach($listaPerfil as $key => $value) {
                                $checked = ($userEdit->perfil ==$value->id )? 'selected' : '';
                                ?>
                            <option value="<?=$value->id; ?>" <?=$checked;?> ><?=$value->nombre; ?></option> 
                                <?php } ?>
                        </select>  
                    <span id="perfil-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario escoger un perfil de usuario</span>
                 
                </td></tr>
            <tr>
                <th>Estado</th><td><input readonly class="form-control" value="<?=($userEdit->activo==1)?'Activo':'Inactivo';?>" /></td></tr> 
        </thead>
         
    </table>
        </div>
     <div class='row'>
        <div class="col-md-4"> 
        </div>   <div class="col-md-2 text-right">
            <button class="btn btn-success btn-floating" id='btn_update_user' >
                <i class="fas fa-save"> </i>&nbsp;Guardar
            </button>
        </div>
        <div class="col-md-2 text-right">
            <a href ="<?php echo CARPETA_CONTENEDORA; ?>/admin/user" class="btn btn-danger btn-floating"  >
              <i class="fa-solid fa-arrow-left"></i> &nbsp;Cancelar
            </a>
        </div>
    </div>
  
</div> 
    </form>
  </div>
</div> 