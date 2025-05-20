<?php
namespace Core;  
class Config { 
    
    private static function loadEnv($filePath  )
     { // echo $filePath;
    if (!file_exists($filePath)) {
        throw new \Exception("El archivo .env no existe: $filePath");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorar comentarios
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Dividir clave y valor
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // Quitar comillas si existen
        $value = trim($value, '"\'');

        // Configurar variable de entorno si no está definida
        if (!isset($_ENV[$key]) ) {
            $_ENV[$key] = $value;
            //putenv("$key=$value");
        }
    }
}

    public static function load()
    {
        // Configuración de zona horaria
        date_default_timezone_set("America/Bogota"); 
        // Encabezados CORS
        ini_set('memory_limit', '-1');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, Content-Length, Accept-Encoding, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");

        // Manejo de la solicitud OPTIONS para la preflight request
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        // Manejo de errores según el entorno
        if (strtoupper($_SERVER['HTTP_HOST']) == 'LOCALHOST') {
            error_reporting(E_ALL);
            ini_set('display_errors', 1); 
        } else { 
            error_reporting(0);
            ini_set('display_errors', 0);
        }
        //borrar antes de pasar a produccion
          error_reporting(E_ALL);
         ini_set('display_errors', 1);
        //borrar antes de pasar a produccion
        
        // Configuración de base de datos y constantes
        self::defineConstants();
        self::configureSession();
        self::setSessionKey();
    }
    private static function defineIfNotDefined($name, $value) {
				if (!defined($name)) {
					define($name, $value);
				}
			}
    public static function defineConstants()
    {   $_ENV = [];
        self::loadEnv(__DIR__ . '/../.env' )    ; 
        self::defineIfNotDefined('DB_TYPE', $_ENV['DB_TYPE']);
        //echo $_SERVER['HTTP_HOST'];
        if (strtoupper($_SERVER['HTTP_HOST']) == 'LOCALHOST') {
            self::defineIfNotDefined('DB_HOST', $_ENV['DB_HOST_LOCAL']);
            self::defineIfNotDefined('DB_NAME_INICIO',  $_ENV['DB_NAME_INICIO_LOCAL'] );
            self::defineIfNotDefined('DB_USER', $_ENV['DB_USER_LOCAL'] );
            self::defineIfNotDefined('DB_PASS',  $_ENV['DB_PASS_LOCAL'] );
            self::defineIfNotDefined('URL_BASE', $_ENV['URL_BASE_LOCAL']  );
            self::defineIfNotDefined('URL_FRONT', $_ENV['URL_FRONT_LOCAL'] );
        } else {
            self::defineIfNotDefined('DB_HOST', $_ENV['DB_HOST_PROD'] );
            self::defineIfNotDefined('DB_NAME_INICIO', $_ENV['DB_NAME_INICIO_PROD'] );
            self::defineIfNotDefined('DB_USER',  $_ENV['DB_USER_PROD'] );
            self::defineIfNotDefined('DB_PASS', $_ENV['DB_PASS_PROD']  );
            self::defineIfNotDefined('URL_BASE', $_ENV['URL_BASE_PROD']  );
            self::defineIfNotDefined('URL_FRONT',  $_ENV['URL_FRONT_PROD'] );
        }

        self::defineIfNotDefined('CARPETA_CONTENEDORA',  $_ENV['CARPETA_CONTENEDORA'] );
        self::defineIfNotDefined('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . CARPETA_CONTENEDORA);
        self::defineIfNotDefined('RUTA_CARPETAS', URL_BASE . 'public/uploads/');
        self::defineIfNotDefined('RUTA_CARPETAS_AUX', URL_BASE . 'public/');
        self::defineIfNotDefined('SESSION_NAME_WP',  $_ENV['SESSION_NAME_WP'] );
        self::defineIfNotDefined('SESSION_WP',  $_ENV['SESSION_WP']  ); 
        self::defineIfNotDefined('NOMBRE_SESSION', sha1(URL_FRONT . date('Y-m-d')));
        self::defineIfNotDefined('REST_API_WP_CREATE', URL_FRONT .  'wp-json/wp/v2/pages'  ) ; 
        self::defineIfNotDefined('REST_API_WP_DELETE', URL_FRONT .  'wp-json/wp/v2/pages/$PAGEID$?force=true'  ) ; 
        
        self::defineIfNotDefined('KEY_APP', $_ENV['APY_KEY']);
        self::defineIfNotDefined('DESC_SUC_PRINCIPAL', sha1('JDS_SUCURSAL_PRINCIPAL'));
        self::defineIfNotDefined("LOGO_USUARIO1", URL_BASE . "/images/jds_ico.png");
        self::defineIfNotDefined("SERV_CORREO", $_ENV['SERV_CORREO'] );
        /*****DEFINICION DE VARIABLES SBS********************************************/
        
        self::defineIfNotDefined("APY_KEY_SBS", $_ENV['APY_KEY_SBS'] );        
        self::defineIfNotDefined("KEY_RESP_SBS", $_ENV['KEY_RESP_SBS'] );
        self::defineIfNotDefined("ID_APP_SBS", $_ENV['ID_APP_SBS'] );        
        self::defineIfNotDefined("SBS_HOME", $_ENV['SBS_HOME'] );   
        
    }

    private static function configureSession()
    {
        $session_path = DOCUMENT_ROOT . '/admin/Helpers/tmp/session';
     //   print_r($session_path);
        if (!is_dir($session_path)) {
            mkdir($session_path, 0777, true);
        }
        ini_set('session.save_path', $session_path);
        session_name(NOMBRE_SESSION);

        if (@session_start() == false) {
            session_destroy();
            session_start();
        }
    }
 private static function setSessionKey()
    {
        $headers = getallheaders();

        foreach ($headers as $header => $value) {
            if (strtoupper(trim($header)) === 'AUTHORIZATION') {
                $token = str_replace('Bearer ', '', trim($value));
                define('LLAVE_SESSION', $token);
                return;
            }
        }
    
        } 
} 
