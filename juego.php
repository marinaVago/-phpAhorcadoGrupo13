<?php
/******************************************
*Completar:
* Marina Florencia Vago  FAI-3080
* Cintia Daniela Sanchez Muños  FAI-1785
* Leandro Gabriel Fuentes  FAI-465
******************************************/




/**
* Esta funcion crea una coleccion de palabras precargadas
* @return array
* array $coleccionPalabras
*/
function cargarPalabras()
{
  $coleccionPalabras = array();
  $coleccionPalabras[0]= array("palabra"=> "papa" , "pista" => "se cultiva bajo tierra", "ganaPuntos"=> 4);
  $coleccionPalabras[1]= array("palabra"=> "hepatitis" , "pista" => "enfermedad que inflama el higado", "ganaPuntos"=> 9);
  $coleccionPalabras[2]= array("palabra"=> "volkswagen" , "pista" => "marca de vehiculo", "ganaPuntos"=> 10);
  $coleccionPalabras[3] = array("palabra"=> "php" , "pista" => "lenguaje de programacion", "ganaPuntos"=> 3); 
  $coleccionPalabras[4] = array("palabra"=> "facebook" , "pista" => "red social", "ganaPuntos"=> 8); 
  $coleccionPalabras[5] = array("palabra"=> "cafe" , "pista" => "se bebe caliente", "ganaPuntos"=> 4); 
  $coleccionPalabras[6] = array("palabra"=> "limon" , "pista" => "es un citrico", "ganaPuntos"=> 5);   
  $coleccionPalabras[7] = array("palabra"=> "elefante" , "pista" => "mamifero cuadrupedo", "ganaPuntos"=> 8);
  

  return $coleccionPalabras;
}

/**
* Esta funcion crea una coleccion de juegos precargados
* @return array
* array $coleccionJuegos
**/
function cargarJuegos()
{
	$coleccionJuegos = array();
	$coleccionJuegos[0] = array("puntos"=> 0, "indicePalabra" => 1);
	$coleccionJuegos[1] = array("puntos"=> 10,"indicePalabra" => 2);
    $coleccionJuegos[2] = array("puntos"=> 0, "indicePalabra" => 1);
    $coleccionJuegos[3] = array("puntos"=> 8, "indicePalabra" => 0);
    $coleccionJuegos [4] = array("puntos"=> 0, "indicePalabra" => 7); 
    $coleccionJuegos [5] = array("puntos"=> 5, "indicePalabra" => 3); 
    $coleccionJuegos [6] = array("puntos"=> 4, "indicePalabra" => 5);
    $coleccionJuegos [7] = array("puntos"=> 11, "indicePalabra" => 6);
    
    
    
    return $coleccionJuegos;
}

/**
* A partir de una palabra se genera un arreglo que se utilizara para determinar si sus letras fueron o no descubiertas
* @param string $palabra
* @return array
* array $arregloLetras
* int $cantLetras
**/
function dividirPalabraEnLetras($palabra)
{
    $cantLetras = strlen($palabra);
    $arregloLetras = array();

    for($i = 0; $i < $cantLetras; $i++)
    {
        //en la posicion i del arreglo se guarda la letra del string de la posicion i y se setea su valor en false
        $arregloLetras[$i] = ["letra" => $palabra[$i], "descubierta" => false];
    }

    return $arregloLetras;    
}

/**
* muestra y obtiene una opcion de menú ***válida***
* @return int
**/
function seleccionarOpcion(){
    do
    {
        echo "--------------------------------------------------------------\n";
        echo "\n ( 1 ) Jugar con una palabra aleatoria"; 
        echo "\n ( 2 ) Jugar con una palabra elegida"; 
        echo "\n ( 3 ) Agregar una palabra al listado"; 
        echo "\n ( 4 ) Mostrar la informacion completa de un numero de juego"; 
        echo "\n ( 5 ) Mostrar la informacion del primer juego con mas puntaje "; 
        echo "\n ( 6 ) Mostrar la informacion del primer juego que supere un puntaje indicado por el usuario"; 
        echo "\n ( 7 ) Mostrar la lista de palabras ordenadas por alfabeto"; 
        echo "\n ( 8 ) Salir"; 
        echo "\n        ";
        $opcion = trim(fgets(STDIN));

        /*>>> Además controlar que la opción elegida es válida. Puede que el usuario se equivoque al elegir una opción <<<*/
        if($opcion < 1 || $opcion > 8)
         {
             echo "\n---------- Indique una opcion valida ----------\n";
         }
    } //Si la opcion es invalida muestra una advertencia y vuelve a mostrar el menu
    while(!($opcion >= 1 && $opcion <= 8));

    echo "--------------------------------------------------------------\n";
    return $opcion;
}

