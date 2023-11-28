<?php

// Connessione al database

$database = mysqli_connect("localhost", "root", "root", "seidavverotu");

// Recupero i dati dal form
$nome = $_POST['nome'];
$dati = $_POST['dati'];
$timestamp = date("Y-m-d H:i:s");

// Calcolo della media e della varianza
$nuovidati = json_decode($dati, true);

$somma = 0;
$counter = 0;
$sommatoria_varianza = 0;

foreach ($nuovidati as $n) {
    $somma += $n['diff'];
    $counter += 1;
}

$media = $somma / $counter;

foreach ($nuovidati as $n) {
    $sommatoria_varianza += ($n['diff'] - $media) ** 2;
}

$varianza = $sommatoria_varianza / $counter;




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
}

//adesso devo capire come confrontare i dati
