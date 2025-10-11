<?php
$host = "localhost";
$user = "root";
$password = "12345678a";  
$database = "marketzone";  


$conexion = new mysqli($host, $user, $password, $database);


if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


$conexion->set_charset("utf8");


$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$marca = isset($_POST['marca']) ? trim($_POST['marca']) : '';
$modelo = isset($_POST['modelo']) ? trim($_POST['modelo']) : '';
$precio = isset($_POST['precio']) ? $_POST['precio'] : 0;
$detalles = isset($_POST['detalles']) ? trim($_POST['detalles']) : '';
$unidades = isset($_POST['unidades']) ? $_POST['unidades'] : 0;
$imagen = isset($_POST['imagen']) ? trim($_POST['imagen']) : 'img/default.jpg';


$mensaje = "";
$tipo_mensaje = ""; 
$datos_producto = array();


if (empty($nombre) || empty($marca) || empty($modelo)) {
    $mensaje = "Error: Todos los campos obligatorios deben ser completados.";
    $tipo_mensaje = "error";
} else {
    
    $query_validacion = "SELECT id FROM productos 
                         WHERE nombre = ? AND marca = ? AND modelo = ?";
    
    $stmt = $conexion->prepare($query_validacion);
    $stmt->bind_param("sss", $nombre, $marca, $modelo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $mensaje = "Error: Ya existe un producto con ese nombre, marca y modelo.";
        $tipo_mensaje = "error";
    } else {
        
        $query_insert = "INSERT INTO productos 
                         (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                         VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt_insert = $conexion->prepare($query_insert);
        $stmt_insert->bind_param("sssdsis", $nombre, $marca, $modelo, $precio, 
                                  $detalles, $unidades, $imagen);
        
        if ($stmt_insert->execute()) {
            $mensaje = "¡Producto registrado exitosamente!";
            $tipo_mensaje = "exito";
            
            
            $datos_producto = array(
                'id' => $conexion->insert_id,
                'nombre' => $nombre,
                'marca' => $marca,
                'modelo' => $modelo,
                'precio' => $precio,
                'detalles' => $detalles,
                'unidades' => $unidades,
                'imagen' => $imagen
            );
        } else {
            $mensaje = "Error al insertar el producto: " . $conexion->error;
            $tipo_mensaje = "error";
        }
        
        $stmt_insert->close();
    }
    
    $stmt->close();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Registro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 600px;
            width: 100%;
        }
        
        .mensaje {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            font-size: 18px;
            text-align: center;
        }
        
        .exito {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        .datos-producto {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .datos-producto h2 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        
        .dato {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .dato:last-child {
            border-bottom: none;
        }
        
        .dato strong {
            width: 150px;
            color: #555;
        }
        
        .dato span {
            flex: 1;
            color: #333;
        }
        
        .botones {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .btn {
            flex: 1;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="mensaje <?php echo $tipo_mensaje; ?>">
            <?php echo $mensaje; ?>
        </div>
        
        <?php if ($tipo_mensaje === 'exito' && !empty($datos_producto)): ?>
            <div class="datos-producto">
                <h2>📦 Resumen del Producto Registrado</h2>
                <div class="dato">
                    <strong>ID:</strong>
                    <span><?php echo $datos_producto['id']; ?></span>
                </div>
                <div class="dato">
                    <strong>Nombre:</strong>
                    <span><?php echo htmlspecialchars($datos_producto['nombre']); ?></span>
                </div>
                <div class="dato">
                    <strong>Marca:</strong>
                    <span><?php echo htmlspecialchars($datos_producto['marca']); ?></span>
                </div>
                <div class="dato">
                    <strong>Modelo:</strong>
                    <span><?php echo htmlspecialchars($datos_producto['modelo']); ?></span>
                </div>
                <div class="dato">
                    <strong>Precio:</strong>
                    <span>$<?php echo number_format($datos_producto['precio'], 2); ?></span>
                </div>
                <div class="dato">
                    <strong>Detalles:</strong>
                    <span><?php echo htmlspecialchars($datos_producto['detalles']); ?></span>
                </div>
                <div class="dato">
                    <strong>Unidades:</strong>
                    <span><?php echo $datos_producto['unidades']; ?></span>
                </div>
                <div class="dato">
                    <strong>Imagen:</strong>
                    <span><?php echo htmlspecialchars($datos_producto['imagen']); ?></span>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="botones">
            <a href="formulario_productos.html" class="btn btn-primary">Registrar Otro Producto</a>
            <a href="get_productos_vigentes.php" class="btn btn-secondary">Ver Productos</a>
        </div>
    </div>
</body>
</html>