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
                .btn-sm {
                    margin: 5px 0;
                }
            </style>
        </head>
        <body>
            <h3 class="mb-4">📱 PRODUCTOS CON TOPE (≤ <?php echo htmlspecialchars($tope); ?> unidades)</h3>
            
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
                        <th scope="col">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_array(MYSQLI_ASSOC)) : ?>
                        <tr>
                            <th scope="row"><?= $row['id'] ?></th>
                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                            <td><?= htmlspecialchars($row['marca']) ?></td>
                            <td><?= htmlspecialchars($row['modelo']) ?></td>
                            <td><?= number_format($row['precio'], 2) ?></td>
                            <td><?= $row['unidades'] ?></td>
                            <td><?= utf8_encode($row['detalles']) ?></td>
                            <td><img src="<?= htmlspecialchars($row['imagen']) ?>" alt="Imagen de <?= htmlspecialchars($row['nombre']) ?>" /></td>
                            <td>
                                <a href="formulario_productos_v2.php?nombre=<?php echo urlencode($row['nombre']); ?>&marca=<?php echo urlencode($row['marca']); ?>&modelo=<?php echo urlencode($row['modelo']); ?>&precio=<?php echo urlencode($row['precio']); ?>&detalles=<?php echo urlencode($row['detalles']); ?>&unidades=<?php echo urlencode($row['unidades']); ?>&imagen=<?php echo urlencode($row['imagen']); ?>" class="btn btn-sm btn-warning">✏️ Editar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </body>
        </html>
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