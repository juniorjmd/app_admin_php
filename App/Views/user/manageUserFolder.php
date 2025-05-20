<div class="container mt-5">
    <div class='row'>
        <div class="col-md-10">
            <h1 class="mb-4">Mantenimiento de Acceso a carpeta</h1>
        </div>
        <div class="col-md-2 text-right">
          
        </div>
    </div>
    <div class='row'>
        <div class="col-md-10">
            <h4 class="mb-4">Usuario = <?= $userEdit->name;?></h4>
        </div>
    <table class="table table-striped">
        <thead>
            <tr> 
                <th>Nombre</th> 
                <th>Activo</th> 
            </tr>
        </thead>
        <tbody> 
            <?php  
            foreach ($folders  as $key => $value) { 
                $checked = ( in_array( $value->id, $userEditFolders, true) )?'checked':'' ;
                ?> 
            <tr>
                <td><?=$value->name;?></td> 
                <td> 
                    <div class="form-check form-switch">
                        <input class="form-check-input" value='<?=$value->id ;?>' type="checkbox"  <?=$checked;?> 
                                   onclick='changeRelationUserFolder(<?= $userEdit->id;?> , <?=$value->id;?> , this.checked )' )'> 
                    </div>
                    
                </td> 
            </tr>  
            <?php } ?>
        </tbody>
    </table>
</div>

 