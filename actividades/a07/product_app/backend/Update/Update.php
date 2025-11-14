<?php
namespace App\Update;

use App\DataBase;

class Update extends DataBase {
    
    public function __construct($user = 'root', $pass = '12345678a', $db = 'marketzone') {
        parent::__construct($user, $pass, $db);
    }

    
    public function edit($object) {
        $this->data = array(
            'status'  => 'error',
            'message' => 'La actualización falló'
        );

        if(isset($object->id)) {
            $sql = "UPDATE productos SET 
                    nombre = '{$object->nombre}', 
                    marca = '{$object->marca}',
                    modelo = '{$object->modelo}', 
                    precio = {$object->precio}, 
                    detalles = '{$object->detalles}',
                    unidades = {$object->unidades}, 
                    imagen = '{$object->imagen}' 
                    WHERE id = {$object->id}";
            
            if ($this->conexion->query($sql)) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto actualizado correctamente";
            } else {
                $this->data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
            }
        }
    }

   
    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}