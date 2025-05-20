<div class="container mt-5">
    <div class='row'>
        <div class="col-md-10">
            <h1 class="mb-4">Mantenimiento de Carpetas</h1>
        </div>
        <div class="col-md-2 text-right">
            <button class="btn btn-primary btn-floating btn-institucional" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus"></i>
            </button> 
        </div>
    </div> 
    <table class="table ">
        <tr>
            <th>Carpeta</th>
            <th>Ruta</th>
            <th>Descripcion</th>
            <th>Nombre Menu</th>
            <th>Fecha Creacion</th>
            <th>Editar WP</th>
        </tr>
        <?php foreach ($folders as $folder): ?>
           <?php 
            $fecha = new DateTime($folder->date_crt);
            //wp-admin/post.php?post=123&action=edit
           //$urlWP =  URL_FRONT.'wp-admin/customize.php?url='.URL_FRONT.str_replace(' ', '-', \Core\helper::quitarTildes( $folder->display_name));  
           $urlWP =  URL_FRONT.'wp-admin/post.php?post='.$folder->id_wp.'&action=edit';
           ?> 
       
        
        
        <tr> 
            <td> <?php echo htmlspecialchars($folder->name ); ?> </td>
            <td> <?php echo htmlspecialchars($folder->ruta_fisica ); ?> </td>
            <td> <?php echo htmlspecialchars($folder->description ); ?> </td>
            <td> <?php echo htmlspecialchars($folder->display_name ); ?> </td>
            <td nowrap> <?php echo $fecha->format('d-m-Y') ; ?> </td>
             
            <td><a href="<?php echo $urlWP ?>" target="_blank">ir</a>  </td>
            <td><a href="*" target="_blank" class="delete_folder" data-id="<?php echo $folder->id  ; ?>">
                    
                   <i class="fa-solid fa-trash"></i></a>  </td>
        </tr>
         
        <?php endforeach; ?>
        </table>

    
</div>