const modal = document.querySelector('[data-modal]');
const openRegistrationButton = document.querySelector('[data-open-register-modal]');
const registrationModal = document.querySelector('[data-register-modal]');
const infoBox = document.querySelector('[data-info-box]');
const modalBlurBackground = document.querySelector('[data-login-background]');

var regEmailInput = document.getElementById('val1dest');
var regFirstNameInput = document.getElementById('first-name');
var regLastNameInput = document.getElementById('last-name');
var regPhoneNumberInput = document.getElementById('phone-number');
var regPasswordInput = document.getElementById('password1');

var regEmailValue;
var regFirstNameValue;
var regLastNameValue;
var regPhoneNumberValue;
var regPasswordValue;

function openLoginModal() {
  modal.style.display = 'flex';
  modalBlurBackground.style.display = 'block';
  setInfoBoxPosition();
  document.cookie ="modalOpen = login";
}

function closeLoginModal() {
  modal.style.display = 'none';
  modalBlurBackground.style.display = 'none';
  infoBox.style.display = 'none';
  document.cookie ="modalOpen = none";
}

function openRegistrationModal() {
  registrationModal.style.display = 'flex';
  modalBlurBackground.style.display = 'block';
  setInfoBoxPosition();
  document.cookie ="modalOpen = register";
  transferLoginValues();
}

function closeRegistrationModal() {
  registrationModal.style.display = 'none';
  modalBlurBackground.style.display = 'none';
  infoBox.style.display = 'none';
  clearRegistrationInputValues();
  document.cookie ="modalOpen = none";
}

function handleSuccessfulLogin() {
  let queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const loginStat = urlParams.get('login');
  if (loginStat === 'success') {
    closeLoginModal();
  }
}

function handleSuccessfulRegistration() {
  let queryString = window.location.search;
  let urlParams = new URLSearchParams(queryString);
  let regStat = urlParams.get('register');
  if (regStat === 'success') {
    clearRegistrationInputValues();
    storeRegisterValues();
    closeRegistrationModal();
  }
}

// Function to store the state of the elements in local storage
function storeRegisterValues() {
  localStorage.setItem('regEmailValue', regEmailValue) || "";
  localStorage.setItem('regFirstNameValue', regFirstNameValue) || "";
  localStorage.setItem('regLastNameValue', regLastNameValue) || "";
  localStorage.setItem('regPhoneNumberValue', regPhoneNumberValue) || "";
  localStorage.setItem('regPasswordValue', regPasswordValue) || "";
}

function restoreRegisterValues() {
  try {
    regEmailInput.value = localStorage.getItem('regEmailValue');
    regFirstNameInput.value = localStorage.getItem('regFirstNameValue');
    regLastNameInput.value = localStorage.getItem('regLastNameValue');
    regPhoneNumberInput.value = localStorage.getItem('regPhoneNumberValue');
    regPasswordInput.value = localStorage.getItem('regPasswordValue');
  } catch (error) {
    console.log("No registration modal values to restore");
  }
}

// Function to restore the state of the elements from local storage
function restoreElementState() {
  if (document.cookie.includes("modalOpen=login")) {
    openLoginModal();
  }
  if (document.cookie.includes("modalOpen=register")) {
    openRegistrationModal();
  }
  restoreRegisterValues();
}

// Add an event listener to open the registration modal
openRegistrationButton.addEventListener('click', () => {
  infoBox.style.display = 'none';
  closeLoginModal();
  openRegistrationModal();
});

function transferLoginValues() {
  document.getElementById("val1dest").value = document.getElementById("val1").value
  document.getElementById("password1").value = document.getElementById("password").value
}

function setInfoBoxPosition() {
  // some formula to get the inner width of the viewport compared to just documeny.body.clientWidth which isnt accurate
  let vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
  loginRect = modal.getBoundingClientRect();
  registerRect = registrationModal.getBoundingClientRect();
  let elDistanceToTop = window.pageYOffset - document.body.scrollTop + modal.getBoundingClientRect().top + registrationModal.getBoundingClientRect().top;
  
  if (vw < 1024) {
    infoBox.style.top = `${elDistanceToTop + modal.offsetHeight + registrationModal.offsetHeight+ 10}px`;
    infoBox.style.height = "65px"
    infoBox.style.width = modal.offsetWidth + registrationModal.offsetWidth + 'px';
    infoBox.style.marginLeft = 0 - infoBox.offsetWidth/2;
  } else {
    infoBox.style.width = 200 + 'px';
    infoBox.style.height = 100 + 'px';
    infoBox.style.top = `${elDistanceToTop}px`;
    infoBox.style.marginLeft = `${modal.offsetWidth/2 + registrationModal.offsetWidth/2 + 30}px`;
  }
}

window.addEventListener('resize', setInfoBoxPosition);

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    closeModalCookie();
  }
});

// Call the setInfoBoxPosition function on DOMContentLoaded to initially position the info box
document.addEventListener('DOMContentLoaded', function () {
  setInfoBoxPosition();
  handleSuccessfulRegistration();
});

// Function to check for errors in the URL query parameters
function checkForErrors() {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const error = urlParams.get('error');

  // Switch case to handle different errors if wanted
  if (urlParams.has('error')) {
    switch (error) {
      case 'none':
        closeLoginModal(); // Close the modal when 'none' error is encountered
        break;
    }
  }
}

addEventListener("beforeunload", function() {
  setRegistrationInputValues();
  storeRegisterValues();
});

function setRegistrationInputValues() {
  regEmailInput = document.getElementById('val1dest');
  regEmailValue = regEmailInput.value;
  regFirstNameInput = document.getElementById('first-name');
  regFirstNameValue = regFirstNameInput.value;
  regLastNameInput = document.getElementById('last-name');
  regLastNameValue = regLastNameInput.value;
  regPhoneNumberInput = document.getElementById('phone-number');
  regPhoneNumberValue = regPhoneNumberInput.value;
  regPasswordInput = document.getElementById('password1');
  regPasswordValue = regPasswordInput.value;
}

function clearRegistrationInputValues() {
  regEmailInput.value = "";
  regFirstNameInput.value = "";
  regLastNameInput.value = "";
  regPhoneNumberInput.value = "";
  regPasswordInput.value = "";
  storeRegisterValues();
}

function togglePasswordReg() {
  var x = document.getElementById("password1");
  var icon = document.getElementsByClassName("eye");
  if (x.type === "password") {
    x.type = "text";
    icon[0].src = "../assets/eye-closed.svg"
  } else {
    x.type = "password";
    icon[0].src = "../assets/eye-open.svg"
  }
}

function togglePasswordLogin() {
  var x = document.getElementById("password");
  var icon = document.getElementsByClassName("eye");
  if (x.type === "password") {
    x.type = "text";
    icon[1].src = "../assets/eye-closed.svg"
  } else {
    x.type = "password";
    icon[1].src = "../assets/eye-open.svg"
  }
}

function resetIconStates() {
  var icon = document.getElementsByClassName("eye");
  icon[0].src = "../assets/eye-open.svg"
  icon[1].src = "../assets/eye-open.svg"
}

function closeModalCookie() {
  document.cookie = "modalStatus=closed";
  closeLoginModal();
  closeRegistrationModal();
}

function openModalCookie() {
  document.cookie = "modalStatus=open";
  openLoginModal();
}

function switchModal() {
  modal.style.display = 'none';
  registrationModal.style.display = 'flex';
}

restoreElementState();
checkForErrors();