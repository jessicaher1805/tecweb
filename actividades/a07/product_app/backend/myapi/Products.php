<?php
namespace TECWEB\MYAPI;

use TECWEB\MYAPI\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $data = NULL;
    public function __construct($user= 'root', $pass='12345678a', $db) {
        $this->data = array();
        parent::__construct($user, $pass, $db);
    }


    public function list(){
        $this->data = array();
        if ($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)) {
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data [$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: ' .mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }

    public function getData() {
        return json_decode($this->data, JSON_PRETTY_PRINT);
    }

}
?>