<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    $data = array(
        'status'  => 'error',
        'message' => 'Error al actualizar el producto'
    );
    
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);
        
        // SE VERIFICA QUE SE HAYA RECIBIDO EL ID
        if(isset($jsonOBJ->id)) {
            // SE VERIFICA QUE NO EXISTA OTRO PRODUCTO CON EL MISMO NOMBRE (excepto el actual)
            $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND id != {$jsonOBJ->id} AND eliminado = 0";
            $result = $conexion->query($sql);
            
            if ($result->num_rows == 0) {
                $conexion->set_charset("utf8");
                $sql = "UPDATE productos SET 
                        nombre = '{$jsonOBJ->nombre}',
                        marca = '{$jsonOBJ->marca}',
                        modelo = '{$jsonOBJ->modelo}',
                        precio = {$jsonOBJ->precio},
                        detalles = '{$jsonOBJ->detalles}',
                        unidades = {$jsonOBJ->unidades},
                        imagen = '{$jsonOBJ->imagen}'
                        WHERE id = {$jsonOBJ->id} AND eliminado = 0";
                
                if($conexion->query($sql)){
                    $data['status'] = "success";
                    $data['message'] = "Producto actualizado exitosamente";
                } else {
                    $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($conexion);
                }
            } else {
                $data['message'] = "Ya existe un producto con ese nombre";
            }
            
            $result->free();
        } else {
            $data['message'] = "No se recibió el ID del producto";
        }
        
        // Cierra la conexión
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>