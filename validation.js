// VARIABLES
const inputUl = document.querySelector(".list");

// FUNCTIONS

// Reset inputs
function resetInput(input, errorDiv) {
  const errorText = errorDiv.querySelector(".error-text");
  input.classList.remove("valid");
  input.classList.remove("invalid");
  input.closest(".item").querySelector(".short").classList.add("hidden");
  if (input.id === "nom") {
    errorText.innerText = "Le nom doit comporter entre 2 et 30 caractères";
  } else if (input.id === "prenom") {
    errorText.innerText = "Le prenom doit comporter entre 2 et 30 caractères";
  } else if (input.id === "email") {
    errorText.innerText = "Adresse e-mail est invalide";
  }
}

function checkValid(input, errorDiv) {
  // Check for empty fields
  if (input.value.trim() === "") {
    notValid(input, errorDiv, "empty");
  }

  // Validate username
  else if (input.id === "nom") {
    if (input.value.length <= 1 || input.value.length >= 31) {
      notValid(input, errorDiv, "filled");
    }
  } else if (input.id === "prenom") {
    if (input.value.length <= 1 || input.value.length >= 31) {
      notValid(input, errorDiv, "filled");
    }
  }

  // Validate email
  else if (input.id === "email") {
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
      notValid(input, errorDiv, "filled");
    }
  }
}

// Invalid value
function notValid(input, errorDiv, error) {
  input.classList.add("invalid");
  errorDiv.classList.remove("hidden");
  input.closest(".item").querySelector(".short").classList.remove("hidden");
  if (error === "empty") {
    errorDiv.querySelector(".error-text").innerText = "Ce champ est obligatoire";
  }
}

// EVENT LISTENERS
inputUl.addEventListener("focusout", input => {
  const errorDiv = input.target.nextElementSibling;
  resetInput(input.target, errorDiv);
  checkValid(input.target, errorDiv);
});
