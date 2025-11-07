<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array(
        'existe' => false,
        'message' => 'Nombre disponible'
    );

    // SE VERIFICA HABER RECIBIDO EL NOMBRE
    if(isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        
        // SE REALIZA LA QUERY PARA VERIFICAR SI EL NOMBRE YA EXISTE
        $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
        $result = $conexion->query($sql);
        
        if ($result->num_rows > 0) {
            $data['existe'] = true;
            $data['message'] = 'El nombre ya existe en la base de datos';
        }
        
        $result->free();
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>