/**
* Determina si una palabra existe en el arreglo de palabras
* @param array $coleccionPalabras
* @param string $palabra
* @return boolean
* int $i, $cantPal
* boolean $existe
**/
function existePalabra($coleccionPalabras,$palabra){
    $i=0;
    $cantPal = count($coleccionPalabras);
    $existe = false;

    //Si encuentra alguna coincidencia dentro de la coleccion de palabras termina el bucle antes de que el contador llegue al limite
    while($i<$cantPal && !$existe){
        $existe = $coleccionPalabras[$i]["palabra"] == $palabra;
        $i++;
    }
    
    return $existe;
}


/**
* Determina si una letra existe en el arreglo de letras
* @param array $coleccionLetras
* @param string $letra
* @return boolean
* int $i, $cantLetras
* boolean $existe;
**/
function existeLetra($coleccionLetras, $letra )
{  
     $i = 0;
    $cantLetras = count($coleccionLetras);
    $existe = false;

    //Si encuentra alguna coincidencia dentro de la coleccion de letras termina el bucle antes de que el contador llegue al limite
    while($i < $cantLetras && !$existe)
    {   
        $existe = $coleccionLetras[$i]["letra"] == $letra;
        $i++;
    }
    
  return $existe;

}

/**
* Solicita los datos correspondientes a un elemento de la coleccion de palabras: palabra, pista y puntaje. 
* Internamente la función también verifica que la palabra ingresada por el usuario no exista en la colección de palabras.
* @param array $coleccionPalabras
* @return array  colección de palabras modificada con la nueva palabra
* int $cantPalabras, $puntos
* string $nuevaPalabra, $pistaPalabra
**/
function agregarPalabra($coleccionPalabras)
{
    $existe = true;
    $cantPalabras = count($coleccionPalabras);
    
    //Se comprueba si la palabra ingresada ya existe dentro de la coleccion de palabras
    while($existe)
    {
    echo "Ingrese una nueva palabra para adivinar \n";
    $nuevaPalabra = strtolower(trim(fgets(STDIN)));
    $existe = existePalabra($coleccionPalabras,$nuevaPalabra);

    //Si la palabra ya existe se lo comunica al usuario
    if($existe)
        {
            echo "La palabra ingresada ya existe \n";
        }
    }

    echo "Ingrese la pista para la nueva palabra a adivinar \n";
    $pistaPalabra = strtolower(trim(fgets(STDIN))); 

    echo "Ingrese la cantidad de puntos que se ganara con esta palabra \n";
    $puntos = trim(fgets(STDIN));

    $coleccionPalabras[$cantPalabras] = array("palabra"=> $nuevaPalabra, "pista" => $pistaPalabra, "ganaPuntos" => $puntos); 

    return $coleccionPalabras;
}


/**
* Obtener indice aleatorio
* @param int $min
* @param int $max
* @return int
**/
function indiceAleatorioEntre($min,$max)
{   
    //selecciona un numero aleatorio entre los numeros obtenidos por parametro
    $i = rand($min,$max); 
    return $i;
}

/**
* solicitar un valor entre min y max
* @param int $min
* @param int $max
* @return int
**/
function solicitarIndiceEntre($min,$max){ 
    do{
        echo "Seleccione un valor entre $min y $max: ";
        $i = trim(fgets(STDIN));
    }while(!($i>=$min && $i<=$max));
    
    return $i;
}



/**
* Determinar si la palabra fue descubierta, es decir, todas las letras fueron descubiertas
* @param array $coleccionLetras
* @return boolean
* int $cantLetras, $i
* boolean $palDescubierta
**/
function palabraDescubierta($coleccionLetras){
    $palDescubierta = true;
    $cantLetras = count($coleccionLetras);
    $i = 0;

    //Si alguna de las letras no fue descubierta corta el bucle antes que el contador llegue a su limite y devuelve false
    while($palDescubierta && $i < $cantLetras)
    {

        $palDescubierta = $coleccionLetras[$i]["descubierta"];
        $i++;
    }
    return $palDescubierta;
}

/**
* /*Solicita al usuario que ingrese una letra para verificar si existe en la palabra a adivinar 
*  si ingresa mas de una letra muestra un cartel para que vuelva a ingresar una sola letra hasta hacerlo correctamente
*@return string
*boolean $unaLetra
*
**/
function solicitarLetra()
{
    $unaLetra = false;
    do
    {
        echo "\n Ingrese una letra: ";
        $letra = strtolower(trim(fgets(STDIN)));
        if(strlen($letra)!=1){
            echo "\n Debe ingresar 1 letra!\n";
        }else{
            $unaLetra = true;
        }
        
    }while(!$unaLetra);
    
    return $letra;
}

