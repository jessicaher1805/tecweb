<?php

$link = mysqli_connect("localhost", "root", "12345678a", "marketzone");


if($link === false){
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $id = isset($_POST['id_producto']) ? intval($_POST['id_producto']) : 0;
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($link, $_POST['nombre']) : '';
    $marca = isset($_POST['marca']) ? mysqli_real_escape_string($link, $_POST['marca']) : '';
    $modelo = isset($_POST['modelo']) ? mysqli_real_escape_string($link, $_POST['modelo']) : '';
    $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
    $detalles = isset($_POST['detalles']) ? mysqli_real_escape_string($link, $_POST['detalles']) : '';
    $unidades = isset($_POST['unidades']) ? intval($_POST['unidades']) : 0;
    $imagen = isset($_POST['imagen']) ? mysqli_real_escape_string($link, $_POST['imagen']) : 'img/smartphone_default.jpg';
    
    
    if ($id > 0 && !empty($nombre) && !empty($marca) && !empty($modelo) && $precio > 99.99) {
        
        
        $sql = "UPDATE productos SET 
                nombre = '{$nombre}', 
                marca = '{$marca}', 
                modelo = '{$modelo}', 
                precio = {$precio}, 
                detalles = '{$detalles}', 
                unidades = {$unidades}, 
                imagen = '{$imagen}' 
                WHERE id = {$id}";
        
        
        if(mysqli_query($link, $sql)){
            $mensaje = "✅ Registro actualizado correctamente.";
            $tipo_alerta = "success";
        } else {
            $mensaje = "❌ ERROR: No se ejecutó la actualización. " . mysqli_error($link);
            $tipo_alerta = "danger";
        }
        
    } else {
        $mensaje = "❌ ERROR: Datos inválidos. Verifica que todos los campos obligatorios estén completos.";
        $tipo_alerta = "warning";
    }
    
} else {
    $mensaje = "❌ ERROR: Método de solicitud no válido.";
    $tipo_alerta = "danger";
}


mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Actualización</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 50px 20px;
        }
        
        .container {
            max-width: 600px;
        }
        
        .resultado-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
        }
        
        .resultado-box h2 {
            margin-bottom: 30px;
            color: #333;
        }
        
        .btn-custom {
            margin: 10px;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="resultado-box">
            <h2>📱 Actualización de Producto</h2>
            
            <div class="alert alert-<?= $tipo_alerta ?>" role="alert">
                <h4><?= $mensaje ?></h4>
            </div>
            
            <div class="mt-4">
                <a href="get_productos_xhtml_v2.php" class="btn btn-primary btn-custom">
                    📋 Ver Todos los Productos
                </a>
                
                <a href="get_productos_vigentes_v2.php" class="btn btn-success btn-custom">
                    ✅ Ver Productos Vigentes
                </a>
            </div>
        </div>
    </div>
</body>
</html>