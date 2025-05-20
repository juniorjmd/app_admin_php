<div class="modal fade" id="changeNameDirModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="addUserModalLabel">Renombrar Directorio</h5>
               <i class="fas fa-close " style="cursor: pointer"   data-bs-dismiss="modal" aria-label="Close"></i> 
           </div> 
           <div class="modal-body">
               <form  id="form_chg_nombre_dir" method="POST" class="p-4 border rounded">
   <input type="hidden" name="action" value="createMenu">
 <div class="mb-3">
       <label for="name" class="form-label">Path Directorio:</label>
       <input type="text" readonly="true" id="chg_nombre_dir_padre" name="chg_nombre_dir_padre" class="form-control"  required> 
       <span id="folder_padre-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar el path de la carpeta contenedora</span>
 
   </div>
   <div class="mb-3">
       <label for="name" class="form-label">Nombre Directorio :</label>
       <div class="input-group">
       <input type="text" id="chg_nombre_dir_name" name="chg_nombre_dir_name" class="form-control" placeholder="Ingresa el nombre del menú" required>
         </div> 
       <span id="folder_name-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un nombre de carpeta</span>
 
   </div> 
   <button type="submit" class="btn btn-primary">Cambiar Nombre</button>
</form>

           </div></div></div></div>