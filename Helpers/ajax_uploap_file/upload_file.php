<?php
if (!empty($_FILES['file']['name'])) {
    $file = $_FILES['file'];
    $upload_dir = 'uploads/';
    $upload_path = $upload_dir . basename($file['name']);

    // Verificar si el directorio de uploads existe, si no, crearlo
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Verificar el tipo de archivo permitido
    $allowed_types = array(
        'application/pdf', 
        'application/msword', 
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
        'text/plain', 
        'application/vnd.ms-excel', 
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
        'application/vnd.ms-powerpoint', 
        'application/vnd.openxmlformats-officedocument.presentationml.presentation'
    );
    
    if (in_array($file['type'], $allowed_types)) {
        // Mover el archivo subido al directorio de uploads
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            echo json_encode(['status' => 'success', 'message' => 'Archivo subido con éxito.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al mover el archivo subido.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tipo de archivo no permitido.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se ha subido ningún archivo.']);
}
?>
