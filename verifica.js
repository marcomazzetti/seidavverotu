// creo un array di frasi
const frasi = [
    "La vita è un viaggio pieno di sfide e opportunità, ma è importante ricordare che ogni esperienza ci arricchisce e ci rende più forti.",
    //"L'amore è una forza potente che può trasformare il mondo, ma è importante ricordare che deve essere basato sul rispetto e sulla reciprocità.",
    "La conoscenza è la chiave per la comprensione e la crescita personale, ma è importante ricordare che deve essere utilizzata per migliorare il mondo.",
    "La speranza è la luce che ci guida nel buio, ma è importante ricordare che deve essere accompagnata da azioni concrete.",
    //"La felicità è uno stato d'animo che possiamo coltivare ogni giorno, ma è importante ricordare che dipende da noi.",
    "La pazienza è una virtù preziosa che ci aiuta a raggiungere i nostri obiettivi, ma è importante ricordare che non deve essere sinonimo di rassegnazione.",
    "La gentilezza è un gesto semplice che può fare la differenza nel mondo, ma è importante ricordare che deve essere sincera.",
    "La compassione è la capacità di comprendere e condividere il dolore degli altri, ma è importante ricordare che deve essere accompagnata da azioni concrete.",
    //"La giustizia è il fondamento di una società civile e giusta, ma è importante ricordare che deve essere basata sull'uguaglianza e sul rispetto dei diritti umani.",
    "La libertà è un diritto inalienabile di tutti gli esseri umani, ma è importante ricordare che deve essere esercitata con responsabilità.",
    //"L'uguaglianza è la base di una società giusta e equa, ma è importante ricordare che deve essere basata sul rispetto delle differenze.",
    //"La pace è l'obiettivo di tutti gli esseri umani, ma è importante ricordare che deve essere costruita con impegno e determinazione.",
    "La speranza è la forza che ci spinge a continuare a lottare per un mondo migliore, ma è importante ricordare che deve essere accompagnata dalla consapevolezza che il cambiamento richiede tempo e impegno.",
    "La fede è la luce che ci illumina nei momenti di oscurità, ma è importante ricordare che deve essere basata sulla ragione e sulla logica.",
    //"L'amore è la forza più potente che esiste, ed è la base di tutte le relazioni sane.",
    "La vita è un dono prezioso che dobbiamo apprezzare e vivere appieno, ed è importante ricordare che il tempo è prezioso e non va sprecato.",
    "Il mondo è un posto meraviglioso pieno di bellezza e di meraviglie, ed è importante ricordare che dobbiamo proteggerlo e rispettarlo.",
    //"L'universo è infinito e pieno di misteri, ed è importante ricordare che siamo solo una piccola parte di un grande disegno.",
    //"L'intelligenza artificiale ha il potenziale di cambiare il mondo in modo positivo, ma è importante ricordare che deve essere utilizzata in modo responsabile e etico.",
    "Il cambiamento climatico è una minaccia globale che dobbiamo affrontare con urgenza, ed è importante ricordare che dobbiamo agire ora per evitare le conseguenze più gravi.",
    "La diseguaglianza è un problema globale che dobbiamo risolvere per costruire un mondo più giusto e sostenibile, ed è importante ricordare che dobbiamo agire tutti insieme.",
    "La violenza è una piaga che deve essere fermata e condannata, ed è importante ricordare che dobbiamo promuovere la pace e la non violenza.",
    "La guerra è un male che deve essere evitato e prevenuto, ed è importante ricordare che dobbiamo costruire un mondo basato sulla pace e sulla cooperazione.",
    //"La pace è l'obiettivo di tutti gli esseri umani, ed è importante ricordare che dobbiamo lavorare insieme per costruirla.",
    "La tranquillità di una passeggiata al tramonto è impagabile.",
    "Gli alberi si inchinano leggermente sotto il peso dei frutti maturi.",
    "Il rumore del mare è una melodia rassicurante per chi ama la natura.",
    "In primavera, i prati si riempiono di fiori dai colori vivaci.",
    "Nel cuore della foresta, il silenzio è interrotto solo dal canto degli uccelli e dal fruscio delle foglie.",
    "Attraversare un ponte sospeso regala emozioni uniche, con il vento che accarezza il viso.",
    "I libri sono finestre che si aprono su mondi fantastici e avventure straordinarie.",
    "Guardare le stelle durante una notte serena ci ricorda la vastità dell'universo.",
    "Perdersi in un labirinto di stradine antiche porta alla scoperta di angoli segreti e affascinanti.",
    "Una cena con amici, tra risate e buon cibo, è uno dei piaceri più semplici e genuini della vita.",
    "Il suono di una cascata in mezzo alla natura è una sinfonia che lenisce lo stress quotidiano.",
  ];
  
  
  const checkWord = document.querySelector('#check-word');
  
  //seleziono una frase random dall'array e la "inserisco" in html
  const frasee = frasi[Math.floor(Math.random() * frasi.length)].toLowerCase();
  checkWord.innerHTML = frasee;
  
  //qui inizio a concentrarmi su cosa scrive l'utente
  let checkInput = document.querySelector('#check-input');
  
  
  let nomeUtente = document.querySelector('#nome');
  const resetButton = document.querySelector('#reset');
  const proseguiButton = document.querySelector('#prosegui');
  proseguiButton.disabled = true;
  resetButton.disabled = true;
  
  let firstInput, lastInput, diffArray = []; //dichiaro 3 variabili
  
  
  let counter = 0; //counter di quante volte cancello
  checkInput.oninput = (e) => {    //ogni volta che viene modificato il testo
    if (!firstInput) { //se first input non ha un valore (cioè se è la prima volta che lo premo)
      firstInput = e.timeStamp; //first input diventa quello che viene ascoltato
      lastInput = firstInput;  // last input anche
      resetButton.disabled = false;
    }
    const diff = e.timeStamp - lastInput; //calcola differenza di tempo tra la pressione del tasto corrente e la pressione del tasto precedente
    diffArray.push({ diff, key: e.data }); //aggiunge  l'oggetto che contiene le informazioni sulla pressione del tasto corrente all'array diffArray.
    console.log("La differenza in secondi è : " + diff / 1000 + "s", diffArray);
    lastInput = e.timeStamp; //aggiorno la variabile last input al timestamp corrente
    console.log("checkInput: ", checkInput.value);
    console.log("checkWord: ", checkWord.textContent);
    console.log(checkWord.textContent.slice(0, checkInput.value.length));
  
    if (e.data == null) { //ogni volta che cancello aumento il counter
      counter += 1
    }
  
    //obbligo a resettare in certi casi
    if (levenshtein(checkInput.value, checkWord.textContent.slice(0, checkInput.value.length)) > checkWord.textContent.length / 10 ||
      counter > checkWord.textContent.length / 4) {
      checkInput.disabled = true;
    }
  
    if (checkWord.textContent.slice(0, checkInput.value.length) != checkInput.value) {
      checkInput.style.color = "red";
    } else {
      checkInput.style.color = "#000"
    }
  
  
  
  
    //controllo frase corretta
    if (checkInput.value === checkWord.textContent) {
      checkInput.style.backgroundColor = 'green';
      if (nomeUtente.textContent != null) {
        proseguiButton.disabled = false;
      }
      checkInput.disabled = true;
      resetButton.disabled = true;
      resetButton.textContent = "Frase inserita correttamente!";
      //adesso devo iniziare a ragionare sull'array per poter fare la media
      let somma = 0;
      diffArray.shift() //questo per eliminare il primo elemento dell'array (la prima lettera che premo ha diff 0 e ciò mi fa sbagliare il calcolo della varianza)
      for (const key of Object.keys(diffArray)) {
        somma += diffArray[key].diff;
      }
      let media = somma / (diffArray.length);
      console.log("La media in secondi è : " + media / 1000 + "s");
  
      let sommatoria_varianza = 0;
      for (const key of Object.keys(diffArray)) {
        sommatoria_varianza += (diffArray[key].diff - media) ** 2;
      }
      let varianza = sommatoria_varianza / (diffArray.length);
      console.log("La varianza in secondi al quadrato è : " + varianza / 1000000 + " s^2");
  
    }
  }
  
  // Quando si preme il bottone "Reset!",
  resetButton.addEventListener('click', () => {
    diffArray = []; //questo va bene 
    checkInput.value = '';
    firstInput = null;
    checkInput.disabled = false;
    counter = 0;
  
    /*window.location = 'verifica.php';*/
  })
  
  proseguiButton.addEventListener('click', () => {
    let nome = nomeUtente.value;
    let dati = diffArray;
    async function postData(url = "", data = {}) {
      const response = await fetch(url, {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ nome: data.nome, dati: JSON.stringify(data.dati) }), // body data type must match "Content-Type" header
      });
      return response.text(); // parses JSON response into native JavaScript objects
    }
  
    postData("verificadati.php", { nome: nome, dati: dati }).then((data) => {
      alert(data); // JSON data parsed by `data.json()` call
    });
  
  
  })
  
  function levenshtein(s, t) {
    if (s === t) {
      return 0;
    }
    var n = s.length, m = t.length;
    if (n === 0 || m === 0) {
      return n + m;
    }
    var x = 0, y, a, b, c, d, g, h;
    var p = new Uint16Array(n);
    var u = new Uint32Array(n);
    for (y = 0; y < n;) {
      u[y] = s.charCodeAt(y);
      p[y] = ++y;
    }
  
    for (; (x + 3) < m; x += 4) {
      var e1 = t.charCodeAt(x);
      var e2 = t.charCodeAt(x + 1);
      var e3 = t.charCodeAt(x + 2);
      var e4 = t.charCodeAt(x + 3);
      c = x;
      b = x + 1;
      d = x + 2;
      g = x + 3;
      h = x + 4;
      for (y = 0; y < n; y++) {
        a = p[y];
        if (a < c || b < c) {
          c = (a > b ? b + 1 : a + 1);
        }
        else {
          if (e1 !== u[y]) {
            c++;
          }
        }
  
        if (c < b || d < b) {
          b = (c > d ? d + 1 : c + 1);
        }
        else {
          if (e2 !== u[y]) {
            b++;
          }
        }
  
        if (b < d || g < d) {
          d = (b > g ? g + 1 : b + 1);
        }
        else {
          if (e3 !== u[y]) {
            d++;
          }
        }
  
        if (d < g || h < g) {
          g = (d > h ? h + 1 : d + 1);
        }
        else {
          if (e4 !== u[y]) {
            g++;
          }
        }
        p[y] = h = g;
        g = d;
        d = b;
        b = c;
        c = a;
      }
    }
  
    for (; x < m;) {
      var e = t.charCodeAt(x);
      c = x;
      d = ++x;
      for (y = 0; y < n; y++) {
        a = p[y];
        if (a < c || d < c) {
          d = (a > d ? d + 1 : a + 1);
        }
        else {
          if (e !== u[y]) {
            d = c + 1;
          }
          else {
            d = c;
          }
        }
        p[y] = d;
        c = a;
      }
      h = d;
    }
  
    return h;
  }