<?php
function listar_archivos($directorio) {
    if (is_dir($directorio)) {
        if ($gestor = opendir($directorio)) {
            echo "<ul>";
            while (($archivo = readdir($gestor)) !== false) {
                if ($archivo != "." && $archivo != "..") {
                    $ruta_completa = $directorio . "/" . $archivo;
                    if (is_dir($ruta_completa)) {
                        // Llamada recursiva para subdirectorios
                        echo "<li><strong>$archivo/</strong>";
                        listar_archivos($ruta_completa);
                        echo "</li>";
                    } else {
                        echo "<li>";
                        echo "<a href=\"$ruta_completa\" target=\"_blank\">$archivo</a>";
                        echo " <a href=\"$ruta_completa\" download><img src=\"/ruta/a/icono/descarga.png\" alt=\"Descargar\" style=\"width:16px; height:16px;\"></a>";
                        echo "</li>";
                    }
                }
            }
            echo "</ul>";
            closedir($gestor);
        } else {
            echo "No se pudo abrir el directorio.";
        }
    } else {
        echo "No es un directorio válido.";
    }
}
  
