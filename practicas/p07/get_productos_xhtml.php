<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos con Tope</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        
        body {
            padding: 20px;
        }
        img {
            max-width: 80px; 
            height: auto;
        }
    </style>
</head>
<body>
    <h3 class="mb-4">PRODUCTO </h3>

    <?php
    $tope = ''; 
    if (isset($_GET['tope'])) {
        $tope = $_GET['tope'];
    }

    if (!empty($tope) && is_numeric($tope)) { 
        
        @$link = new mysqli('localhost', 'root', '12345678a', 'marketzone');
        
        if ($link->connect_errno) {
            die('<p class="alert alert-danger">Falló la conexión: ' . $link->connect_error . '</p>');
        }

        
        $stmt = $link->prepare("SELECT id, nombre, marca, modelo, precio, detalles, unidades, imagen FROM productos WHERE unidades <= ?");
        $stmt->bind_param("i", $tope); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            ?>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Unidades</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Imagen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) : ?>
                        <tr>
                            <th scope="row"><?= $row['id'] ?></th>
                            <td><?= $row['nombre'] ?></td>
                            <td><?= $row['marca'] ?></td>
                            <td><?= $row['modelo'] ?></td>
                            <td><?= $row['precio'] ?></td>
                            <td><?= $row['unidades'] ?></td>
                            <td><?= utf8_encode($row['detalles']) ?></td>
                            <td><img src="<?= $row['imagen'] ?>" alt="Imagen de <?= $row['nombre'] ?>" /></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php
            
            $result->free();
        } else {
           
            echo '<p class="alert alert-info">No se encontraron productos con menos o igual a ' . htmlspecialchars($tope) . ' unidades.</p>';
        }

        $stmt->close();
        $link->close();
    } elseif (!empty($_GET['tope']) && !is_numeric($_GET['tope'])) {
        echo '<p class="alert alert-warning">El parámetro "tope" debe ser un valor numérico.</p>';
    } else {
        echo '<p class="alert alert-warning">Por favor, especifica un valor para el parámetro "tope" en la URL (ej. ?tope=900).</p>';
    }
    ?>
</body>
</html>