<div class="container mt-5">
    <div class='row'>
        <div class="col-md-10">
            <h1 class="mb-4">Mantenimiento de Contenido</h1>
        </div>
    </div>
     <div class='row'>
         <div class="col-md-1"></div>
        <div class="col-md-10">
            <?php print_r($folderAcceso); ?>
        </div>
    </div>
    <div style='display: none'>
     <form id="uploadForm" enctype="multipart/form-data">
         
        <input  type="hidden" name="path_file" id='path_file'>
        <input  type="file" name="files[]" multiple  id="file_upload" required>
        <button type="submit">Subir Archivo</button>
     </form>
    </div>
</div>


<div class="col-md-2 text-right" style="display: none">
    <button id="btn_activa_modal" class="btn btn-primary btn-floating btn-institucional" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus"></i>
            </button> 
    
     <button id="btn_activa_modal_chnf" class="btn btn-primary btn-floating btn-institucional" data-bs-toggle="modal" data-bs-target="#changeNameFileModal">
                <i class="fas fa-plus"></i>
            </button> 
     <button id="btn_activa_modal_chnd" class="btn btn-primary btn-floating btn-institucional" data-bs-toggle="modal" data-bs-target="#changeNameDirModal">
                <i class="fas fa-plus"></i>
            </button> 
        </div>



