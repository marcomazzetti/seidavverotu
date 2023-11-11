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
    $curr_page = "scrivi";
    include 'menu.inc.php';
    ?>
  </header>

  <!-- la parte centrale-->
  <div class="container centro">
    <h1>Sei davvero tu?</h1>
    <p> In questa sezione dovrai scrivere una frase. Se ti capita di sbagliare a scrivere, premi il pulsante "Reset" e ricomincia da capo. </p>
    <p> Inserisci la frase:</p>
    <p id="check-word"></p>
    <input type="text" id="check-input" />

    <button type="button" id="reset"> Reset </button>
  </div>

  <!-- la parte finale-->
  <div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
      <?php
      include 'footer.inc.php';
      ?>
    </footer>
  </div>

  <script src="scrivi.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>