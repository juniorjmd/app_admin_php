<?php

namespace App\Views;

class Base
{
    private $session;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Inicia la sesión si no está activa
        }
        $this->session = $_SESSION;
    }

    public function renderPermisos($permisos)
    {     if (empty($permisos)) {
            return '';
        }
        echo '<ul class="list-group list-group-flush">';

        foreach ($permisos as $permiso) {
            $checked = ($permiso->checked) ? 'checked' : '';
            echo '<li class="list-group-item">';
            echo '<div class="form-check form-switch">';
            echo '<input ' . $checked . ' class="form-check-input" data-id="' . $permiso->id . '" data-padre-id="' . $permiso->padre . '" type="checkbox" id="permiso_' . $permiso->id . '" name="permisos[]" value="' . $permiso->id . '">';
            echo '<label for="permiso_' . $permiso->id . '">' . htmlspecialchars($permiso->nombre) . '</label>';
            // Renderizar los hijos recursivamente
            $this->renderPermisos($permiso->hijos);
            echo '</div></li>';
        }

        echo '</ul>';
    }

    public function renderHtml($caller, $title ,$data)
    { header('Content-Type: text/html; charset=utf-8');
          if(sizeof($data) > 0 ){
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }
        ?>
        <!DOCTYPE html>
        <html lang="es-CO">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link rel="icon" href="assets/img/tripleAicon.ico" type="image/x-icon">
            <title><?php echo $title; ?></title> 
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <?php
           
                $this->getHeader($caller);
            
            ?>
        </head>
        <body>
        <div class="container-fluid"><br>
             <?php
            if ($caller !== 'login') { 
                $this->getMenu($caller);
            }
            ?> 
            <?php require_once DOCUMENT_ROOT . '/admin/App/Views/' . $caller . '.php'; ?>
        </div>
        </body>
        </html>
        <?php
    }

    private function getVariables()
    {
        ?>
        <script>
            let login = '<?php echo URL_BASE; ?>login';
            let home = '<?php echo URL_BASE; ?>';
            let urlBack = '<?php echo URL_BASE; ?>'; 
            let idUser = '<?php echo (isset($this->session['UsuarioActivo']->id))?$this->session['UsuarioActivo']->id : '' ; ?>';
        </script>
        <?php
    }

    public function loadDefaultHeader(){
          ?>
        <link href='<?php echo URL_BASE; ?>public/assets/fontawesome/css/fontawesome.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/fontawesome/css/brands.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/fontawesome/css/solid.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/fontawesome/css/sharp-thin.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/css/bootstrap.min.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/css/sweetalert2.min.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/css/style.css' rel='stylesheet'/>
        <script src='<?php echo URL_BASE; ?>public/assets/js/jquery.js'></script>
        <script src='<?php echo URL_BASE; ?>public/assets/js/bootstrap.bundle.min.js'></script> 
        <script src='<?php echo URL_BASE; ?>public/js/default.js'></script>
            <?php
    }
    

    public function getHeader($caller)
    {
        ?>   
        <link href='<?php echo URL_BASE; ?>public/assets/fontawesome/css/fontawesome.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/fontawesome/css/brands.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/fontawesome/css/solid.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/fontawesome/css/sharp-thin.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/fontawesome/css/duotone-thin.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/fontawesome/css/sharp-duotone-thin.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/css/bootstrap-icons.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/css/bootstrap.min.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/css/sweetalert2.min.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/css/dataTables.bootstrap5.min.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/css/dataTables.bootstrap5.min.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/css/fonts.css' rel='stylesheet'/>
        <link href='<?php echo URL_BASE; ?>public/assets/css/style.css' rel='stylesheet'/> 
        <script src='<?php echo URL_BASE; ?>public/assets/js/sweetalert2.js' type='text/javascript'></script>
        <link href='<?php echo URL_BASE; ?>public/css/style.css' rel='stylesheet' > 
        <script src='<?php echo URL_BASE; ?>public/assets/js/jquery.js' type='text/javascript'></script>
        <script src='<?php echo URL_BASE; ?>public/assets/js/bootstrap.bundle.min.js' type='text/javascript'></script>
        <script src='<?php echo URL_BASE; ?>public/assets/js/popper.min.js' type='text/javascript'></script>
        <script src='<?php echo URL_BASE; ?>public/assets/js/jquery_ui.js'></script>
        <script src='<?php echo URL_BASE; ?>public/js/default.js'></script>
        <script src='<?php echo URL_BASE; ?>public/js/<?php echo $caller; ?>.js'></script>  
        <?php echo $this->getVariables(); 
    }

    public function getFooter()
    {
        ?>
        <div> @aaa - 2024</div>
        <?php
    }

    private function getMenu($caller)
    {
        ?>
        <nav class='navbar navbar-expand-lg navbar-light bg-light'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='<?php echo URL_BASE; ?>'>
                    <i class='fas fa-home'></i>
                </a>
                
                   
             <a class='navbar-brand' href='<?php echo URL_BASE ; ?>user/changeMyPass' title='cambiar contraseña'>
                 <span class='navbar-text me-3'>
                     Usuario: <?php echo $this->session['UsuarioActivo']->name?></span></a> 
                
                
                
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse'
                        data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent'
                        aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>
                
                
                
                 
                           <div class='collapse navbar-collapse' id='navbarSupportedContent'>
             <div class='d-flex align-items-center ms-auto'>
                    <ul class='nav nav-tabs'>
                            <?php if (!empty($_SESSION['UsuarioActivo']->getFolder() )){ ?> 
           <li class='nav-item '>
              <a class='nav-link $active' title='{$value['descripcion']}'  href='<?=URL_BASE."contenido" ;?>'>
                  <i class="fas fa-file-upload"></i>&nbsp;Contenidos
              </a>
                            </li><?php }
                       
                        if (!empty($_SESSION['UsuarioActivo']->getPermisos())) {
                            foreach ($_SESSION['UsuarioActivo']->getPermisos() as $value) {
                                if ($value['padre'] == 0 && $value['tipo'] == 1) {
                                    $active = ($value['direccion'] == $caller) ? 'active' : '';
                                    $image = ($value['icono'] != '') ? $value['icono'] . ' &nbsp;' : '';
                                    $nombreUp = ucfirst($value['nombre']);
                                    echo "<li class='nav-item'>
                                            <a class='nav-link $active' href='".URL_BASE . $value['direccion']."'>
                                                $image{$nombreUp}
                                            </a>
                                          </li>";
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
                               <a class='navbar-brand' style=' margin-left: 10px; ' href='<?php echo URL_BASE; ?>login'><i class='fas fa-power-off'></i></a>
                </div>
            </div>
        </nav>
        <?php
    }
}
