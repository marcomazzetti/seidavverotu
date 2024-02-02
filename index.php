<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sei davvero tu?</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="grafica.css" type="text/css">

</head>

<body>

  <!-- inizio con gli header, cioè i titoletti in alto su cui devo ricordarmi di fare interagire cliccandoci sopra-->
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <?php
    $curr_page = "index";
    include 'menu.inc.php';
    ?>

  </header>

  <!-- la parte centrale-->
  <div class="container">
    <form action="" method="post">

      <h1>Sei davvero tu?</h1>

      <p> <br>
        "Sei davvero tu?" è un'applicazione che vuole testare se sei davvero tu a scrivere in base alla velocità con cui scrivi.
        <br><br> Scrivi qui il tuo nome:
      </p>

      <input type="text" name="nome" id="nome" placeholder="Nome" autocomplete="off" />

        <br /><br /> Inserisci la frase:
      </p>

      <p id="check-word"></p>

      <div class="actions">
        <button type="button" id="reset"> Reset </button>
      </div>

      <textarea rows="3" id="check-input" autocomplete="off"></textarea>

      <p> <br> <br> Maggiori informazioni:<br>in questa sezione dovrai scrivere una frase. Se ti capita di sbagliare a scrivere potrai
      resettare oppure continuare a scrivere, come preferisci.<br>
        Se farai troppi errori, ti obbligherò io a resettare.<br>
        Una volta che avrai inserito correttamente la frase, potrai continuare a scriverne altre.<br> Così facendo, le informazioni che avrò sulla
        tua modalità di scrittura saranno sempre più precise.<br>
        Infine, quando vuoi, puoi premere sul "Verifica" in alto a sinistra per permettermi di verificare se sei davvero tu a scrivere.

    </form>
    <div class="message"></div>
  </div>



  <script src="scrivi.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>