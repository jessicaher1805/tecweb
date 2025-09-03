<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    ?>
    <h2>Ejercicio 2</h2>
<p>
Proporcionar los valores de <code>$a</code>, <code>$b</code>, <code>$c</code> como sigue:
</p>
<?php
    $a = "ManejadorSQL";
    $b = 'MySQL';
    $c = &$a;  

    echo "<h4>Bloque inicial</h4>";
    echo "<ul>";
    echo "<li>\$a = $a</li>";
    echo "<li>\$b = $b</li>";
    echo "<li>\$c = $c</li>";
    echo "</ul>";

   
    $a = "PHP server";
    $b = &$a;   

    echo "<h4>Segundo bloque</h4>";
    echo "<ul>";
    echo "<li>\$a = $a</li>";
    echo "<li>\$b = $b</li>";
    echo "<li>\$c = $c</li>";
    echo "</ul>";

    echo "<h4>Explicación</h4>";
    echo "<p>En el primer bloque, \$c se declaró como referencia de \$a, por lo que ambos compartieron el mismo valor inicial (<em>ManejadorSQL</em>). "
       . "Cuando en el segundo bloque se reasigna \$a con el valor <em>PHP server</em>, tanto \$a como \$c reflejan ese nuevo valor, porque \$c sigue siendo referencia de \$a. "
       . "Además, al hacer \$b = &\$a, ahora también \$b apunta a la misma referencia que \$a. "
       . "Por eso, al final, las tres variables muestran el mismo valor (<em>PHP server</em>).</p>";
?>

</body>
</html>