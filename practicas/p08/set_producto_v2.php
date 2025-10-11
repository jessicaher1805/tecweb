<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "12345678a";
$basedatos = "marketzone"; 

$conexion = new mysqli($servidor, $usuario, $contraseña, $basedatos);


if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


$conexion->set_charset("utf8");


$mensaje = "";
$tipo_mensaje = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    /
    $nombre = trim($_POST["nombre"] ?? "");
    $marca = trim($_POST["marca"] ?? "");
    $modelo = trim($_POST["modelo"] ?? "");
    $precio = $_POST["precio"] ?? "";
    $detalles = trim($_POST["detalles"] ?? "");
    $unidades = $_POST["unidades"] ?? "";
    $imagen = trim($_POST["imagen"] ?? "");
    
    
    if (empty($nombre) || empty($marca) || empty($modelo) || empty($precio) || empty($unidades)) {
        $mensaje = "Error: Todos los campos obligatorios deben ser completados.";
        $tipo_mensaje = "error";
    } else if (!is_numeric($precio) || $precio < 0) {
        $mensaje = "Error: El precio debe ser un número válido y mayor o igual a 0.";
        $tipo_mensaje = "error";
    } else if (!is_numeric($unidades) || $unidades < 0) {
        $mensaje = "Error: Las unidades deben ser un número entero válido.";
        $tipo_mensaje = "error";
    } else {
        
        $query_verificar = "SELECT id FROM productos WHERE nombre = ? AND modelo = ? AND marca = ? AND eliminado = 0";
        $stmt = $conexion->prepare($query_verificar);
        
        if ($stmt === false) {
            $mensaje = "Error en la preparación de la consulta: " . $conexion->error;
            $tipo_mensaje = "error";
        } else {
            $stmt->bind_param("sss", $nombre, $modelo, $marca);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows > 0) {
                $mensaje = "Error: Un producto con el mismo nombre, modelo y marca ya existe en la base de datos.";
                $tipo_mensaje = "error";
            } else {
                // Insertar el nuevo producto
                // QUERY ANTIGUA - SIN COLUMN NAMES (COMENTADA - EJERCICIO 4)
                // $query_insertar = "INSERT INTO productos VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, 0)";
                // $stmt_insert->bind_param("sssdsds", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);
                
                $query_insertar = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = $conexion->prepare($query_insertar);
                
                if ($stmt_insert === false) {
                    $mensaje = "Error en la preparación de la inserción: " . $conexion->error;
                    $tipo_mensaje = "error";
                } else {
                    
                    if ($stmt_insert->execute()) {
                        $id_insertado = $conexion->insert_id;
                        $mensaje = "¡Producto insertado correctamente!";
                        $tipo_mensaje = "exito";
                    } else {
                        $mensaje = "Error al insertar el producto: " . $stmt_insert->error;
                        $tipo_mensaje = "error";
                    }
                    
                    $stmt_insert->close();
                }
            }
            
            $stmt->close();
        }
    }
    
    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Registro de Producto</title>
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
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            background: white;
        }
        
        .exito {
            background-color: #d4edda;
            border: 2px solid #c3e6cb;
            color: #155724;
        }
        
        .error {
            background-color: #f8d7da;
            border: 2px solid #f5c6cb;
            color: #721c24;
        }
        
        h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .resumen {
            margin-top: 30px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
        }
        
        .resumen h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .resumen p {
            margin: 10px 0;
            line-height: 1.6;
        }
        
        .resumen strong {
            color: #333;
            min-width: 150px;
            display: inline-block;
        }
        
        .botones {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }
        
        a {
            flex: 1;
            padding: 14px;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        a:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .error a {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
    </style>
</head>
<body>
    <div class="container <?php echo $tipo_mensaje; ?>">
        <h1><?php echo $tipo_mensaje === "exito" ? "✓ Éxito" : "✗ Error"; ?></h1>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
        
        <?php if ($tipo_mensaje === "exito"): ?>
            <div class="resumen">
                <h2>Resumen del Producto Registrado:</h2>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
                <p><strong>Marca:</strong> <?php echo htmlspecialchars($marca); ?></p>
                <p><strong>Modelo:</strong> <?php echo htmlspecialchars($modelo); ?></p>
                <p><strong>Precio:</strong> $<?php echo number_format($precio, 2); ?></p>
                <p><strong>Unidades:</strong> <?php echo htmlspecialchars($unidades); ?></p>
                <p><strong>Detalles:</strong> <?php echo htmlspecialchars($detalles); ?></p>
                <p><strong>Imagen:</strong> <?php echo htmlspecialchars($imagen); ?></p>
            </div>
        <?php endif; ?>
        
        <div class="botones">
            <a href="formulario_productos.html">Registrar Otro Producto</a>
        </div>
    </div>
</body>
</html>