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
    <hr>
    <h2>Ejercicio 3</h2>
    <p>Utiliza un ciclo <b>while</b> y un <b>do-while</b> para encontrar el primer número entero aleatorio que sea múltiplo de un número dado.</p>
    <p>El número se pasa por URL, ejemplo: <code>?divisor=7</code></p>

    <?php
    if (isset($_GET['divisor'])) {
        $divisor = $_GET['divisor'];

        if (is_numeric($divisor) && $divisor > 0) {
            echo encontrarMultiploWhile($divisor);
            echo encontrarMultiploDoWhile($divisor);
        } else {
            echo "<p style='color:red;'>Por favor ingresa un número válido en el parámetro divisor.</p>";
        }
    }
    ?>

    <hr>
    <h2>Ejercicio 4</h2>
    <p>Arreglo de índices 97 a 122 con valores de la letra 'a' a la 'z'.</p>

    <?php
    if (isset($_POST['ej4'])) {
        echo generarArregloLetras();
    }
    ?>

    <hr>
    <h2>Ejercicio 5</h2>
    <p>Formulario que recibe edad y sexo, y valida si cumple con la condición.</p>

    <form method="post">
    <label for="edad">Edad:</label>
    <input type="number" id="edad" name="edad" min="1" required>
    <br><br>

    <label for="sexo">Sexo:</label>
    <select id="sexo" name="sexo" required>
        <option value="">--Seleccione--</option>
        <option value="femenino">Femenino</option>
        <option value="masculino">Masculino</option>
    </select>
    <br><br>

    <input type="submit" name="ej5" value="Validar">
    </form>

    <?php
    if (isset($_POST['ej5'])) {
        $edad = $_POST['edad'];
        $sexo = $_POST['sexo'];

        echo validarEdadSexo($edad, $sexo);
    }
    ?>

    <hr>
    <h2>Ejercicio 6</h2>
    <p>Consulta información del parque vehicular por matrícula o ver todos los autos.</p>

    <form method="post">
        <label for="matricula">Matrícula:</label>
        <input 
        type="text" 
        id="matricula" 
        name="matricula"
        placeholder="Ej: ABC1234"
        value="<?php echo isset($_POST['matricula']) ? $_POST['matricula'] : ''; ?>"
        >
     <br><br>
        <input type="submit" name="buscar" value="Buscar por matrícula">
        <input type="submit" name="todos" value="Ver todos">
    </form>

    <?php
    if (isset($_POST['buscar'])) {
    $matricula = strtoupper(trim($_POST['matricula']));
    $resultado = buscarPorMatricula($matricula);

    if ($resultado) {
        echo "<h3>Resultado para matrícula: $matricula</h3>";
        echo "<pre>";
        print_r($resultado);
        echo "</pre>";
    } else {
        echo "<p style='color:red;'>No se encontró el vehículo con matrícula $matricula.</p>";
        }
    }

    if (isset($_POST['todos'])) {
    $parque = obtenerParqueVehicular();
    echo "<h3>Todos los autos registrados</h3>";
    echo "<pre>";
    print_r($parque);
    echo "</pre>";
    }
    ?>

</body>
</html>