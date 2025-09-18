<?php
function esMultiploDe5y7($num) {
    if ($num % 5 == 0 && $num % 7 == 0){
        return "El numero $num SI es multiplo de 5 y 7.";
    } else {
        return "El número $num NO es múltiplo de 5 y 7.";
    }
}

function generarSecuenciaImparParImpar() {
    $matriz = [];     
    $encontrado = false;
    $iteraciones = 0;

    while (!$encontrado) {
        $fila = [];
        for ($i = 0; $i < 3; $i++) {
            $fila[] = rand(100, 999); 
        }
        $matriz[] = $fila;
        $iteraciones++;

        
        if ($fila[0] % 2 != 0 && $fila[1] % 2 == 0 && $fila[2] % 2 != 0) {
            $encontrado = true;
        }
    }

  
    $resultado = "<h3>Resultados Ejercicio 2</h3>";
    $resultado .= "<table border='1' cellpadding='5' cellspacing='0'>";
    foreach ($matriz as $fila) {
        $resultado .= "<tr>";
        foreach ($fila as $num) {
            $resultado .= "<td>$num</td>";
        }
        $resultado .= "</tr>";
    }
    $resultado .= "</table>";

    $totalNumeros = $iteraciones * 3;
    $resultado .= "<p><b>$totalNumeros números obtenidos en $iteraciones iteraciones</b></p>";

    return $resultado;
}

function encontrarMultiploWhile($divisor) {
    $num = null;

    while (true) {
        $num = rand(1, 1000); 
        if ($num % $divisor == 0) {
            break;
        }
    }

    return "<p>Con <b>while</b>: El primer múltiplo de $divisor encontrado fue <b>$num</b>.</p>";
}


function encontrarMultiploDoWhile($divisor) {
    
    do {
        $num = rand(1, 1000); 
    } while ($num % $divisor != 0);

    return "<p>Con <b>do-while</b>: El primer múltiplo de $divisor encontrado fue <b>$num</b>.</p>";

}
?>