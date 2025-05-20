<div class="container mt-5">
    <div class='row'>
        <div class="col-md-10">
            <h1 class="mb-4">Mantenimiento de Contenido</h1>
        </div>
        <div class="col-md-2 text-right">
            
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr> 
                <th>Carpeta</th>
                <th>Nombre Menú</th>
                <th>Ruta</th>
                <th title="codigo generado en el wordpress">Código Pág Wp</th> 
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody> 
            <?php  
            foreach ($folders as  $value) {  
                ?> 
            <tr>
                <td><?=$value->name         ;?></td> 
                <td><?=$value->display_name;?></td> 
                <td><?=$value->ruta_fisica;?></td> 
                <td><?=$value->id_wp;?></td>  
                 
                <td class="table-actions"> 
                    <a href="<?=URL_BASE;?>contenido/files/<?=$value->id ;?>" class="text-primary"><i class="fas fa-folder"></i></a>
                </td>
            </tr>  
            <?php } ?>
        </tbody>
    </table>
</div>