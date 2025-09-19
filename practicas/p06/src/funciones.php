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

function generarArregloLetras() {
    $arreglo = [];

    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i);
    }

    $resultado = "<h3>Arreglo de letras (97 a 122)</h3>";
    $resultado .= "<table border='1' cellpadding='5' cellspacing='0'>";
    $resultado .= "<tr><th>Índice</th><th>Valor</th></tr>";

    foreach ($arreglo as $key => $value) {
        $resultado .= "<tr><td>$key</td><td>$value</td></tr>";
    }

    $resultado .= "</table>";

    return $resultado;
}

function validarEdadSexo($edad, $sexo) {
    if ($sexo === "femenino" && $edad >= 18 && $edad <= 35) {
        return "<h3>Bienvenida, usted está en el rango de edad permitido.</h3>";
    } else {
        return "<h3>Lo sentimos, no cumple con los requisitos.</h3>";
    }
}

function obtenerParqueVehicular() {
    return [
        "ABC1234" => [
            "Auto" => [
                "marca" => "HONDA",
                "modelo" => 2020,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Alfonzo Esparza",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "C.U., Jardines de San Manuel"
            ]
        ],
        "XYZ5678" => [
            "Auto" => [
                "marca" => "MAZDA",
                "modelo" => 2019,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Ma. del Consuelo Molina",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "97 oriente"
            ]
        ],
        "LMN4321" => [
            "Auto" => [
                "marca" => "TOYOTA",
                "modelo" => 2018,
                "tipo" => "hachback"
            ],
            "Propietario" => [
                "nombre" => "Carlos López",
                "ciudad" => "CDMX",
                "direccion" => "Av. Insurgentes Sur"
            ]
        ],
        "JKL8765" => [
            "Auto" => [
                "marca" => "NISSAN",
                "modelo" => 2021,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Ana Torres",
                "ciudad" => "Guadalajara, Jal.",
                "direccion" => "Col. Americana"
            ]
        ],
        "QWE9999" => [
            "Auto" => [
                "marca" => "FORD",
                "modelo" => 2017,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Luis Hernández",
                "ciudad" => "Monterrey, NL",
                "direccion" => "Av. Constitución"
            ]
        ],
        "RST1111" => [
            "Auto" => [
                "marca" => "CHEVROLET",
                "modelo" => 2022,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Sofía Ramírez",
                "ciudad" => "Toluca, Edo. Méx.",
                "direccion" => "Col. Centro"
            ]
        ],
        "UVW2222" => [
            "Auto" => [
                "marca" => "VOLKSWAGEN",
                "modelo" => 2015,
                "tipo" => "hachback"
            ],
            "Propietario" => [
                "nombre" => "Jorge Martínez",
                "ciudad" => "Querétaro, Qro.",
                "direccion" => "Col. Álamos"
            ]
        ],
        "OPQ3333" => [
            "Auto" => [
                "marca" => "KIA",
                "modelo" => 2021,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Mariana Cruz",
                "ciudad" => "Mérida, Yuc.",
                "direccion" => "Col. México Norte"
            ]
        ],
        "DEF4444" => [
            "Auto" => [
                "marca" => "HYUNDAI",
                "modelo" => 2020,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Pedro Sánchez",
                "ciudad" => "San Luis Potosí, SLP",
                "direccion" => "Col. Tequisquiapan"
            ]
        ],
        "GHI5555" => [
            "Auto" => [
                "marca" => "BMW",
                "modelo" => 2019,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Laura Fernández",
                "ciudad" => "Cancún, QRoo",
                "direccion" => "Zona Hotelera"
            ]
        ],
        "JKM6666" => [
            "Auto" => [
                "marca" => "AUDI",
                "modelo" => 2022,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Ricardo Pérez",
                "ciudad" => "CDMX",
                "direccion" => "Santa Fe"
            ]
        ],
        "NOP7777" => [
            "Auto" => [
                "marca" => "MERCEDES",
                "modelo" => 2016,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Gabriela Mendoza",
                "ciudad" => "Tijuana, BC",
                "direccion" => "Zona Río"
            ]
        ],
        "STU8888" => [
            "Auto" => [
                "marca" => "PEUGEOT",
                "modelo" => 2017,
                "tipo" => "hachback"
            ],
            "Propietario" => [
                "nombre" => "Andrés Vargas",
                "ciudad" => "León, Gto.",
                "direccion" => "Col. San Juan Bosco"
            ]
        ],
        "VWX9990" => [
            "Auto" => [
                "marca" => "RENAULT",
                "modelo" => 2018,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Isabel Gómez",
                "ciudad" => "Chihuahua, Chih.",
                "direccion" => "Av. Universidad"
            ]
        ],
        "YZA1010" => [
            "Auto" => [
                "marca" => "TESLA",
                "modelo" => 2023,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Miguel Domínguez",
                "ciudad" => "CDMX",
                "direccion" => "Polanco"
            ]
        ]
    ];
}

function buscarPorMatricula($matricula) {
    $parque = obtenerParqueVehicular();
    return $parque[$matricula] ?? null;
}
?>