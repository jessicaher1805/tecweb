<?php
$esEdicion = false;
$datosProducto = array(
    'id' => '',
    'nombre' => '',
    'marca' => '',
    'modelo' => '',
    'precio' => '',
    'detalles' => '',
    'unidades' => '',
    'imagen' => ''
);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $esEdicion = true;
    $id = intval($_GET['id']);
    
    @$link = new mysqli('localhost', 'root', '12345678a', 'marketzone');
    
    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error);
    }
    
    $stmt = $link->prepare("SELECT id, nombre, marca, modelo, precio, detalles, unidades, imagen FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $datosProducto = $result->fetch_assoc();
    } else {
        $esEdicion = false;
    }
    
    $stmt->close();
    $link->close();
}

$marcas = array('Apple', 'Samsung', 'Xiaomi', 'Motorola', 'OnePlus', 'Nokia', 'Huawei', 'Google Pixel', 'LG', 'Sony');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $esEdicion ? 'Editar Producto' : 'Registro de Productos'; ?></title>
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
            max-width: 500px;
            width: 100%;
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .required {
            color: #e74c3c;
        }
        
        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        button:active {
            transform: translateY(0);
        }
        
        .info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2196f3;
        }
        
        .info p {
            color: #1976d2;
            font-size: 13px;
            margin: 5px 0;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $esEdicion ? '📱 Editar Smartphone' : '📱 Registro de Smartphones'; ?></h1>
        
        <div class="info">
            <p><strong>Nota:</strong> Los campos marcados con * son obligatorios</p>
            <?php if (!$esEdicion): ?>
                <p>El ID se genera automáticamente</p>
            <?php else: ?>
                <p>Editando producto ID: <?php echo $datosProducto['id']; ?></p>
            <?php endif; ?>
        </div>
        
        <form action="<?php echo $esEdicion ? 'update_producto.php' : 'set_producto_v2.php'; ?>" method="POST" id="formProducto">
            
            <?php if ($esEdicion): ?>
                <input type="hidden" name="id" value="<?php echo $datosProducto['id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="nombre">Nombre del Smartphone <span class="required">*</span></label>
                <input type="text" id="nombre" name="nombre" required 
                       placeholder="Ej: iPhone 15 Pro Max" maxlength="100"
                       value="<?php echo htmlspecialchars($datosProducto['nombre']); ?>">
                <div class="error-message" id="errorNombre"></div>
            </div>
            
            <div class="form-group">
                <label for="marca">Marca <span class="required">*</span></label>
                <select id="marca" name="marca" required>
                    <option value="">-- Selecciona una marca --</option>
                    <?php foreach ($marcas as $m): ?>
                        <option value="<?php echo $m; ?>" 
                                <?php echo ($datosProducto['marca'] === $m) ? 'selected' : ''; ?>>
                            <?php echo $m; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="error-message" id="errorMarca"></div>
            </div>
            
            <div class="form-group">
                <label for="modelo">Modelo <span class="required">*</span></label>
                <input type="text" id="modelo" name="modelo" required 
                       placeholder="Ej: A3111" maxlength="25"
                       value="<?php echo htmlspecialchars($datosProducto['modelo']); ?>">
                <div class="error-message" id="errorModelo"></div>
            </div>
            
            <div class="form-group">
                <label for="precio">Precio <span class="required">*</span></label>
                <input type="number" id="precio" name="precio" required 
                       step="0.01" min="0" placeholder="Ej: 15999.99"
                       value="<?php echo $datosProducto['precio']; ?>">
                <div class="error-message" id="errorPrecio"></div>
            </div>
            
            <div class="form-group">
                <label for="detalles">Detalles</label>
                <textarea id="detalles" name="detalles" 
                          placeholder="Describe las características del smartphone..." maxlength="250"><?php echo htmlspecialchars($datosProducto['detalles']); ?></textarea>
                <div class="error-message" id="errorDetalles"></div>
            </div>
            
            <div class="form-group">
                <label for="unidades">Unidades Disponibles <span class="required">*</span></label>
                <input type="number" id="unidades" name="unidades" required 
                       min="0" placeholder="Ej: 10"
                       value="<?php echo $datosProducto['unidades'] === '' ? '0' : $datosProducto['unidades']; ?>">
                <div class="error-message" id="errorUnidades"></div>
            </div>
            
            <div class="form-group">
                <label for="imagen">URL de la Imagen</label>
                <input type="text" id="imagen" name="imagen" 
                       placeholder="Ej: img/smartphone.jpg" maxlength="100"
                       value="<?php echo htmlspecialchars($datosProducto['imagen']); ?>">
                <div class="error-message" id="errorImagen"></div>
            </div>
            
            <button type="submit"><?php echo $esEdicion ? '✅ Actualizar Producto' : '✅ Registrar Producto'; ?></button>
        </form>
    </div>
    
    <script>
        document.getElementById('formProducto').addEventListener('submit', function(e) {
            e.preventDefault();
            
            
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
            
            const nombre = document.getElementById('nombre').value.trim();
            const marca = document.getElementById('marca').value.trim();
            const modelo = document.getElementById('modelo').value.trim();
            const precio = parseFloat(document.getElementById('precio').value);
            const detalles = document.getElementById('detalles').value.trim();
            const unidades = parseInt(document.getElementById('unidades').value);
            const imagen = document.getElementById('imagen').value.trim();
            
            let esValido = true;
            
            
            if (nombre === '') {
                mostrarError('errorNombre', 'El nombre es obligatorio');
                esValido = false;
            } else if (nombre.length > 100) {
                mostrarError('errorNombre', 'El nombre no puede exceder 100 caracteres');
                esValido = false;
            }
            
          
            if (marca === '') {
                mostrarError('errorMarca', 'Debes seleccionar una marca');
                esValido = false;
            }
            
            
            if (modelo === '') {
                mostrarError('errorModelo', 'El modelo es obligatorio');
                esValido = false;
            } else if (!/^[a-zA-Z0-9]+$/.test(modelo)) {
                mostrarError('errorModelo', 'El modelo debe ser alfanumérico (solo letras y números)');
                esValido = false;
            } else if (modelo.length > 25) {
                mostrarError('errorModelo', 'El modelo no puede exceder 25 caracteres');
                esValido = false;
            }
            
            
            if (isNaN(precio) || precio <= 99.99) {
                mostrarError('errorPrecio', 'El precio debe ser mayor a 99.99');
                esValido = false;
            }
            
            
            if (detalles.length > 250) {
                mostrarError('errorDetalles', 'Los detalles no pueden exceder 250 caracteres');
                esValido = false;
            }
            
            
            if (isNaN(unidades) || unidades < 0) {
                mostrarError('errorUnidades', 'Las unidades deben ser mayor o igual a 0');
                esValido = false;
            }
            
            let imagenFinal = imagen || 'img/imagen.png';
            if (!imagen) {
                document.getElementById('imagen').value = imagenFinal;
            }
            
            if (esValido) {
                this.submit();
            }
        });
        
        function mostrarError(idElemento, mensaje) {
            const elemento = document.getElementById(idElemento);
            elemento.textContent = mensaje;
            elemento.style.display = 'block';
        }
    </script>
</body>
</html>