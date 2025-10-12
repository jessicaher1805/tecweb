<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<?php
    $data = array();
    $tope = NULL;

	if(isset($_GET['tope']) && !empty($_GET['tope']))
    {
		$tope = intval($_GET['tope']);
    }

	@$link = new mysqli('localhost', 'root', '12345678a', 'marketzone');

	
	if ($link->connect_errno) 
	{
		die('Falló la conexión: '.$link->connect_error.'<br/>');
	}

	
	$query = "SELECT * FROM productos WHERE eliminado = 0";
	
	if ($tope !== NULL)
	{
		$query .= " AND unidades <= $tope";
	}

	if ( $result = $link->query($query) ) 
	{
		
		$row = $result->fetch_all(MYSQLI_ASSOC);

		
		foreach($row as $num => $registro) {
			foreach($registro as $key => $value) {
				$data[$num][$key] = utf8_encode($value);
			}
		}

		
		$result->free();
	}

	$link->close();
?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Productos Vigentes</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body>
		<div class="container mt-5">
			<h3>📦 PRODUCTOS VIGENTES</h3>
			<p><small class="text-muted">Se muestran solo los productos no eliminados (eliminado = 0)</small></p>

			<br/>
			
			<?php if( isset($row) && count($row) > 0 ) : ?>
				<table class="table table-striped">
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
						<?php foreach($row as $value) : ?>
						<tr>
							<th scope="row"><?= $value['id'] ?></th>
							<td><?= $value['nombre'] ?></td>
							<td><?= $value['marca'] ?></td>
							<td><?= $value['modelo'] ?></td>
							<td><?= $value['precio'] ?></td>
							<td><?= $value['unidades'] ?></td>
							<td><?= $value['detalles'] ?></td>
							<td><img src="<?= $value['imagen'] ?>" width="50"></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>

				 <div class="alert alert-info" role="alert">
                    No hay productos vigentes para mostrar.
                 </div>

			<?php endif; ?>
		</div>
	</body>
</html>