/**
* Descubre todas las letras de la colección de letras iguales a la letra ingresada.
* Devuelve la coleccionLetras modificada, con las letras descubiertas seteadas en true
* @param array $coleccionLetras
* @param string $letra
* @return array $coleccionLetras
* int $cantLetras 
**/
function destaparLetra($coleccionLetras, $letra)
{
    $cantLetras = count($coleccionLetras);

    for($i = 0; $i < $cantLetras; $i++)
    {   
        //Si la letra en la posicion i es igual a la letra buscada se descubre la letra
        if ($coleccionLetras[$i]["letra"] == $letra)
        {
            $coleccionLetras[$i]["descubierta"] = true;
        }
    }

    return $coleccionLetras;

    
    
}

/**
* obtiene la palabra con las letras descubiertas y * (asterisco) en las letras no descubiertas. Ejemplo: he**t*t*s
* @param array $coleccionLetras
* @return string  Ejemplo: "he**t*t*s"
* int $cantLetras
* String $pal
**/
function stringLetrasDescubiertas($coleccionLetras)
{
    $pal = "";
    $cantLetras = count($coleccionLetras);

    for($i = 0; $i < $cantLetras; $i++)
        {   
            //Si la letra de la posicion i esta descubierta entonces se agrega la letra al string
            if($coleccionLetras[$i]["descubierta"] == true)
            {
                $pal[$i] = $coleccionLetras[$i]["letra"];
            }
            //Sino si la letra de la posicion i no esta descubierta se agrega un "*" al string 
            else
            {
                $pal[$i] = "*";
            }
        }
    
    return $pal;
}


/**
* Desarrolla el juego y retorna el puntaje obtenido
* Si descubre la palabra se suma el puntaje de la palabra más la cantidad de intentos que quedaron
* Si no descubre la palabra el puntaje es 0.
* @param array $coleccionPalabras
* @param int $indicePalabra
* @param int $cantIntentos
* @return int puntaje obtenido
* int $puntaje
* boolean $palabraFueDescubierta
* string $pal
* array $coleccionLetras
**/
function jugar($coleccionPalabras, $indicePalabra, $cantIntentos)
{
    $pal = $coleccionPalabras[$indicePalabra]["palabra"];
    $coleccionLetras = dividirPalabraEnLetras($pal);
    $puntaje = 0;
    $palabraFueDescubierta = false;

    //Mostrar pista:
    echo "\n****PISTA : ".$coleccionPalabras[$indicePalabra]["pista"]."*****";

    //entra a un bucle hasta que terminen los intentos o hasta que la palabra sea descubierta
    while($cantIntentos > 0 && $palabraFueDescubierta == false)
    {
     //solicita al usuario que adivine la palabra ingresando una letra
     $letra = solicitarLetra();

     //se verifica si la letra ingresada coincide con alguna letra de la palabra a adivinar
     $existe = existeLetra($coleccionLetras,$letra);

     //si la letra existe 
     if ($existe)
      {
         echo "\n La letra '$letra' PERTENECE a la palabra \n ";

         //se setea en "true" todas las ocurrencias de la letra descubierta en $coleccionLetras
         $coleccionLetras = destaparLetra($coleccionLetras, $letra);

         //se muestran las letras descubiertas hasta el momento
         $palabra = stringLetrasDescubiertas($coleccionLetras);

         //se verifica si la palabra entera fue descubierta
         $palabraFueDescubierta = palabraDescubierta($coleccionLetras);
        
         echo "\n Palabra a descubrir: $palabra \n";
      }
     else
      {
         //si la letra no coincide con ninguna letra de la palabra decrementan los intentos restantes y aparece un cartel
         $cantIntentos--;
         echo "\n La letra '$letra' NO PERTENECE a la palabra, quedan $cantIntentos intentos \n ";
      }
    }
    
    If($palabraFueDescubierta){
        //calcula el puntaje en base a la cantidad de puntos que otorga la palabra + la cantidad de intentos restantes
        $puntaje = $coleccionPalabras[$indicePalabra]["ganaPuntos"] + $cantIntentos;
        
        echo "\n¡¡¡¡¡¡GANASTE ".$puntaje." puntos!!!!!!\n";
    }else{
        echo "\n¡¡¡¡¡¡AHORCADO AHORCADO!!!!!!\n";
    }
    
    return $puntaje;
}

