<?php

//mi creo un array chiave-valore con a sinistra i gradi di libertà e a destra
//i t associati quando alpha = 0.025. (a 2 code 0.05)
$arraydit2 = [
    '1' => '12.71',
    '2' => '4.30',
    '3' => '3.18',
    '4' => '2.78',
    '5' => '2.57',
    '6' => '2.45',
    '7' => '2.36',
    '8' => '2.31',
    '9' => '2.26',
    '10' => '2.23',
    '11' => '2.20',
    '12' => '2.18',
    '13' => '2.16',
    '14' => '2.14',
    '15' => '2.13',
    '16' => '2.12',
    '17' => '2.11',
    '18' => '2.10',
    '19' => '2.09',
    '21' => '2.08',
    '22' => '2.07',
    '24' => '2.06',
    '27' => '2.05',
    '30' => '2.04',
    '33' => '2.03',
    '38' => '2.02',
    '45' => '2.01',
    '54' => '2.00',
    '69' => '1.99',
    '100' => '1.98',
    '160' => '1.97',
    '1000' => '1.96'
];

//i t associati quando alpha = 0.01. (a 2 code 0.02)
$arraydit2 = [
    '1' => '31.82',
    '2' => '6.96',
    '3' => '4.54',
    '4' => '3.75',
    '5' => '3.36',
    '6' => '3.14',
    '7' => '3.00',
    '8' => '2.90',
    '9' => '2.82',
    '10' => '2.76',
    '11' => '2.72',
    '12' => '2.68',
    '13' => '2.65',
    '14' => '2.62',
    '15' => '2.60',
    '16' => '2.58',
    '17' => '2.57',
    '18' => '2.55',
    '19' => '2.54',
    '20' => '2.53',
    '21' => '2.52',
    '22' => '2.51',
    '23' => '2.50',
    '24' => '2.49',
    '26' => '2.48',
    '27' => '2.47',
    '29' => '2.46',
    '31' => '2.45',
    '33' => '2.44',
    '36' => '2.43',
    '40' => '2.42',
    '44' => '2.41',
    '49' => '2.40',
    '56' => '2.39',
    '66' => '2.38',
    '79' => '2.37',
    '100' => '2.36',
    '140' => '2.35',
    '400' => '2.34',
    '1000' => '2.33'
];

//i t associati quando alpha = 0.05. (a 2 code 0.10)
$arraydit2 = [
    '1' => '6.31',
    '2' => '2.92',
    '3' => '2.35',
    '4' => '2.13',
    '5' => '2.02',
    '6' => '1.94',
    '7' => '1.89',
    '8' => '1.86',
    '9' => '1.83',
    '10' => '1.81',
    '11' => '1.80',
    '12' => '1.78',
    '13' => '1.77',
    '14' => '1.76',
    '15' => '1.75',
    '17' => '1.74',
    '18' => '1.73',
    '20' => '1.72',
    '23' => '1.71',
    '27' => '1.70',
    '32' => '1.69',
    '39' => '1.68',
    '52' => '1.67',
    '77' => '1.66',
    '160' => '1.65'
];

//i t associati quando alpha = 0.1. (a 2 code 0.20)
$arraydit = [
    '1' => '3.08',
    '2' => '1.89',
    '3' => '1.64',
    '4' => '1.53',
    '5' => '1.48',
    '6' => '1.44',
    '7' => '1.41',
    '8' => '1.40',
    '9' => '1.38',
    '10' => '1.37',
    '11' => '1.36',
    '13' => '1.35',
    '15' => '1.34',
    '17' => '1.33',
    '21' => '1.32',
    '26' => '1.31',
    '37' => '1.30',
    '64' => '1.29',
    '400' => '1.28'
];

// Connessione al database

$database = mysqli_connect("localhost", "root", "root", "seidavverotu");

// Recupero i dati dal form
$nome = $_POST['nome'];
$dati = $_POST['dati'];
$timestamp = date("Y-m-d H:i:s");

// Calcolo della media e della varianza
$nuovidati = json_decode($dati, true);

$differenze = array_column($nuovidati, 'diff');

sort($differenze);


//$differenze = array_slice($differenze, 1, -1 ); // (array, quanti toglierne a sinistra, quanti a destra)


$somma = 0;
$counter = 0;
$sommatoria_varianza = 0;

$somma = array_sum($differenze);
$counter = count($differenze);


$media = $somma / $counter;

foreach ($differenze as $n) {
    $sommatoria_varianza += ($n - $media) ** 2;
}

$varianza = $sommatoria_varianza / $counter;
$devstd = sqrt($varianza);

$differenze = array_filter($differenze, fn ($val) => ($val <= $media + 2 * $devstd) && ($val >= $media - $devstd));

$somma = 0;
$counter = 0;
$sommatoria_varianza = 0;

$somma = array_sum($differenze);
$counter = count($differenze);


$media = $somma / $counter;

foreach ($differenze as $n) {
    $sommatoria_varianza += ($n - $media) ** 2;
}

$varianza = $sommatoria_varianza / $counter;
$devstd = sqrt($varianza);



$q_contautenti = "SELECT COUNT(*) AS nome_in_utenti
            FROM utenti
            WHERE nome_utente = '$nome'";

$result = $database->query($q_contautenti);

$nome_in_utenti = $result->fetch_assoc()["nome_in_utenti"];

if ($nome_in_utenti == 0) {
    echo "errore";
} else {
    $q_estrapolazione = "SELECT media, varianza, numero_campioni FROM utenti WHERE nome_utente = '$nome'";
    $result = $database->query($q_estrapolazione);
    $dati_utente = $result->fetch_assoc();
    print_r($dati_utente);
    echo "La media inserita è: $media ";
    echo "La varianza è inserita: $varianza ";
    echo "Il numero di campioni inserito è $counter ";
    $media_database = $dati_utente['media'];
    $varianza_database = $dati_utente['varianza'];
    $numero_campioni_database = $dati_utente['numero_campioni'];
    echo "La media dell'utente nel database è: $media_database ";
    echo "La varianza dell'utente nel database è : $varianza_database ";
    echo "Il numero di campioni dell'utente nel database è $numero_campioni_database ";

    $t = abs(($media - $media_database) / sqrt($varianza / $counter + $varianza_database / $numero_campioni_database));
    echo "t vale $t";
    $gdl = $counter + $numero_campioni_database - 2;
    echo "I gradi di liberta sono $gdl ";
    $t_tabella = prendichiavepiccolaesistente($arraydit, $gdl);
    echo "La t nella tabella è $t_tabella ";

    if ($t_tabella < $t) {
        echo "Riprova! Non sei tu";
    } else {
        echo "Sei davvero tu!";
    }
}


function esistenzachiaveinarray($arraydit, $chiaveinserita)
{
    $result = "Esiste";
    if (!array_key_exists($chiaveinserita, $arraydit)) {
        $result = "Non esiste";
    }
    return $result;
}


function prendichiavepiccolaesistente($arraydit, $chiaveinserita)
{
    while (esistenzachiaveinarray($arraydit, $chiaveinserita) == "Non esiste") {
        $chiaveinserita--;
    }
    return $arraydit[$chiaveinserita];
}

/*adesso devo capire come confrontare i dati
innanzitutto calcolo la t,
poi devo capire quanti gradi di libertà ho. Per ora uso la semplice formula df = n1 + n2 -2 anche se sarebbe da usare 
preferibilmente quando le varianze sono simili
mi segno qui il link per migliorare il calcolo dei gradi di libertà in futuro.
https://www.sixsigmain.it/ebook/Capu6-15.html
*/