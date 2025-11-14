<?php
namespace App\Create;

use App\DataBase;

class Create extends DataBase {
    
    public function __construct($user = 'root', $pass = '12345678a', $db = 'marketzone') {
        parent::__construct($user, $pass, $db);
    }


    public function add($object) {
        $this->data = array(
            'status'  => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );

        
        $sql = "SELECT * FROM productos WHERE nombre = '{$object->nombre}' AND eliminado = 0";
        $result = $this->conexion->query($sql);
        
        if ($result->num_rows == 0) {
           
            $sql = "INSERT INTO productos VALUES (null, '{$object->nombre}', '{$object->marca}', 
                    '{$object->modelo}', {$object->precio}, '{$object->detalles}', 
                    {$object->unidades}, '{$object->imagen}', 0)";
            
            if($this->conexion->query($sql)){
                $this->data['status'] = "success";
                $this->data['message'] = "Producto agregado correctamente";
            } else {
                $this->data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
            }
        }

        $result->free();
    }

    
    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}