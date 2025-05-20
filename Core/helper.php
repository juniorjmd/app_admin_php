<?php
 
namespace Core; 
class helper {
    
    static public function responseErrorIfTrue($eval,$status ,$msg ){
        if($eval){
            http_response_code($status);
            echo json_encode(['status' => 'error', 'message' => $msg]);
            die();
        }
    }
    static public function responseSuccess($msg , $datos = []  ){ 
            http_response_code(200);
            $respuesta = [
                    'status' => 'ok',
                    'message' => $msg
                ]; 
            $respuesta = array_merge($respuesta, $datos); 
            echo json_encode($respuesta);
            die();
       
    }
    
   
    static public function getRequestData(): array { 
    $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET'; 
    if (stripos($contentType, 'application/json') !== false) {
        // JSON (raw body)    
        $raw = file_get_contents("php://input");
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }

    if (stripos($contentType, 'application/x-www-form-urlencoded') !== false && $method === 'POST') {
        // Datos de formulario clásico 
        return $_POST;
    }

     if (stripos($contentType, 'application/x-www-form-urlencoded') !== false && in_array($method, ['PUT', 'DELETE', 'PATCH'])) {
        $raw = file_get_contents("php://input");
        parse_str($raw, $data); // Parsea los datos url-encoded del cuerpo
        return is_array($data) ? $data : [];
    }
    // Otros tipos o vacío
    return [];
}


    static public function validateAndAssignPostParameters($requiredParams) {
    $params = [];
    $_input_data = helper::getRequestData();   
    foreach ($requiredParams as $param) {
        
       //helper::log($param .'=>' . ( is_array( $_POST[$param]))? implode(',', $_POST[$param]): '' ) ;
        if (!isset($_input_data[$param]) ) {
            return null;
        }
          if (!is_array($_input_data[$param]) && empty($_input_data[$param])) {
            return null;
        }
        
        if (is_array($_input_data[$param])){
          //  helper::log($param .'=>' .  implode(',', $_POST[$param])  ) ;
            foreach($_input_data[$param] as $key => $valor){
              $params[$param][$key] = htmlspecialchars(trim($valor));
            }
        }else{
           // helper::log($param .'=>' .   $_input_data[$param] ) ;
        $params[$param] = htmlspecialchars(trim($_input_data[$param]));}
    } 
    return $params;
}

static public function quitarTildes($texto) {
    $buscar = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ'];
    $reemplazar = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N'];
    return str_replace($buscar, $reemplazar, $texto);
}

static public function parseJsonInput() {
    $input = file_get_contents('php://input'); // Obtén los datos crudos 
    $data = json_decode($input, true); // Decodifica el JSON 
    if (json_last_error() !== JSON_ERROR_NONE) {
        helper::log("JSON Decode Error: " . json_last_error_msg()) ;  
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => 'Datos inválidos o malformados']);
        die();
    } 
    $_POST = $data; // Sobrescribe $_POST con los datos decodificados 
}
static public function log($errorMessage) {
    $logFile = "intranet.dev.log";
    $timestamp = date("Y-m-d H:i:s"); // Fecha y hora actual
    $trace = debug_backtrace(); // Obtener información de la pila de llamadas
    $caller = $trace[0]; // La primera llamada al método actual

    // Construir el mensaje con la fecha, hora, archivo y línea
    $formattedMessage = sprintf(
        "[%s] %s in %s on line %d\n",
        $timestamp,
        $errorMessage,
        $caller['file'] ?? 'unknown file',
        $caller['line'] ?? 0
    );

    error_log($formattedMessage, 3, $logFile); // Escribir en el archivo sin sobrescribir
}
}
