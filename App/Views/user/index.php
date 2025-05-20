<div class="container mt-5">
    <div class='row'>
        <div class="col-md-10">
            <h1 class="mb-4">Mantenimiento de Usuarios</h1>
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
                <th>Usuario</th> 
                <th>identificación</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody> 
            <?php  
            foreach ($listaUser as $key => $value) { 
                //print_r($value);die();
                $checked = ($value->activo == 1)?'checked':'' ;
                ?> 
            <tr>
                <td><?=$value->name         ;?></td>
                <td><?=$value->login        ;?></td>
                <td><?=$value->numid        ;?></td>
                <td><?=$value->mail         ;?></td>
                <td><?=$value->nombrePerfil ;?></td>
                <td> 
                    <div class="form-check form-switch">
                        <input class="form-check-input" value='<?=$value->id ;?>' type="checkbox"  <?=$checked;?> 
                                   onclick='changeStateUser(<?=$value->id;?> , this.checked)' )'> 
                    </div>
                    
                </td>
                <td class="table-actions">
                    <a href="<?=URL_BASE;?>user/edit/<?=$value->id ;?>" class="text-primary"><i class="fas fa-pencil-alt"></i></a>
                    <a href="<?=URL_BASE;?>user/changePass/<?=$value->id ;?>" class="text-primary"><i class="fas fa-key"></i></a> 
                    <a href="<?=URL_BASE;?>user/userFolder/<?=$value->id ;?>" class="text-primary"><i class="fas fa-folder"></i></a>
                </td>
            </tr>  
            <?php } ?>
        </tbody>
    </table>
</div>