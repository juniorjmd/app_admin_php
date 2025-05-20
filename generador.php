<?php

// Obtenemos el nombre de la entidad desde la línea de comandos
if ($argc < 2) {
    echo "Uso: php generate.php <NombreEntidad>\n";
    exit(1);
}

$nombreEntidad = ucfirst($argv[1]);
$nombreSubView = strtolower($argv[1]); // Capitalizamos la primera letra
$carpetas = [
    'model' => "App/Models",
    'repository' => "App/Repositories",
    'controller' => "App/Controllers",
    'view' => "App/Views", 
    'subview' => "App/Views/{$nombreSubView}", 
];

// Plantillas para los archivos
$plantillas = [
    'model' => "<?php\n\nclass {$nombreEntidad}Model {\n    // Agrega tus atributos y métodos aquí\n}\n",
    'repository' => "<?php\n\nclass {$nombreEntidad}Repository {\n    // Agrega métodos para interactuar con la base de datos\n}\n",
    'controller' => "<?php\n\nclass {$nombreEntidad}Controller {\n    // Agrega métodos para manejar solicitudes HTTP\n}\n",
    'view' => "<?php\n\n require_once '../app/views/$nombreSubView/index.php';",
    'subview'=>"<!-- Vista para {$nombreEntidad} -->\n<h1>Página de {$nombreEntidad}</h1>\n",
];

// Crear carpetas si no existen y generar archivos
foreach ($carpetas as $tipo => $carpeta) {
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
        echo "Carpeta creada: {$carpeta}\n";
    }
    
    $archivo = "{$carpeta}/{$nombreEntidad}{ucfirst($tipo)}.php";
    if ($carpeta == 'subview') $archivo = "{$carpeta}/index.php";
    if (!file_exists($archivo)) {
        file_put_contents($archivo, $plantillas[$tipo]);
        echo "Archivo creado: {$archivo}\n";
    } else {
        echo "El archivo {$archivo} ya existe. No se sobrescribirá.\n";
    }
}

echo "Archivos generados correctamente para la entidad: {$nombreEntidad}\n";
