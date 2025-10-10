<?php
$nombre = 'Laptop HP';
$marca  = 'HP';
$modelo = 'Pavilion 15';
$precio = 15999.99;
$detalles = 'Procesador AMD Ryzen 5, 8GB RAM, 512GB SSD';
$unidades = 1;
$imagen   = 'img/laptop_hp.png';

/** SE CREA EL OBJETO DE CONEXION */
@$link = new mysqli('localhost', 'root', '12345678a', 'marketzone');	

/** comprobar la conexión */
if ($link->connect_errno) 
{
    die('Falló la conexión: '.$link->connect_error.'<br/>');
    /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
}

/** Crear una tabla que no devuelve un conjunto de resultados */
$sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}')";
if ( $link->query($sql) ) 
{
    echo 'Producto insertado con ID: '.$link->insert_id;
}
else
{
	echo 'El Producto no pudo ser insertado =(';
}

$link->close();
?>