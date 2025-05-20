
<div id='container_edit_user' > 
  <div class="container mt-5" id="sub_container_edit_user" >
    <form id='form_update_perfil' autocomplete="false">
    <div class='row'>
        <div class="col-md-12 text-center">
            <h1 class="mb-4">Editar Perfil</h1>
        </div> 
    </div>
    <div class='row'>
        <div class="col-md-2  "></div>
        <div class="col-md-4 "> 
    <table class="table table-striped">
        <thead>
            <input type='hidden' id="edit_user_id" name="edit_user_id" value="<?=$perfilEdit->id;?>" />
            <tr><th>Nombre</th><td><input class="form-control" id="edit_user_name" name="edit_user_name" value="<?=$perfilEdit->nombre;?>" />
                  <span id="name-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un nombre de usuario</span>
                 </td></tr>
            
            <tr>
                <th>Estado</th><td><input readonly class="form-control" value="<?=($perfilEdit->activo==1)?'Activo':'Inactivo';?>" /></td></tr> 
        </thead>
    </table>
        </div>
        <div class="col-md-4 "> 
       <div class="row">
           <div class="col-md-12 "><h3>Recursos & permisos</h3> </div>
         </div>
             <div class="row" style='max-height: 400px; overflow-y: auto'>
           <div class="col-md-12 ">  
           <?php \App\Views\Base::renderPermisos($menu); ?> 
           </div>
         </div>
        </div></div>
     <div class='row'>
        <div class="col-md-4"> 
        </div>   <div class="col-md-2 text-right">
            <button class="btn btn-success btn-floating" id='btn_update_user' >
                <i class="fas fa-save"> </i>&nbsp;Guardar
            </button>
        </div>
        <div class="col-md-2 text-right">
            <a href ="<?php echo CARPETA_CONTENEDORA; ?>/admin/perfil" class="btn btn-danger btn-floating"  >
              <i class="fa-solid fa-arrow-left"></i> &nbsp;Cancelar
            </a>
        </div>
    </div>
  
</div> 
    </form>
  </div>
</div> 