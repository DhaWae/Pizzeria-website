const modal = document.querySelector('[data-modal]');
const openRegistrationButton = document.querySelector('[data-open-register-modal]');
const registrationModal = document.querySelector('[data-register-modal]');
const infoBox = document.querySelector('[data-info-box]');
const loginBackground = document.querySelector('[data-login-background]');


var regEmailInput = document.getElementById('val1dest');
var regEmailValue;
var regFirstNameInput = document.getElementById('first-name');
var regFirstNameValue;
var regLastNameInput = document.getElementById('last-name');
var regLastNameValue;
var regPhoneNumberInput = document.getElementById('phone-number');
var regPhoneNumberValue;
var regPasswordInput = document.getElementById('password1');
var regPasswordValue;

var isInfoOpen = false;
var isRegistrationOpen = false;

function closeLoginModal() {
  modal.style.display = 'none';
  loginBackground.style.display = 'none';
  infoBox.style.display = 'none';
  isInfoOpen = false;
  storeElementState();
}

function closeRegistrationModal() {
  registrationModal.style.display = 'none';
  loginBackground.style.display = 'none';
  infoBox.style.display = 'none';
  isRegistrationOpen = false;
  storeElementState();
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
    registrationModal.style.display = 'none';
    // Clear stored registration data when modal closes
  }
}

// Add an event listener to open the modal
function openLoginModal() {
  modal.style.display = 'flex';
  loginBackground.style.display = 'block';
  isInfoOpen = true;
  setInfoBoxPosition();
  storeElementState();
}

// Function to store the state of the elements in local storage
function storeElementState() {
  localStorage.setItem('modalDisplay', modal.style.display);
  localStorage.setItem('loginBackgroundDisplay', loginBackground.style.display);
  localStorage.setItem('infoStatus', isInfoOpen);
  localStorage.setItem('registrationModalDisplay', isRegistrationOpen);
  console.log("SETTING REGEMAILVALUE TO:" + regEmailValue);
  localStorage.setItem('regEmailValue', regEmailValue) || "";
  console.log("REGEMAILVALUE IS" + localStorage.getItem('regEmailValue'));
  localStorage.setItem('regFirstNameValue', regFirstNameValue) || "";
  localStorage.setItem('regLastNameValue', regLastNameValue) || "";
  localStorage.setItem('regPhoneNumberValue', regPhoneNumberValue) || "";
  localStorage.setItem('regPasswordValue', regPasswordValue) || "";
}

// Function to restore the state of the elements from local storage
function restoreElementState() {
  console.log(localStorage.getItem('modalDisplay') + "moddisplay");
  if (localStorage.getItem('modalDisplay') == 'flex') {
    modal.style.display = 'flex';
  } else { modal.style.display = 'none'; }
  console.log(localStorage.getItem('registrationModalDisplay') + "regdisplay");
  if (localStorage.getItem('registrationModalDisplay') == 'true') {
    registrationModal.style.display = 'flex';
  } else { registrationModal.style.display = 'none'; }

  try {
    console.log("SETTING REGEMAILINPUT TO:" + localStorage.getItem('regEmailValue'));
    regEmailInput.value = localStorage.getItem('regEmailValue');
    regFirstNameInput.value = localStorage.getItem('regFirstNameValue');
    regLastNameInput.value = localStorage.getItem('regLastNameValue');
    regPhoneNumberInput.value = localStorage.getItem('regPhoneNumberValue');
    regPasswordInput.value = localStorage.getItem('regPasswordValue');
  } catch (error) {
    console.log("No registration modal values to restore");
  }
  
  
  //registrationModal.style.display = localStorage.getItem('registrationModalDisplay') || 'none';
  console.log(localStorage.getItem('registrationModalDisplay') + "regdisplay");
  loginBackground.style.display = localStorage.getItem('loginBackgroundDisplay') || 'none';

  isInfoOpen = localStorage.getItem('infoStatus') === 'true';
  setInfoBoxPosition();
}

// Restore the element state when the page loads
restoreElementState();

// Add an event listener to open the registration modal
openRegistrationButton.addEventListener('click', () => {
  
  infoBox.style.display = 'none';

  // Get email and password input values
  const emailInput = document.getElementById('val1');
  const emailValue = emailInput.value;
  const passwordInput = document.getElementById('password');
  const passwordValue = passwordInput.value;

  modal.style.display = 'none';
  registrationModal.style.display = 'flex';

  // Set the input values in the registration modal
  const registrationEmailInput = document.getElementById('val1dest');
  const registrationPasswordInput = document.getElementById('password1');
  registrationEmailInput.value = emailValue;
  registrationPasswordInput.value = passwordValue;
});

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
    closeLoginModal();
    registrationModal.style.display = 'none';
  }
});

// Call the setInfoBoxPosition function on DOMContentLoaded to initially position the info box
document.addEventListener('DOMContentLoaded', function () {
  setInfoBoxPosition();
  handleSuccessfulRegistration();
});

// Function to check for errors in the URL query parameters
function CheckForErrors() {
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

// Call the CheckForErrors function to check for errors on page load
CheckForErrors();

addEventListener("beforeunload", function() {
  if(modal.style.display == "" || modal.style.display == "none") {
    console.log("login modal closed");
    isInfoOpen = false;
  } else {
    isInfoOpen = true;
  }

  if(registrationModal.style.display == "" || registrationModal.style.display == "none") {
    console.log("reg modal closed");
    isRegistrationOpen = false;
  } else {
    isRegistrationOpen = true;
  }
  setRegistrationInputValues();
  storeElementState();
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