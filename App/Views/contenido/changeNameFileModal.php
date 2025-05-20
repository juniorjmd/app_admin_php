<div class="modal fade" id="changeNameFileModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="addUserModalLabel">Renombrar Archivo</h5>
               <i class="fas fa-close " style="cursor: pointer"   data-bs-dismiss="modal" aria-label="Close"></i> 
           </div> 
           <div class="modal-body">
               <form  id="form_chg_nombre_file" method="POST" class="p-4 border rounded">
   <input type="hidden" name="action" value="createMenu">
 <div class="mb-3">
       <label for="name" class="form-label">Path Archivo:</label>
       <input type="text" readonly="true" id="chg_nombre_file_padre" name="chg_nombre_file_padre" class="form-control"  required> 
       <span id="folder_padre-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar el path de la carpeta contenedora</span>
 
   </div>
   <div class="mb-3">
       <label for="name" class="form-label">Nombre Archivo :</label>
       <div class="input-group">
       <input type="text" id="chg_nombre_file_name" name="chg_nombre_file_name" class="form-control" placeholder="Ingresa el nombre del menú" required>
       <span class="input-group-text">.</span>
       <input type="text" readonly="true"  id="chg_nombre_file_name_extension" name="chg_nombre_file_name_extension" class="form-control" placeholder="Ingresa el nombre del menú" >
       </div> 
       <span id="folder_name-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un nombre de carpeta</span>
 
   </div> 
   <button type="submit" class="btn btn-primary">Cambiar Nombre</button>
</form>

           </div></div></div></div>