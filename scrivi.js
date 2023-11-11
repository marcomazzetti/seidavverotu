// creo un array di frasi
const frasi = [
  "Chi la dura la vince",
  "Meglio tardi che mai",
  "Tanto va la gatta al lardo che ci lascia lo zampino",
  "Ogni medaglia ha il suo rovescio",
  "L'appetito vien mangiando",
  "Né acqua senza sale, né donna senza burla",
  "Ogni morte fa un erede",
  "Piove sul bagnato",
  "Chi troppo vuole, nulla stringe",
  "Non c'è due senza tre"
];

const checkWord = document.querySelector('#check-word');

//seleziono una frase random dall'array e la "inserisco" in html
const frasee = frasi[Math.floor(Math.random() * frasi.length)].toLowerCase();
checkWord.innerHTML = "cane";

//qui inizio a concentrarmi su cosa scrive l'utente
let checkInput = document.querySelector('#check-input');

const resetButton = document.querySelector('#reset');

let firstInput, lastInput, diffArray = []; //dichiaro 3 variabili

checkInput.onkeydown = (e) => {
  if (e.keyCode === 8 || e.keyCode === 46) { //così facendo l'utente non può cancellare
    e.preventDefault();
  }
}
checkInput.oninput = (e) => {    //ogni volta che viene rilasciato un tasto
  if (!firstInput) { //se first input non ha un valore (cioè se è la prima volta che lo premo)
    firstInput = e.timeStamp; //first input diventa quello che viene ascoltato
    lastInput = firstInput;  // last input anche
  }
  const diff = e.timeStamp - lastInput; //calcola differenza di tempo tra la pressione del tasto corrente e la pressione del tasto precedente
  diffArray.push({ timeStamp: e.timeStamp, diff, key: e.key }); //aggiunge  l'oggetto che contiene le informazioni sulla pressione del tasto corrente all'array diffArray.
  console.log("La differenza in secondi è : " + diff / 1000 + "s", diffArray);
  lastInput = e.timeStamp; //aggiorno la variabile last input al timestamp corrente
  console.log("checkInput: ", checkInput.value);
  console.log("checkWord: ", checkWord.textContent);
  if (checkInput.value === checkWord.textContent) {
    console.log("Va!");
    checkInput.disabled = true;
    resetButton.disabled = true;
    resetButton.textContent = "Frase inserita correttamente!";
    //adesso devo iniziare a ragionare sull'array per poter fare la media
    let somma = 0;
    diffArray.shift() //questo per eliminare il primo elemento dell'array (la prima lettera che premo ha diff 0 e ciò mi fa sbagliare il calcolo della varianza)
    console.log(diffArray);
    for (const key of Object.keys(diffArray)) {
      somma += diffArray[key].diff;
    }
    let media = somma / (diffArray.length);
    console.log("La media in secondi è : " + media / 1000 + "s");

    let sommatoria_varianza = 0 ;
    for (const key of Object.keys(diffArray)) {
      sommatoria_varianza += (diffArray[key].diff - media) ** 2;
      console.log(sommatoria_varianza);
    }
    let varianza = sommatoria_varianza / (diffArray.length);
    console.log("La varianza in secondi al quadrato è : " + varianza / 1000000 + " s^2");

  }
}
// Quando si preme il bottone "Cliccami!",
resetButton.addEventListener('click', () => {
  diffArray = []; //questo va bene 
  checkInput.value = '';
  firstInput = null

    /*window.location = 'verifica.php';*/
})

//PROBLEMA ENORME! METTENDO onkeyup, se premo più cose insieme non vengono catturati entrambi gli eventi.
/* Scherzone, il problema non è quello. Quando vengono premuti o rilasciati più tasti contemporaneamente, vengono catturati entrambi gli eventi.
L'unico problema è quando succede alla fine della frase, infatti può capitare questo fatto:
l'utente sta per finire di scrivere una frase: nel momento in cui digita la penultima lettera, preme subito anche l'ultima;
l'utente può però "fare l'errore" di rilasciare l'ultima lettera prima della penultima (così facendo la frase, se inserita correttamente, si 
  illumina in verde e iniziano i calcoli della media e della varianza. L'evento "penultima lettera rilasciata" non viene quindi preso,
  ma la penultima lettera risulta scritta correttamente.
  Devo quindi capire quale sia la scelta migliore fra:
  _ cercare di lasciare il keyup e capire come risolvere questo problema -> spero di riuscire in questa strada
  _sostituire il keyup con un keydown/keypress -> così facendo avrei il problema che avevo all'inizio, cioè che il checkinput non stava al passo
  di ciò che scrivevo (rimaneva sempre una lettera in meno, non ricordo esattamente il motivo).

  Strada 1: devo capire ESATTAMENTE il problema per capire come affrontarlo.
  Quando viene catturato l'evento "rilasciata una lettera" parte il controllo dell'if e se la frase è scritta correttamente, si inizia a
  calcolare media e varianza e viene disabilitato il checkinput, quindi in pratica non viene più controllato se vengono rilasciati altri pulsanti
  devo riuscire a entrare nell'if solo quando i pulsanti sono rilasciati (devo però stare attento che si rischia di superare la frase non
    accorgendosi che è corretta)
    Provo a utilizzare oninput -> okay, va! Più semplice di quel che avevo previsto!

  */