const hungManImage = document.querySelector(".hang-man-box img");
const guessesText = document.querySelector(".guesses-text b");
const keyboardDiv = document.querySelector(".keyboard");
const worddisplay = document.querySelector(".word-display");
const LosingMessege = document.querySelector("#game-modal-for-losing");
const LosingMessegeCorrectWord = document.querySelector(
  "#game-modal-for-losing p b"
);

const LosingMessegeButton = document.querySelector(
  "#game-modal-for-losing button"
);

const WinningMessege = document.querySelector("#game-modal-for-winning");
const WinningMessegeCorrectWord = document.querySelector(
  "#game-modal-for-winning p b"
);

const WinningMessegeButton = document.querySelector(
  "#game-modal-for-winning button"
);

let currentWord,
  wrongGuessCount = 0;
let maxGuesses = 6;

const getRandomWord = () => {
  const { word, hint } = wordList[Math.floor(Math.random() * wordList.length)];
  currentWord = word;
  console.log(word);

  document.querySelector(".hint-text b").innerText = hint;

  worddisplay.innerHTML = word
    .split("")
    .map(() => `<li class="letter"></li>`)
    .join(""); //make element for each char and join for deleting commas
};

const initGame = (button, clickedLetter) => {
  console.log(button, clickedLetter);
  if (currentWord.includes(clickedLetter)) {
    //... convert word to array of letters
    [...currentWord].forEach((letter, index) => {
      if (letter === clickedLetter) {
        worddisplay.querySelectorAll("li")[index].innerText = letter;
        worddisplay.querySelectorAll("li")[index].classList.add("guessed");
      }
    });
    const allGuessed = [...worddisplay.querySelectorAll("li")].every((li) =>
      li.classList.contains("guessed")
    );
    if (allGuessed) {
      WinningMessege.style.display = "flex";
      WinningMessegeCorrectWord.innerHTML = currentWord;
    }
  } else {
    console.log("the clicked letter not exist in the word");
    if (wrongGuessCount < 6) {
      wrongGuessCount++;
    }
    hungManImage.src = `assets/images/hangman-${wrongGuessCount}.svg`;
    if (wrongGuessCount == 6) {
      LosingMessege.style.display = "flex";
      LosingMessegeCorrectWord.innerHTML = currentWord;
    }
  }
  guessesText.innerHTML = `${wrongGuessCount} / ${maxGuesses}`;
};


for (let i = 97; i < 123; i++) {
  const button = document.createElement("button");
  button.innerText = String.fromCharCode(i);
  keyboardDiv.appendChild(button);
  button.addEventListener("click", (e) =>
    initGame(e.target, String.fromCharCode(i))
  );
}

getRandomWord();

document.addEventListener("keydown", (e) => {
  let key = e.key.toLowerCase();

  if (key >= "a" && key <= "z") {
    const button = [...keyboardDiv.querySelectorAll("button")]
      .find(b => b.innerText === key);

    if (button && !button.disabled) {
      initGame(button, key);
      button.disabled = true; 
    } else {
      

      initGame(e.target, key); 
    }
  }
});


const resetGame = () => {
  wrongGuessCount = 0;
  hungManImage.src = "assets/images/hangman-0.svg";
  guessesText.innerHTML = `${wrongGuessCount} / ${maxGuesses}`;
  LosingMessege.style.display = "none";
  WinningMessege.style.display = "none";

  getRandomWord();
};

LosingMessegeButton.addEventListener("click", resetGame);
WinningMessegeButton.addEventListener("click", resetGame);
