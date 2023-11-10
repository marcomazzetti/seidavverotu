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
checkWord.innerHTML = frasee;

//qui inizio a concentrarmi su cosa scrive l'utente
let checkInput = document.querySelector('#check-input');

let firstInput, lastInput, diffArray = []; //dichiaro 3 variabili
checkInput.onkeypress = (e) => {    //ogni volta che viene premuto un tasto si attiva l'ascoltatore di eventi
  if (!firstInput) { //se first input non ha un valore (cioè se è la prima volta che lo premo)
    firstInput = e.timeStamp; //first input diventa quello che viene ascoltato
    lastInput = firstInput;  // last input anche
  }
  const diff = e.timeStamp - lastInput; //calcola differenza di tempo tra la pressione del tasto corrente e la pressione del tasto precedente
  diffArray.push({ timeStamp: e.timeStamp, diff, key: e.key }); //aggiunge  l'oggetto che contiene le informazioni sulla pressione del tasto corrente all'array diffArray.
  console.log("La differenza in secondi è : " + diff / 1000 + "s", diffArray)
  lastInput = e.timeStamp; //aggiorno la variabile last input al timestamp corrente
  console.log("checkInput: ", checkInput.value);
  console.log("checkWord: ", checkWord.textContent);
  if (checkInput.value === checkWord.textContent) {
    console.log("Va!");
    checkInput.disabled = true;
  }
}

// Quando si preme il bottone "Cliccami!",
document.querySelector('#reset').addEventListener('click', () => {
  diffArray = []; //questo va bene 
  checkInput.value = '';
  firstInput = null;


  /*window.location = 'verifica.php';*/
});