<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    
    if (!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);
        
        // SE VERIFICA QUE EL JSON SEA VÁLIDO
        if (json_last_error() === JSON_ERROR_NONE) {
            
            // SE EXTRAEN LOS DATOS DEL PRODUCTO
            $nombre = $conexion->real_escape_string($jsonOBJ->nombre);
            $marca = $conexion->real_escape_string($jsonOBJ->marca);
            $modelo = $conexion->real_escape_string($jsonOBJ->modelo);
            $precio = floatval($jsonOBJ->precio);
            $detalles = $conexion->real_escape_string($jsonOBJ->detalles);
            $unidades = intval($jsonOBJ->unidades);
            $imagen = $conexion->real_escape_string($jsonOBJ->imagen);
            
           
            $query_validacion = "SELECT * FROM productos WHERE 
                ((nombre = '{$nombre}' AND marca = '{$marca}') OR 
                (marca = '{$marca}' AND modelo = '{$modelo}')) 
                AND eliminado = 0";
            
            $resultado = $conexion->query($query_validacion);
            
            if ($resultado->num_rows > 0) {
                
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'El producto ya existe en la base de datos'
                ));
                $resultado->free();
            } else {
                
                $query_insercion = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
                                   VALUES ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}', 0)";
                
                if ($conexion->query($query_insercion)) {
                    
                    echo json_encode(array(
                        'status' => 'success',
                        'message' => 'Producto agregado exitosamente',
                        'id' => $conexion->insert_id
                    ));
                } else {
                   
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => 'Error al insertar el producto: ' . mysqli_error($conexion)
                    ));
                }
            }
            
            $conexion->close();
            
        } else {
            
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Error en el formato del JSON recibido'
            ));
        }
    } else {
        
        echo json_encode(array(
            'status' => 'error',
            'message' => 'No se recibió información del producto'
        ));
    }
?>