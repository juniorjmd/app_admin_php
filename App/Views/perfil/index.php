<div class="container mt-5">
    <div class='row'>
        <div class="col-md-10">
            <h1 class="mb-4">Mantenimiento de Perfiles</h1>
        </div>
        <div class="col-md-2 text-right">
            <button class="btn btn-primary btn-floating btn-institucional" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus"></i>
            </button> 
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr> 
                <th>Nombre</th> 
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody> 
            <?php  
            foreach ($listaPerfil as $key => $value) { 
                $checked = ($value->activo == 1)?'checked':'' ;
                ?> 
            <tr>
                <td><?=$value->nombre ;?></td> 
                <td> 
                    <div class="form-check form-switch">
                        <input class="form-check-input" value='<?=$value->id ;?>' type="checkbox"  <?=$checked;?> 
                                   onclick='changeStatePerfil(<?=$value->id;?> , this.checked)' )'> 
                    </div>
                    
                </td>
                <td class="table-actions">
                    <a href="<?=URL_BASE;?>perfil/edit/<?=$value->id ;?>" class="text-primary"><i class="fas fa-pencil-alt"></i></a>
                   </td>
            </tr>  
            <?php } ?>
        </tbody>
    </table>
</div>