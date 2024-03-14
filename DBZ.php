<?php

class Personaje {
    public string $nombre;
    public int $nivel_poder;
    public int $ataque;
    public int $velocidad;
    public bool $turno;

    public function __construct($nombre, $nivel_poder, $ataque, $velocidad, $turno) {
        $this->nombre = $nombre;
        $this->nivel_poder = $nivel_poder;
        $this->ataque = $ataque;
        $this->velocidad = $velocidad;
        $this->turno = $turno;
    }


    public function realizarAtaque($atacante, $defensor) {
        if($defensor->nivel_poder>0){
        $defensor->nivel_poder -= $atacante->ataque;
        $atacante->turno = false;
        $defensor->turno = true;
        }else{
        $atacante->turno=false;
        }
    }

    public function calcularVidaTotal($equipo,$id) {
        $vidaTotal = 0;
        foreach ($equipo as $luchador) {
            $vidaTotal += $luchador->nivel_poder;
        }
        echo "El equipo ".$id. " tiene: ".$vidaTotal. "PH <br>";
        return $vidaTotal;
    }
}

class Sayajin extends Personaje {
    public bool $activado=false;

    public function superSayian($poder, $ataque, $activado) {
        $this->nivel_poder += $poder;
        $this->ataque *= $ataque;
        $this->activado=$activado;
        echo $this->nombre. " se transformó en SUPERSAYAJIN!! <br>";
    }
}

function ataque($equipo1, $equipo2) {

echo "COMIENZA EL COMBATE<br>";
foreach ($equipo1 as $key => $luchador1) {
    $key+=1;
    echo $key.$luchador1->nombre."<br>";
}
echo "VS <br>";
foreach ($equipo2 as $key => $luchador2) {
    $key+=1;
    echo $key.$luchador2->nombre."<br>";
}
echo "<br> <br> <br>";
    // Bucle principal del combate
    while (true) {
        // Calcula la vida total de cada equipo
        $vidaEquipo1 = $equipo1[0]->calcularVidaTotal($equipo1, "1");
        $vidaEquipo2 = $equipo2[0]->calcularVidaTotal($equipo2, "2");

        // Verifica si alguno de los equipos ha perdido
        if ($vidaEquipo1 <= 0 || $vidaEquipo2 <= 0) {
            break; // Sale del bucle principal
        }

        // Combate por turnos
        foreach ($equipo1 as $luchador1) {
            foreach ($equipo2 as $luchador2) {
                // Verifica si ambos luchadores están vivos
                if ($luchador1->nivel_poder > 0 && $luchador2->nivel_poder > 0) {
                    // Verifica si el luchador1 es un Sayajin y si no está transformado
                    if ($luchador1 instanceof Sayajin && !$luchador1->activado) {
                        // Genera un número aleatorio para determinar si se transforma
                        $probabilidad_transformacion = rand(1, 100);
                        if ($probabilidad_transformacion <= 20) {
                            $luchador1->superSayian(500, 20, true); // Transforma en Super Sayajin
                        }
                    }
                    if ($luchador2 instanceof Sayajin && !$luchador2->activado) {
                        // Genera un número aleatorio para determinar si se transforma
                        $probabilidad_transformacion = rand(1, 100);
                        if ($probabilidad_transformacion <= 20) {
                            $luchador2->superSayian(500, 20, true); // Transforma en Super Sayajin
                        }
                    }
                    // Realiza el ataque del primer equipo
                    $luchador1->realizarAtaque($luchador1, $luchador2);
                    echo $luchador1->nombre . " ha atacado a " . $luchador2->nombre . "<br>";

                    // Verifica si el segundo luchador sigue vivo después del ataque
                    if ($luchador2->nivel_poder <= 0) {
                        echo $luchador2->nombre." ha muerto<br>";
                        break 2; // Sale de los dos niveles de bucles
                    }

                    // Realiza el contraataque del segundo equipo
                    $luchador2->realizarAtaque($luchador2, $luchador1);
                    echo $luchador2->nombre . " ha atacado a " . $luchador1->nombre . "<br>";

                    // Verifica si el primer luchador sigue vivo después del contraataque
                    if ($luchador1->nivel_poder <= 0) {
                        echo $luchador1->nombre." ha muerto<br>";
                        break 2; // Sale de los dos niveles de bucles
                    }
                }
            }
        }
    }

    // Determina el resultado del combate
    if ($vidaEquipo1 <= 0) {
        echo "Gana el equipo 2";
    } else {
        echo "Gana el equipo 1";
    }
}


// Crear personajes
$goku = new Sayajin("Goku", 1000, 50, 100, true);
$vegeta = new Sayajin("Vegeta", 950, 40, 90, true);
$crillin = new Personaje("Crillin", 700, 40, 70, true);
$yamcha = new Personaje("Yamcha", 740, 35, 60, true);

// Agregar personajes a los equipos
$equipo1 = [$goku, $crillin];
$equipo2 = [$vegeta, $yamcha];
// Realizar el combate
ataque($equipo1, $equipo2);


