<?php

$returnMessage = new stdClass();
$returnMessage->console = "";

// Connessione al database

$database = mysqli_connect("localhost", "root", "root", "seidavverotu");

// Recupero i dati dal form
$nome = $_POST['nome'];
$dati = $_POST['dati'];
$timestamp = date("Y-m-d H:i:s");


// Query SQL per l'inserimento dei dati in misurazioni
// Questa parte si bugga con gli apostrofi nelle frasi: non mi inserisce i dati in misurazioni, ma li inserisce/ modifica in utenti.
$query = "INSERT INTO misurazioni (utente, dati, timestamp) VALUES ('$nome', '$dati', '$timestamp');";

// Esecuzione della query
$risultato = mysqli_query($database, $query);

// Controllo del risultato
if ($risultato) {
    $returnMessage->message = "Inserimento avvenuto correttamente!";
    $returnMessage->color = "green";
} else {
    $returnMessage->message = "Inserimento non eseguito.";
    $returnMessage->color = "red";
}

$errore = mysqli_error($database);

if ($errore) {
    $returnMessage->message = "Errore: $errore";
    $returnMessage->color = "red";
}

// Calcolo della media e della varianza
$nuovidati = json_decode($dati, true);

$differenze = array_column($nuovidati, 'diff');

sort($differenze);

// print_r($differenze);

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

$differenze = array_filter($differenze, fn ($val) => ($val <= $media + 2*$devstd) && ($val >= $media - $devstd));
// print_r($differenze);

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

function insertOrReplaceUtente($nome, $media, $varianza, $counter)
{
    // Controlla se $nome esiste già nella tabella
    $sql = "SELECT COUNT(*) AS nome_in_utenti
            FROM utenti
            WHERE nome_utente = '$nome'";

    $mysqli = new mysqli("localhost", "root", "root", "seidavverotu");
    $result = $mysqli->query($sql);

    $nome_in_utenti = $result->fetch_assoc()["nome_in_utenti"];

    if ($nome_in_utenti == 0) {
        // $nome non esiste già nella tabella, quindi inseriscilo
        insertUtente($nome, $media, $varianza, $counter);
        // echo "inserisci";
    } else {
        // $nome esiste già nella tabella, quindi fai il replace
        // echo "modifica";
        replaceUtente($nome, $media, $varianza, $counter);
    }

    $mysqli->close();
}

function insertUtente($nome, $media, $varianza, $counter)
{
    $sql = "INSERT INTO utenti (nome_utente, media, varianza, numero_campioni)
            VALUES ('$nome', '$media', '$varianza', '$counter');";

    $mysqli = new mysqli("localhost", "root", "root", "seidavverotu");
    $mysqli->query($sql);
}

function replaceUtente($nome, $media, $varianza, $counter)
{
    $database = mysqli_connect("localhost", "root", "root", "seidavverotu");
    $q_estrapolazione = "SELECT media, varianza, numero_campioni FROM utenti WHERE nome_utente = '$nome'";
    $result = $database->query($q_estrapolazione);
    $dati_utente = $result->fetch_assoc();
    $media_database = $dati_utente['media'];
    $varianza_database = $dati_utente['varianza'];
    $numero_campioni_database = $dati_utente['numero_campioni'];

    $nuova_media = ($media_database * $numero_campioni_database +$media*$counter)/($numero_campioni_database + $counter);
    $nuova_varianza = ($varianza_database * $numero_campioni_database +$varianza*$counter)/($numero_campioni_database + $counter);
    $nuovo_numero_campioni = $numero_campioni_database + $counter;

    $sql = "UPDATE utenti
            SET
             media = $nuova_media,
              varianza = $nuova_varianza,
               numero_campioni = $nuovo_numero_campioni
            WHERE nome_utente = '$nome';";
            //UPDATE seidavverotu.utenti set media = media * 0.3 + 100 * 0.7 WHERE nome_utente = 'Marco';

    $mysqli = new mysqli("localhost", "root", "root", "seidavverotu");
    $mysqli->query($sql);
    // echo "devo fare replace!";
}
// Inserimento o sostituzione delle informazioni dell'utente nella tabella "utenti"
insertOrReplaceUtente($nome, $media, $varianza, $counter);

// Chiusura della connessione
mysqli_close($database);

echo json_encode($returnMessage);



