// Get your DOM elements
const openButton = document.querySelector('[data-open-modal]');
const closeButton = document.querySelector('[data-close-modal]');
const modal = document.querySelector('[data-modal]');
const modalCont = document.querySelector('.login-container');
const openRegistrationButton = document.querySelector('[data-open-register-modal]');
const registrationModal = document.querySelector('[data-register-modal]');
const infoBox = document.querySelector('[data-info-box]');
const loginBackground = document.querySelector('[data-login-background]');
const loginBtn = document.getElementById('loginBtn');
const guestBtn = document.getElementById('guestBtn');
const regBtn = document.getElementById('confirmRegistrationBtn');

// Get the stored modal style from local storage
const storedStyle = localStorage.getItem('modalStyle');
const storedRegistrationStyle = localStorage.getItem('registrationModalStyle');
const confirmRegistrationBtn = document.getElementById('confirmRegistrationBtn');
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

// Set a flag for info visibility
var isInfoOpen = false;
var isRegistrationOpen = false;
// Function to close the login modal
function closeLoginModal() {
  modal.style.display = 'none';
  loginBackground.style.display = 'none';
  infoBox.style.display = 'none';
  isInfoOpen = false;
  storeElementState();
}

// Check for successful login
function handleSuccessfulLogin() {
  // Perform your successful login check here
  let queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const loginStat = urlParams.get('login');
  // If login is successful, close the modal
  if (loginStat === 'success') {
    closeLoginModal();
  }
}

function handleSuccessfulRegistration() {
  console.log("HANDLING SUCCESSFUL REGISTRATION");
  let queryString = window.location.search;
  let urlParams = new URLSearchParams(queryString);
  console.log("QUERY STRING: " + queryString);
  let regStat = urlParams.get('register');
  console.log("REGSTAT: " + regStat);
  if (regStat === 'success') {
    registrationModal.style.display = 'none';
    console.log("REGISTRATION SUCCESSFUL CLOSED MODAL");
    // Clear stored registration data
  }
}

confirmRegistrationBtn.addEventListener('click', () => {
  //handleSuccessfulRegistration();
});

// If a style value is found in local storage, apply it; otherwise, use the default style
/*if (storedStyle) {
  modal.style.cssText = storedStyle;
  modal.style.display = 'flex';
} else {
  modal.style.display = 'none'; // Default style
}*/

// Add an event listener to open the modal
openButton.addEventListener('click', () => {
  modal.style.display = 'flex';
  loginBackground.style.display = 'block';
  isInfoOpen = true;
  setInfoBoxPosition();
  storeElementState();
});

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

// Add an event listener to handle successful login
loginBtn.addEventListener('click', (event) => {
  handleSuccessfulLogin();
});

// Add an event listener to close the modal
guestBtn.addEventListener('click', () => {
  closeLoginModal();
});

// Add an event listener to open the modal
openButton.addEventListener('click', () => {
  modal.style.display = 'flex';
  loginBackground.style.display = 'block';
  setInfoBoxPosition();
});

// Function to set the position of the info box
function setInfoBoxPosition() {
  loginRect = modal.getBoundingClientRect();
  registerRect = registrationModal.getBoundingClientRect();
  var elDistanceToTop = window.pageYOffset - document.body.scrollTop + modal.getBoundingClientRect().top + registrationModal.getBoundingClientRect().top;
  console.log(document.body.scrollTop)
  infoBox.style.top = `${elDistanceToTop}px`;
  infoBox.style.marginLeft = `${loginRect.left/2 + registerRect.left/2}px`;
}

// Add an event listener to handle window resize
window.addEventListener('resize', setInfoBoxPosition);

// Add an event listener to close the modal and info box when the 'Escape' key is pressed
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
/*
window.onbeforeunload = function(event)
{
  console.log("Confirm refresh");
  if(modal.style.display === 'flex') {
    return "You have attempted to leave this page. Are you sure?";
  }
};*/

addEventListener("beforeunload", function() {
  console.log("Checking login modal state");
  console.log("login modal state: " + modal.style.display);
  if(modal.style.display == "" || modal.style.display == "none") {
    console.log("login modal closed");
    isInfoOpen = false;
  } else {
    isInfoOpen = true;
  }

  console.log("Checking register modal state");
  console.log("reg modal state: " + registrationModal.style.display);
  if(registrationModal.style.display == "" || registrationModal.style.display == "none") {
    console.log("reg modal closed");
    isRegistrationOpen = false;
  } else {
    isRegistrationOpen = true;
  }
  regEmailInput = document.getElementById('val1dest');
  regEmailValue = regEmailInput.value;
  console.log("REG EMAIL VALUE" + regEmailValue)
  regFirstNameInput = document.getElementById('first-name');
  regFirstNameValue = regFirstNameInput.value;
  regLastNameInput = document.getElementById('last-name');
  regLastNameValue = regLastNameInput.value;
  regPhoneNumberInput = document.getElementById('phone-number');
  regPhoneNumberValue = regPhoneNumberInput.value;
  regPasswordInput = document.getElementById('password1');
  regPasswordValue = regPasswordInput.value;
  storeElementState();
});