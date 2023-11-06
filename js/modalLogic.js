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

// Set a flag for info visibility
let isInfoOpen = false;

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
  const urlParams = new URLSearchParams(queryString);
  const loginStat = urlParams.get('login');
  // If login is successful, close the modal
  if (loginStat === 'success') {
    closeLoginModal();
  }
}

// If a style value is found in local storage, apply it; otherwise, use the default style
if (storedStyle) {
  modal.style.cssText = storedStyle;
  modal.style.display = 'flex';
} else {
  modal.style.display = 'none'; // Default style
}

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
}

// Function to restore the state of the elements from local storage
function restoreElementState() {
  modal.style.display = localStorage.getItem('modalDisplay');
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
  }
});

// Call the setInfoBoxPosition function on DOMContentLoaded to initially position the info box
document.addEventListener('DOMContentLoaded', function () {
  setInfoBoxPosition();
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