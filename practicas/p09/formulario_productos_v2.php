<?php
session_start();

$marcas = array('Apple', 'Samsung', 'Xiaomi', 'Motorola', 'OnePlus', 'Nokia', 'Huawei', 'Google Pixel', 'LG', 'Sony');


$nombre = '';
$marca = '';
$modelo = '';
$precio = '';
$detalles = '';
$unidades = '0';
$imagen = '';
$id_producto = '';


if(isset($_POST['id_producto']) && !empty($_POST['id_producto']) && isset($_POST['accion']) && $_POST['accion'] === 'editar') {
    $id = intval($_POST['id_producto']);
    
    $link = new mysqli('localhost', 'root', '12345678a', 'marketzone');
    
    if (!$link->connect_errno) {
        $stmt = $link->prepare("SELECT * FROM productos WHERE id = ? AND eliminado = 0");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($producto = $result->fetch_assoc()) {
            $id_producto = $producto['id'];
            $nombre = utf8_encode($producto['nombre']);
            $marca = utf8_encode($producto['marca']);
            $modelo = utf8_encode($producto['modelo']);
            $precio = $producto['precio'];
            $detalles = utf8_encode($producto['detalles']);
            $unidades = $producto['unidades'];
            $imagen = $producto['imagen'];
        }
        
        $stmt->close();
        $link->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Productos</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 600px;
            margin: 0 auto;
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        legend {
            color: #667eea;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        
        fieldset {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        ul {
            list-style-type: none;
        }
        
        li {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }
        
        label {
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }
        
        .required {
            color: #e74c3c;
        }
        
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="number"]:focus,
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
        
        p {
            margin-top: 20px;
        }
        
        input[type="submit"] {
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
        }
        
        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        input[type="submit"]:active {
            transform: translateY(0);
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
        <h1>📱 Productos</h1>
        
        <form id="miFormulario" onsubmit="return validarFormulario()" method="post" action="set_producto_v2.php">
           
            <?php if(!empty($id_producto)): ?>
                <input type="hidden" name="id_producto" value="<?= $id_producto ?>">
            <?php endif; ?>
            
            <fieldset>
                <legend><?= !empty($id_producto) ? 'Actualiza los datos del smartphone:' : 'Registra un nuevo smartphone:' ?></legend>
                
                <ul>
                    <li>
                        <label>Nombre <span class="required">*</span></label>
                        <input type="text" name="nombre" 
                               value="<?= htmlspecialchars($nombre) ?>"
                               placeholder="Ej: iPhone 15 Pro Max" 
                               maxlength="100">
                        <div class="error-message" id="errorNombre"></div>
                    </li>
                    
                    <li>
                        <label>Marca <span class="required">*</span></label>
                        <select name="marca">
                            <option value="">-- Selecciona una marca --</option>
                            <?php foreach ($marcas as $m): ?>
                                <option value="<?= $m ?>" <?= ($marca === $m) ? 'selected' : '' ?>>
                                    <?= $m ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="error-message" id="errorMarca"></div>
                    </li>
                    
                    <li>
                        <label>Modelo <span class="required">*</span></label>
                        <input type="text" name="modelo" 
                               value="<?= htmlspecialchars($modelo) ?>"
                               placeholder="Ej: A3111" 
                               maxlength="25">
                        <div class="error-message" id="errorModelo"></div>
                    </li>
                    
                    <li>
                        <label>Precio <span class="required">*</span></label>
                        <input type="number" name="precio" 
                               value="<?= htmlspecialchars($precio) ?>"
                               placeholder="Ej: 15999.99"
                               step="0.01" 
                               min="0">
                        <div class="error-message" id="errorPrecio"></div>
                    </li>
                    
                    <li>
                        <label>Detalles</label>
                        <textarea name="detalles" 
                                  placeholder="Describe las características del smartphone..."
                                  maxlength="250"><?= htmlspecialchars($detalles) ?></textarea>
                        <div class="error-message" id="errorDetalles"></div>
                    </li>
                    
                    <li>
                        <label>Unidades Disponibles <span class="required">*</span></label>
                        <input type="number" name="unidades" 
                               value="<?= htmlspecialchars($unidades) ?>"
                               placeholder="Ej: 10"
                               min="0">
                        <div class="error-message" id="errorUnidades"></div>
                    </li>
                    
                    <li>
                        <label>URL de la Imagen</label>
                        <input type="text" name="imagen" 
                               value="<?= htmlspecialchars($imagen) ?>"
                               placeholder="Ej: img/smartphone.jpg"
                               maxlength="100">
                        <div class="error-message" id="errorImagen"></div>
                    </li>
                </ul>
            </fieldset>
            
            <p>
                <input type="submit" value="<?= !empty($id_producto) ? '✅ ACTUALIZAR' : '✅ REGISTRAR' ?>">
            </p>
        </form>
    </div>
    
    <script>
        function validarFormulario() {
           
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
            
            const nombre = document.querySelector('input[name="nombre"]').value.trim();
            const marca = document.querySelector('select[name="marca"]').value.trim();
            const modelo = document.querySelector('input[name="modelo"]').value.trim();
            const precio = parseFloat(document.querySelector('input[name="precio"]').value);
            const detalles = document.querySelector('textarea[name="detalles"]').value.trim();
            const unidades = parseInt(document.querySelector('input[name="unidades"]').value);
            const imagen = document.querySelector('input[name="imagen"]').value.trim();
            
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
            
            
            if (imagen === '') {
                document.querySelector('input[name="imagen"]').value = 'img/smartphone_default.jpg';
            }
            
            return esValido;
        }
        
        function mostrarError(idElemento, mensaje) {
            const elemento = document.getElementById(idElemento);
            elemento.textContent = mensaje;
            elemento.style.display = 'block';
        }
    </script>
</body>
</html>