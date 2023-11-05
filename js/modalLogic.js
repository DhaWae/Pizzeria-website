const openButton = document.querySelector('[data-open-modal]')
const closeButton = document.querySelector('[data-close-modal]')
const modal = document.querySelector('[data-modal]')
const modalCont = document.querySelector('.login-container')

const openRegistrationButton = document.querySelector('[data-open-register-modal]')
const registrationModal = document.querySelector('[data-register-modal]')

const infoBox = document.querySelector('[data-info-box]')
const loginBackground = document.querySelector('[data-login-background]')

const loginBtn = document.getElementById('loginBtn');

const guestBtn = document.getElementById('guestBtn');





const storedStyle = localStorage.getItem('modalStyle');
info = false;
// If a style value is found, apply it; otherwise, use the default style
if (storedStyle) {
  modal.style.cssText = storedStyle;
} else {
  modal.style.display = 'none'; // Default style
}
let isInfoOpen = false;
// Add an event listener to update the style and store it when needed
openButton.addEventListener('click', () => {
  modal.style.display = 'flex';
  const currentStyle = modal.style.cssText;
  localStorage.setItem('modalStyle', currentStyle);
});

// Function to store the state of the elements in localStorage
function storeElementState() {
  localStorage.setItem('modalDisplay', modal.style.display);
  localStorage.setItem('loginBackgroundDisplay', loginBackground.style.display);
  localStorage.setItem('infoStatus', isInfoOpen);
}

// Function to restore the state of the elements from localStorage
function restoreElementState() {
  modal.style.display = localStorage.getItem('modalDisplay') || 'flex';
  loginBackground.style.display = localStorage.getItem('loginBackgroundDisplay') || 'block';
  isInfoOpen = localStorage.getItem('infoStatus') || false;
  setInfoBoxPosition();
}

// Add an event listener to open the modal
openButton.addEventListener('click', () => {
  modal.style.display = 'flex';
  loginBackground.style.display = 'block';
  isInfoOpen = true;
  setInfoBoxPosition();
  storeElementState(); // Store the state when the elements are changed
});

// Restore the element state when the page loads
restoreElementState();

// Add an event listener to close the modal
guestBtn.addEventListener('click', () => {
  modal.style.display = 'none';
  loginBackground.style.display = 'none';
  infoBox.style.display = 'none';
  isInfoOpen = false;
  storeElementState(); // Store the state when the elements are changed
});



openRegistrationButton.addEventListener('click', () => {
  const emailInput = document.getElementById('val1');
  const emailValue = emailInput.value;
  const passwordInput = document.getElementById('password');
  const passwordValue = passwordInput.value;

  console.log(emailValue);
  console.log(passwordValue);
  
  modal.style.display = 'none';
  registrationModal.style.display = 'flex';
  const registrationEmailInput = document.getElementById('val1dest');
  const registrationPasswordInput = document.getElementById('password1');
  registrationEmailInput.value = emailValue;
  registrationPasswordInput.value = passwordValue;

  //modal.close();
})

loginBtn.addEventListener('click', (event) => { 
  
})

openButton.addEventListener('click', () => {
  modal.style.display = 'flex';
  loginBackground.style.display = 'block';
  setInfoBoxPosition();
})

function setInfoBoxPosition() {
  console.log(localStorage.getItem('infoStatus'));
  let stat = localStorage.getItem('infoStatus');
  if(stat == 'false') {infoBox.style.display ="none"; return;}
  infoBox.style.display = 'flex';
  loginRect = modal.getBoundingClientRect();
  registerRect = registrationModal.getBoundingClientRect();
  var elDistanceToTop = window.pageYOffset - document.body.scrollTop + modal.getBoundingClientRect().top + registrationModal.getBoundingClientRect().top;
  console.log(document.body.scrollTop)
  infoBox.style.top = `${elDistanceToTop}px`;
  infoBox.style.marginLeft = `${loginRect.left/2 + registerRect.left/2}px`;
}

window.addEventListener('resize', setInfoBoxPosition);

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    loginBackground.style.display = 'none';
    infoBox.style.display = 'none';
    // CloseEverything();
  }
})   
closeButton.addEventListener('click', () => {
  //modal.close();
})






