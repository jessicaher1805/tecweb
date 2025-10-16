<?php
    include_once __DIR__.'/database.php';

    
    $data = array();
    
    
    if( isset($_POST['search']) ) {
        $search = $_POST['search'];
        
        // SE ESCAPA EL VALOR PARA EVITAR INYECCIÓN SQL
        $search = $conexion->real_escape_string($search);
        
        // SE REALIZA LA QUERY DE BÚSQUEDA CON LIKE EN NOMBRE, MARCA Y DETALLES
        $query = "SELECT * FROM productos WHERE nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%'";
        
        if ( $result = $conexion->query($query) ) {
            // SE OBTIENEN TODOS LOS RESULTADOS
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                // SE CODIFICAN LOS DATOS Y SE AGREGAN AL ARREGLO
                $producto = array();
                foreach($row as $key => $value) {
                    $producto[$key] = $value;
                }
                // SE AGREGA EL PRODUCTO AL ARRAY DE DATOS
                $data[] = $producto;
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    }
    // SI SE RECIBE ID (MANTENER FUNCIONALIDAD ANTERIOR)
    else if( isset($_POST['id']) ) {
        $id = $_POST['id'];
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ( $result = $conexion->query("SELECT * FROM productos WHERE id = '{$id}'") ) {
            // SE OBTIENEN LOS RESULTADOS
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if(!is_null($row)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach($row as $key => $value) {
                    $data[$key] = $value;
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    }
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>