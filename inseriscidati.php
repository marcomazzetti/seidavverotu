<?php

// Connessione al database

$connessione = mysqli_connect("localhost", "root", "root", "seidavverotu");

// Recupero i dati dal form
$nome = $_POST['nome'];
$dati = $_POST['dati'];
$timestamp = date("Y-m-d H:i:s");


// Query SQL per l'inserimento dei dati
$query = "INSERT INTO misurazioni (utente, dati, timestamp) VALUES ('$nome', '$dati', '$timestamp');";

// Esecuzione della query
$risultato = mysqli_query($connessione, $query);

// Controllo del risultato
if ($risultato) {
    echo "Inserimento avvenuto correttamente";
} else {
    echo "Inserimento non eseguito";
}

// Chiusura della connessione
mysqli_close($connessione);

?>
