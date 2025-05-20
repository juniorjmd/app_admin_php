<?php

namespace Core;
use PDO;
use PDOException;

class DataBase {
    private $servidor = DB_HOST;
    private $usuario = DB_USER;
    private $password = DB_PASS;
    private $base_datos = DB_NAME_INICIO;
    private $DB_TYPE = DB_TYPE;
    protected $link;
    private $stmt;
    private $array;
    private $NumDatos;

    static $_instance;

    private function __construct($servidor = null, $usuario = null, $password = null, $base_datos = null) {
        $this->servidor = $servidor ?: (defined('N_HOST') ? N_HOST : DB_HOST);
        $this->usuario = $usuario ?: (defined('N_USUARIODB') ? N_USUARIODB : DB_USER);
        $this->password = $password ?: (defined('N_CLAVEDB') ? N_CLAVEDB : DB_PASS);
        $this->base_datos = $base_datos ?: (defined('N_DATABASE') ? N_DATABASE : DB_NAME_INICIO);

        $this->conectar();
    }

    private function __clone() {}

    public static function getInstance($servidor = null, $usuario = null, $password = null, $base_datos = null) {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self($servidor, $usuario, $password, $base_datos);
        }
        return self::$_instance;
    }

    public function getLink() {
        return $this->link;
    }

    public function getLastInsertId() {
        return $this->link->lastInsertId();
    }

    private function conectar() {
        try {
            $dsn = "{$this->DB_TYPE}:host={$this->servidor};dbname={$this->base_datos};charset=utf8mb4";
            $this->link = new PDO($dsn, $this->usuario, $this->password);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->link->exec("SET NAMES 'utf8mb4'"); 
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }
    
    public function update($tabla,$updateArr = array() , $where = null  ){
        $_wsxedc = '' ; 
        $_coma = '' ;
        $query = '' ; 
        foreach($updateArr as   $value){
           $_wsxedc .= "{$_coma} `{$value['columna']}` =  {$value['value']} ";
           $_coma = ',' ;
        } 
          $query .= "update  $tabla set   {$_wsxedc}  ";
         
          if (isset($where) && trim($where) != ''){
             $query .=  " where  {$where} ";
          }else{ 
              $array['error'] = "Peligro, la consulta que intenta ejecutar afectara toda la tabla, error en consulta.";
            return $array;
            
          }  
        try {
            $consulta = $this->link->prepare($query);
            //  echo $query;
            $consulta->execute();
            $array['datos'] = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $array['query'] = $query;
            $array['error'] = "";
            $consulta->closeCursor(); 
            return $array;
        } catch (PDOException $e) {
            $array['error'] = $e->getMessage();
            return $array;
        }
    }
 public function insert($tabla,$updateArr = array()    ){
        $_wsxedc = '' ; 
        $_wsxedcv = '' ; 
        $_coma = '' ;
        $query = '' ; 
        foreach($updateArr as   $value){
           $_wsxedc .= "{$_coma} `{$value['columna']}`   ";
           
           $_wsxedcv.= (isset($value['value']))?"{$_coma} '{$value['value']}' " : "{$_coma}  {$value['valueF']}  ";
           $_coma = ',' ;
        } 
          $query .= "insert into   $tabla ({$_wsxedc}) values ( {$_wsxedcv} ) ";
          //echo $query;
        //   $array['error'] = $query;
        //    return $array;
        try {
            $consulta = $this->link->prepare($query);
            $consulta->execute();
            $array['datos'] = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $array['query'] = $query;
            $array['error'] = "";
            $consulta->closeCursor(); 
            return $array;
        } catch (PDOException $e) {
            $array['error'] = $e->getMessage();
            return $array;
        }
    }

    public function where_union($tabla,$tablau,  $where = "", $whereu = "", $columnas = "*", $limit = "") {
        
        
        $columnas = !empty($columnas) ? $columnas : "*"; 

        $query = "SELECT $columnas FROM $tabla $where $limit UNION SELECT $columnas FROM $tablau $whereu $limit ;";

        try {
            $consulta = $this->link->prepare($query);
            $consulta->execute();
            $array['datos'] = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $array['query'] = $query;
            $array['error'] = "";
            $consulta->closeCursor();

            return $array;
        } catch (PDOException $e) {
            $array['error'] = $e->getMessage();
            return $array;
        }
    }

    public function where($tabla, $where = "", $columnas = "*", $limit = '', $order = array() , $groupby    = array()) {
        $columnas = !empty($columnas) ? $columnas : "*"; 
        $orderby = '';  
        $group_by = '';
        
         
        if (!empty($order)){ 
            $orderby = 'ORDER BY ' . implode(', ', array_map(function($ord) {
                return $ord[0] . ' ' . $ord[1];
            }, $order));
             
        }
        if (!empty($groupby)){ 
            $group_by = 'GROUP BY ' . implode(', ', array_map(function($ord) {
                return $ord  ;
            }, $groupby)); 
        }
        $query = "SELECT $columnas FROM $tabla $where  $group_by $orderby $limit ; ";  
        //  echo $query;
        try {
            $consulta = $this->link->prepare($query);
            $consulta->execute();
            $array['datos'] = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $array['query'] = $query;
            $array['error'] = "";
            $consulta->closeCursor(); 
            return $array;
        } catch (PDOException $e) {
            $array['error'] = $e->getMessage();
            return $array;
        }
    }

    public function procedimiento($procedimiento, $parametros = array()) {
        $procedimiento = trim($procedimiento);
        $query = "CALL `{$procedimiento}`(";
        $coma = "";
        foreach ($parametros as   $value) { 
            if(!is_array($value)){
               $query .= $coma . (is_numeric($value) ? $value : "'".str_replace(' ', '',$value)."'");
            }else{
                $value2 = '';
                $_coma2 = '';
                foreach ($value as  $val) {
                    $value2 .=  $_coma2 . (is_numeric($val) ? $val : "'$val'");
                      $_coma2 = ',';
                } 
                $query .=  $coma.'"'.$value2.'"'  ;
            }
            
            $coma = ",";
        }
        $query .= ")";

        try {
           // echo $query; 
            $consulta = $this->link->prepare($query);
            $consulta->execute();
            $array['datos'] = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $array['query'] = $query;
            $array['_result'] = 'ok';
            $consulta->closeCursor(); 
            return $array;
        } catch (PDOException $e) {
            $array['_result'] = $e->getMessage();
            return $array;
        }
    }

    public function truncateTable($tabla) {
        try {
            $consulta = $this->link->prepare("CALL `truncate_table`(:TABLA)");
            $consulta->bindParam(':TABLA', $tabla);
            $consulta->execute();
            $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            return $result;
        } catch (PDOException $e) {
            $array['error'] = $e->getMessage();
            return $array;
        }
    }

    public function eliminarDato($tabla, $dato, $columna) {
        try {
            $consulta = $this->link->prepare("CALL `sp_eliminar_elemento`(:USER, :TABLA, :DATO, :COLUMNA)");
            $usuario = isset($_SESSION["usuario_logeado"]) ? $_SESSION["usuario_logeado"] : '1';

            $consulta->bindParam(':USER', $usuario);
            $consulta->bindParam(':TABLA', $tabla);
            $consulta->bindParam(':DATO', $dato);
            $consulta->bindParam(':COLUMNA', $columna);
            $consulta->execute();
            $result = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            return $result;
        } catch (PDOException $e) {
            $array['error'] = $e->getMessage();
            return $array;
        }
    }
}