/**
* Agrega un nuevo juego al arreglo de juegos
* @param array $coleccionJuegos
* @param int $ptos
* @param int $indicePalabra
* @return array coleccion de juegos modificada
**/
function agregarJuego($coleccionJuegos,$puntos,$indicePalabra)
{
    $cantJuegos = count($coleccionJuegos);
    $coleccionJuegos[$cantJuegos] = array("puntos"=> $puntos, "indicePalabra" => $indicePalabra);    
    return $coleccionJuegos;
}



/**
* Muestra los datos completos de un registro en la colección de palabras
* @param array $coleccionPalabras
* @param int $indicePalabra
**/
function mostrarPalabra($coleccionPalabras,$indicePalabra)
{
    //$coleccionPalabras[0]= array("palabra"=> "papa" , "pista" => "se cultiva bajo tierra", "ganaPuntos"=>7);
    echo "  palabra: ".$coleccionPalabras[$indicePalabra]["palabra"]."\n";
    echo "  pista: ".$coleccionPalabras[$indicePalabra]["pista"]."\n";
    echo "  ganaPuntos: ".$coleccionPalabras[$indicePalabra]["ganaPuntos"]."\n";
  
    //Otra opcion :
    // print_r($coleccionPalabras[$indicePalabra]);  
}


/**
* Muestra los datos completos de un juego
* @param array $coleccionJuegos
* @param array $coleccionPalabras
* @param int $indiceJuego
*/
function mostrarJuego($coleccionJuegos,$coleccionPalabras,$indiceJuego){
    //array("puntos"=> 8, "indicePalabra" => 1)
    echo "\n\n";
    echo "<-<-< Juego ".$indiceJuego." >->->\n";
    echo "  Puntos ganados: ".$coleccionJuegos[$indiceJuego]["puntos"]."\n";
    echo "  Información de la palabra:\n";
    mostrarPalabra($coleccionPalabras,$coleccionJuegos[$indiceJuego]["indicePalabra"]);
    echo "\n";
}


/*>>> Implementar las funciones necesarias para la opcion 5 del menú <<<*/
/**
 * Devuelve el indice del juego con mayor puntaje dentro de la coleccion de juegos
 * @param array $coleccionJuegos
 * int $mejorJuego, $i
 */
function mayorPuntaje($coleccionJuegos)
{
    $cantJuegos = count($coleccionJuegos);
    $mejorJuego = 0;
    $i = 0;

    //Se recorren todos los juegos y se guarda la informacion del juego con el puntaje mas alto
    while ($i < $cantJuegos)
    {   
        // Si el puntaje del juego en la posicion i de la coleccion es mayor que el puntaje del mejor juego guardado hasta el momento
        if ($mejorJuego < $coleccionJuegos[$i]["puntos"])
        {
            // Se guarda el indice y el puntaje de ese juego
            $mejorJuego = $coleccionJuegos[$i]["puntos"];
            $indiceJuego = $i;
        }
        $i++;  
    }
    return $indiceJuego;

}

/*>>> Implementar las funciones necesarias para la opcion 6 del menú <<<*/
/**
 * Devuelve el indice del primer juego que supera el puntaje ingresado por el usuario
 * @param array $coleccionJuegos
 * @param double $puntaje
 * @return int
 */
function superaPuntaje($coleccionJuegos, $puntaje)
{
    $supera = false;
    $cantJuegos = count($coleccionJuegos);
    $indiceJuego = -1;
    $i = 0;
    
    //Recorre la coleccion de juegos hasta encontrar o hasta recorrerla en su totalidad
    while($i < $cantJuegos && !$supera)
    {   
        //Si el puntaje ingresado es menor al puntaje del juego en la posicion i
        if ($puntaje < $coleccionJuegos[$i]["puntos"])
        {
            //se almacena el indice del juego en la posicion i y se cambia el valor de la bandera $supera
            $indiceJuego = $i;
            $supera = true;
        }
        $i++;
    }
    return $indiceJuego;  
}

/*>>> Implementar las funciones necesarias para la opcion 7 del menú <<<*/
/**
 * Ordena la coleccion de palabras alfabeticamente y muestra la informacion por pantalla
 * @param array $coleccionPalabras
 * int $cantPal
 */
function ordenarPalabras($coleccionPalabras)
{
    $cantPal = count($coleccionPalabras);
    //rsort ordena los elementos de la coleccion de mayor a menor 
    rsort($coleccionPalabras);
        
    for ($i = 0; $i < $cantPal; $i++)
  {
      //imprime cada elemento de la coleccion de mayor a menor
      print_r($coleccionPalabras[$i]);
       echo " \n ";
    }
}



