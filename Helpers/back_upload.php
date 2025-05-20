<?php
// Ruta donde se subirán los archivos
$directorio_subida = "/ruta/a/tu/carpeta/";

// Extensiones de archivos permitidas
$extensiones_permitidas = ['pdf', 'doc', 'docx', 'txt', 'xls', 'xlsx', 'ppt', 'pptx'];

// Comprobamos si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificamos si se ha subido un archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $archivo_temporal = $_FILES['archivo']['tmp_name'];
        $nombre_archivo = basename($_FILES['archivo']['name']);
        $extension_archivo = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));

        // Verificamos si la extensión del archivo está permitida
        if (in_array($extension_archivo, $extensiones_permitidas)) {
            // Generamos la ruta completa donde se guardará el archivo
            $ruta_completa = $directorio_subida . $nombre_archivo;

            // Movemos el archivo desde la ubicación temporal a la ubicación deseada
            if (move_uploaded_file($archivo_temporal, $ruta_completa)) {
                echo "El archivo se ha subido correctamente.";
            } else {
                echo "Hubo un error al subir el archivo. Por favor, inténtalo de nuevo.";
            }
        } else {
            echo "Tipo de archivo no permitido. Solo se permiten archivos PDF, Word, TXT, Excel y PowerPoint.";
        }
    } else {
        echo "No se ha subido ningún archivo o hubo un error en la subida.";
    }
}
?>
