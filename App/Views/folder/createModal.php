<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="addUserModalLabel">Agregar Nueva Carpeta</h5>
               <i class="fas fa-close " style="cursor: pointer"   data-bs-dismiss="modal" aria-label="Close"></i> 
           </div> 
           <div class="modal-body">
               <form  id="form_crt_new_folder" method="POST" class="p-4 border rounded">
   <input type="hidden" name="action" value="createMenu">

   <div class="mb-3">
       <label for="name" class="form-label">Nombre del Menú:</label>
       <input type="text" id="crt_new_folder_name" name="crt_new_folder_name" class="form-control" placeholder="Ingresa el nombre del menú" required>
      <span id="name-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un nombre de usuario</span>

   </div>

   <div class="mb-3">
       <label for="description" class="form-label">Descripción:</label>
       <textarea id="crt_new_folder_description" name="crt_new_folder_description" class="form-control" rows="4" placeholder="Ingresa una descripción" required></textarea>
       <span id="description-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un nombre de usuario</span>
   </div>

   <div class="mb-3">
       <label for="display_name" class="form-label">Nombre para Mostrar:</label>
       <input type="text" id="crt_new_folder_display_name" name="crt_new_folder_display_name" class="form-control" placeholder="Ingresa el nombre para mostrar" required>
       <span id="display_name-msg-required-field" class="msg-required-field text-danger visually-hidden">* es necesario suministrar un nombre de usuario</span>
   </div>


   <button type="submit" class="btn btn-primary">Crear Menú</button>
</form>

           </div></div></div></div>