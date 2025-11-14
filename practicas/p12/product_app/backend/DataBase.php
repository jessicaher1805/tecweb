<?php
namespace App;

abstract class DataBase {
    protected $conexion;
    protected $data;

   
    public function __construct($user = 'root', $pass = '12345678a', $db = 'marketzone') {
        $this->conexion = @mysqli_connect(
            'localhost',
            $user,
            $pass,
            $db
        );

        if(!$this->conexion) {
            die('¡Base de datos NO conectada!');
        }
        
        $this->conexion->set_charset("utf8");
        $this->data = array();
    }


    
    abstract public function getData();

   
    public function __destruct() {
        if($this->conexion) {
            mysqli_close($this->conexion);
        }
    }
}