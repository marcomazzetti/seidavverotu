<?php

// Connessione al database

$connessione = mysqli_connect("localhost", "root", "root", "seidavverotu");

// Recupero i dati dal form
$nome = $_POST['nome'];
$dati = $_POST['dati'];
$timestamp = date("Y-m-d H:i:s");


// Query SQL per l'inserimento dei dati in misurazioni
$query = "INSERT INTO misurazioni (utente, dati, timestamp) VALUES ('$nome', '$dati', '$timestamp');";

// Esecuzione della query
$risultato = mysqli_query($connessione, $query);

// Controllo del risultato
if ($risultato) {
    echo "Inserimento avvenuto correttamente";
} else {
    echo "Inserimento non eseguito";
}

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



echo "La media è: $media ";
echo "La varianza è: $varianza ";
echo "Il numero di campioni è $counter ";


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
    } else {
        // $nome esiste già nella tabella, quindi fai il replace
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
    $sql = "UPDATE utenti
            SET media = '$media', varianza = '$varianza', numero_campioni = '$counter'
            WHERE nome_utente = '$nome';";

    $mysqli = new mysqli("localhost", "root", "root", "seidavverotu");
    $mysqli->query($sql);
}
// Inserimento o sostituzione delle informazioni dell'utente nella tabella "utenti"
insertOrReplaceUtente($nome, $media, $varianza, $counter);

/*
Carica i dati facendo il parsing del json [$nuovidati =json_decode($dati)], dai nuovi dati estrapolo media e varianza,
poi faccio una replace dentro la tabella utente per nome, media e varianza, numero_campioni (numero lettere).
Altra pagina analoga "inviadati2.html" dove invio i dati a verificadati.php che estrae nome utente, media e varianza analizzando
i dati e poi confronta media e varianza con quelle presenti nel database.
*/

// Chiusura della connessione
mysqli_close($connessione);



