<?php
namespace App\Delete;

use App\DataBase;

class Delete extends DataBase {
    
    public function __construct($user = 'root', $pass = '12345678a', $db = 'marketzone') {
        parent::__construct($user, $pass, $db);
    }

   
    public function delete($id) {
        $this->data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );

        if(isset($id)) {
            $sql = "UPDATE productos SET eliminado = 1 WHERE id = {$id}";
            
            if ($this->conexion->query($sql)) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto eliminado correctamente";
            } else {
                $this->data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
            }
        }
    }

    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}