/******************************************/
/************** PROGRAMA PRINCIPAL *********/
/******************************************/
define("CANT_INTENTOS", 6); //Constante en php para cantidad de intentos que tendrá el jugador para adivinar la palabra.
define ("CANT_MIN_JUEGOS", 0); //Constante para la cantidad minima de juegos

//coleccion de juegos
$arregloJuegos = cargarJuegos();

//coleccion de palabras
$arregloPalabras = cargarPalabras();
$puntos = 0;


do{
    //Se invoca a la funcion seleccionarOpcion
    //Esta funcion despliega un menu y pide al usuario ingresar una opcion
    $opcion = seleccionarOpcion();

    //Se ejecuta el numero de opcion elegido por el usuario
    switch ($opcion) {
    case 1: //Jugar con una palabra aleatoria //usar rand (investigar)

            //Se invoca a la funcion indiceAleatorioEntre 
            //Esta funcion devuelve un numero aleatorio entre 0 y la cantidad de palabras que existen dentro de la coleccion de palabras
            $cantPalabras = count($arregloPalabras)-1;
            $nroPalabra = indiceAleatorioEntre(CANT_MIN_JUEGOS, $cantPalabras);
            $puntos = jugar($arregloPalabras, $nroPalabra, CANT_INTENTOS);
            $arregloJuegos = agregarJuego($arregloJuegos, $puntos, $nroPalabra);
        break;

    case 2: //Jugar con una palabra elegida //sugerir indicePalabra

            //se llama a la funcion solicitarIndiceEntre para que el usuario ingrese el numero de palabra a jugar
            $cantPalabras = count($arregloPalabras)-1;
            $nroPalabra = solicitarIndiceEntre(CANT_MIN_JUEGOS, $cantPalabras);

             //Almacena el puntaje del juego 
            $puntos = jugar($arregloPalabras, $nroPalabra, CANT_INTENTOS);

            //Se invoca a la funcion agregarJuego que retorna la coleccion de Juegos modificada
            //Esta funcion agrega la informacion del ultimo juego en la coleccion de juegos
            $arregloJuegos= agregarJuego($arregloJuegos,$puntos,$nroPalabra);
        

        break;
    case 3: //Agregar una palabra al listado //cargarPalabras
            $arregloPalabras = agregarPalabra($arregloPalabras);
        break;

    case 4: //Mostrar la información completa de un número de juego
            //Se invoca a la funcion solicitarIndiceEntre que pide al usuario ingresar un numero entre dos cotas 
            //Esta funcion retorna el indice del juego seleccionado por el usuario
            $cantJuegos = count($arregloJuegos)-1;
            $nroJuego = solicitarIndiceEntre(CANT_MIN_JUEGOS, $cantJuegos);

            //Invoca a la funcion mostrarJuego que muestra por pantalla la informacion completa del numero de juego ingresado
            mostrarJuego($arregloJuegos, $arregloPalabras, $nroJuego);
    
        break;

    case 5: //Mostrar la información completa del primer juego con más puntaje
                 //$mejorJuego almacena el indice del juego con mayor puntaje
                 $mejorJuego = mayorPuntaje($arregloJuegos);

                //Se muestra por pantalla el juego con mayor puntaje
                mostrarJuego($arregloJuegos, $arregloPalabras, $mejorJuego);
        break;

    case 6: //Mostrar la información completa del primer juego que supere un puntaje indicado por el usuario
            echo "Ingrese el puntaje \n";
            $puntos = trim(fgets(STDIN)); 
            
            //Se invoca a la funcion superaPuntaje que compara el puntaje de los juegos guardados con el puntaje ingresado por el usuario
            //Esta funcion retorna el indice del juego que supera el puntaje ingresado por el usuario, caso contrario retorna -1
            $nroJuego = superaPuntaje($arregloJuegos,$puntos);

            //Si no retorna -1 entonces existe un juego que supera el puntaje ingresado por el usuario
            if ($nroJuego != -1)
            {
                echo "El juego $nroJuego supera el puntaje ingresado \n";
                mostrarJuego($arregloJuegos, $arregloPalabras, $nroJuego);
            }
            else
            {   
                //Si retorna -1 entonces ningun juego supera el puntaje ingresado por el usuario
                echo "Ningun juego supera el puntaje ingresado \n";
            }

        break;

    case 7: //Mostrar la lista de palabras ordenada por orden alfabetico
            ordenarPalabras($arregloPalabras);
        break;
    }
}while($opcion != 8);

