<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 6</title>
</head>
<body>
    <?php
        require_once "src/funciones.php";
    ?>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
     <p>Ejemplo: <code>http://localhost/tecweb/practicas/p06/index.php?numero=35</code></p>
    <?php
        if (isset($_GET['numero'])) {
            $num = $_GET['numero'];
            echo "<h3>R= " . esMultiploDe5y7($num) . "</h3>";
        }
    ?>
    <h2>Ejercicio 2</h2>
    <p>Generar números aleatorios hasta obtener la secuencia: <b>impar, par, impar</b></p>

    <?php
    if (isset($_POST['ej2'])) {
        echo generarSecuenciaImparParImpar();
    }
    ?>
</body>
</html>