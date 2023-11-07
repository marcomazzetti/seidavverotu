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
const checkWord = document.querySelector('#check-word', document.querySelector('#scrivi'));
if (checkWord) {
  // L'elemento HTML check-word esiste
  checkWord.innerHTML = 'Ciao mondo!';
  const frasee = frasi[Math.floor(Math.random() * frasi.length)].toLowerCase();
  checkWord.innerHTML = frasee;
  const checkInput = document.querySelector('#check-input');
  let firstInput, lastInput, diffArray = [];
  checkInput.onkeypress = (e) => {
    if (!firstInput) {
      firstInput = e.timeStamp;
      lastInput = firstInput;
    }
    const diff = e.timeStamp - lastInput;
    diffArray.push({ timeStamp: e.timeStamp, diff, key: e.key });
    console.log("La differenza in secondi è : " + diff / 1000 + "s", diffArray)
    lastInput = e.timeStamp;
    console.log("checkInput: ", checkInput.value);
    console.log("checkWord: ", checkWord.textContent);
    if (checkInput.value === checkWord.textContent) {
      console.log("Va!");
      checkInput.disabled = true;
    }
  }
} else {
  // L'elemento HTML check-word non esiste
  console.log('L\'elemento HTML check-word non esiste');
}


// Quando si preme il bottone "Cliccami!",
document.querySelector('#clicca').addEventListener('click', () => {
  // Apri la pagina HTML
  alert("Ciao!")
  /*window.location = 'verifica.php';*/
});