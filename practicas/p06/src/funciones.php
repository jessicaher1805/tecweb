<?php
function esMultiploDe5y7($num) {
    if ($num % 5 == 0 && $num % 7 == 0){
        return "El numero $num SI es multiplo de 5 y 7.";
    } else {
        return "El número $num NO es múltiplo de 5 y 7.";
    }
}
?>