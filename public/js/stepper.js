document.addEventListener("DOMContentLoaded", () => {
  const dobInput = document.getElementById("dob");
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, '0');
  const day = String(today.getDate()).padStart(2, '0');

  const maxDate = `${year}-${month}-${day}`;
  dobInput.setAttribute("max", maxDate);
});


const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const submitBtn = document.querySelector('input[type="submit"]');

const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");

let formStepsNum = 0;

nextBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    const currentStep = formSteps[formStepsNum];
    const inputs = currentStep.querySelectorAll("input");

    let allValid = true;
    inputs.forEach((input) => {
      const errorMessage = input.nextElementSibling;
      if (input.value.trim() === "") {
        allValid = false;
        input.classList.add("input-error");
        errorMessage.textContent = "*Este campo es obligatorio.";
      } else {
        input.classList.remove("input-error");
        errorMessage.textContent = "";
      }

      if (input.type === "email" && !validateEmail(input.value.trim())) {
        allValid = false;
        input.classList.add("input-error");
        errorMessage.textContent = "*Ingrese un correo electrónico válido.";
      }
    });

    if (allValid) {
      formStepsNum++;
      updateFormSteps();
      updateProgressbar();
    } else {
      e.preventDefault();
    }
  });
});

prevBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    formStepsNum--;
    updateFormSteps();
    updateProgressbar();
  });
});

submitBtn.addEventListener("click", (e) => {
  const password = document.getElementById("password").value.trim();
  const confirmPassword = document.getElementById("confirmPassword").value.trim();
  const passwordErrorMessage = document.getElementById("confirmPassword").nextElementSibling;

  if (password === "" || confirmPassword === "") {
    e.preventDefault();
    document.getElementById("confirmPassword").classList.add("input-error");
    passwordErrorMessage.textContent = "Por favor, complete ambos campos de contraseña.";
  } else {
    document.getElementById("confirmPassword").classList.remove("input-error");
    passwordErrorMessage.textContent = "";
  }

  if (password !== confirmPassword) {
    e.preventDefault();
    document.getElementById("confirmPassword").classList.add("input-error");
    passwordErrorMessage.textContent = "Las contraseñas deben coincidir.";
  } else {
    document.getElementById("confirmPassword").classList.remove("input-error");
    passwordErrorMessage.textContent = "";
  }
});


function updateFormSteps() {
  formSteps.forEach((formStep) => {
    formStep.classList.contains("form-step-active") &&
      formStep.classList.remove("form-step-active");
  });

  formSteps[formStepsNum].classList.add("form-step-active");
}

function updateProgressbar() {
  progressSteps.forEach((progressStep, idx) => {
    if (idx < formStepsNum + 1) {
      progressStep.classList.add("progress-step-active");
    } else {
      progressStep.classList.remove("progress-step-active");
    }
  });

  const progressActive = document.querySelectorAll(".progress-step-active");

  progress.style.width =
    ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
}

function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(String(email).toLowerCase());
}
