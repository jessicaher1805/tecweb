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
    unset($_myvar, $_7var, $myvar, $var7, $_element1);
    ?>
    <h2>Ejercicio 2</h2>
    <?php
        $a = "ManejadorSQL";
        $b = "MySQL";
        $c = &$a;

        echo "<h4>Bloque inicial</h4><ul>";
        echo "<li>\$a = $a</li>";
        echo "<li>\$b = $b</li>";
        echo "<li>\$c = $c</li>";
        echo "</ul>";

        $a = "PHP server";
        $b = &$a;

        echo "<h4>Segundo bloque</h4><ul>";
        echo "<li>\$a = $a</li>";
        echo "<li>\$b = $b</li>";
        echo "<li>\$c = $c</li>";
        echo "</ul>";

        echo "<h4>Explicación</h4>";
        echo "<p>\$c inicialmente era referencia de \$a, por eso ambos compartían el mismo valor. "
           . "Al reasignar \$a y hacer \$b referencia de \$a, las tres variables apuntan a la misma referencia.</p>";

        unset($a, $b, $c);
    ?>

    <h2>Ejercicio 3</h2>
    <?php
        $a = "PHP5";
        echo "<h4>Después de: \$a = 'PHP5'</h4>";
        echo "echo → \$a = $a<br />var_dump → "; var_dump($a); echo "<hr>";

        $z = [];
        $z[] = &$a;
        echo "<h4>Después de: \$z[] = &\$a</h4>";
        echo "print_r → <pre>"; print_r($z); echo "</pre>";
        echo "var_dump → <pre>"; var_dump($z); echo "</pre><hr>";

        $b = "5a version de PHP";
        echo "<h4>Después de: \$b = '5a version de PHP'</h4>";
        echo "echo → \$b = $b<br />var_dump → "; var_dump($b); echo "<hr>";

        $c = (int)$b * 10;
        echo "<h4>Después de: \$c = (int)\$b * 10</h4>";
        echo "echo → \$c = $c<br />var_dump → "; var_dump($c); echo "<hr>";

        $a .= (string)$c;
        echo "<h4>Después de: \$a .= \$c</h4>";
        echo "echo → \$a = $a<br />print_r \$z → <pre>"; print_r($z); echo "</pre><hr>";

        $b = (int)$b * $c;
        echo "<h4>Después de: \$b *= \$c</h4>";
        echo "echo → \$b = $b<br />var_dump → "; var_dump($b); echo "<hr>";

        $z[0] = "MySQL";
        echo "<h4>Después de: \$z[0] = 'MySQL'</h4>";
        echo "echo → \$a = $a<br />echo → \$z[0] = ".$z[0]."<br />";
        echo "print_r → <pre>"; print_r($z); echo "</pre>var_dump → <pre>"; var_dump($z); echo "</pre>";
        
    ?>

    <h2>Ejercicio 4</h2>
    <p>Mostrar las variables del ejercicio anterior usando <code>$GLOBALS</code> y <code>global</code>:</p>
    <?php
        echo "<h4>Usando \$GLOBALS</h4>";
        echo "<ul>";
        echo "<li>\$a = ".$GLOBALS['a']." (tipo: ".gettype($GLOBALS['a']).")</li>";
        echo "<li>\$b = ".$GLOBALS['b']." (tipo: ".gettype($GLOBALS['b']).")</li>";
        echo "<li>\$c = ".$GLOBALS['c']." (tipo: ".gettype($GLOBALS['c']).")</li>";
        echo "<li>\$z[0] = ".$GLOBALS['z'][0]." (tipo: ".gettype($GLOBALS['z'][0]).")</li>";
        echo "</ul>";

        echo "<h4>Usando global en función</h4>";
        function mostrarGlobales() {
            global $a,$b,$c,$z;
            echo "<ul>";
            echo "<li>\$a = $a (tipo: ".gettype($a).")</li>";
            echo "<li>\$b = $b (tipo: ".gettype($b).")</li>";
            echo "<li>\$c = $c (tipo: ".gettype($c).")</li>";
            echo "<li>\$z[0] = ".$z[0]." (tipo: ".gettype($z[0]).")</li>";
            echo "</ul>";
        }
        mostrarGlobales();

        unset($a,$b,$c,$z);
    ?>

    <h2>Ejercicio 5</h2>
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>
    <?php
        $a = "7 personas";
        $b = (int)$a;
        $a = "9E3";
        $c = (double)$a;

        echo "<h4>Valores finales:</h4><ul>";
        echo "<li>\$a = $a (tipo: ".gettype($a).")</li>";
        echo "<li>\$b = $b (tipo: ".gettype($b).")</li>";
        echo "<li>\$c = $c (tipo: ".gettype($c).")</li>";
        echo "</ul>";

        echo "<h4>Var_dump de las variables:</h4><pre>";
        var_dump($a,$b,$c);
        echo "</pre>";

        unset($a,$b,$c);
    ?>

    <h2>Ejercicio 6</h2>
<p>Dar y comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f y muéstralas usando la función var_dump(&lt;datos&gt;).</p>

<?php
$a = "0";
$b = "TRUE";
$c = FALSE;
$d = ($a OR $b);
$e = ($a AND $c);
$f = ($a XOR $b);

echo "<h4>Valores booleanos con var_dump()</h4>";
var_dump($a, $b, $c, $d, $e, $f);

echo "<h4>Transformar booleanos \$c y \$e a un formato para echo</h4>";
echo "\$c = " . var_export($c, true) . "<br />";
echo "\$e = " . var_export($e, true) . "<br />";

unset($a,$b,$c,$d,$e,$f);
?>
</body>
</html>