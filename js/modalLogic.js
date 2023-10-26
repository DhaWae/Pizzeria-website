const openButton = document.querySelector('[data-open-modal]')
const closeButton = document.querySelector('[data-close-modal]')
const modal = document.querySelector('[data-modal]')

const openRegistrationButton = document.querySelector('[data-open-register-modal]')
const registrationModal = document.querySelector('[data-register-modal]')

const infoBox = document.querySelector('[data-info-box]')
const loginBackground = document.querySelector('[data-login-background]')

openRegistrationButton.addEventListener('click', () => {
  registrationModal.showModal();
  //modal.close();
})

openButton.addEventListener('click', () => {
  modal.showModal();
  loginBackground.style.display = 'block';
  setInfoBoxPosition();
})

function setInfoBoxPosition() {
  if(!modal.open) return;
  infoBox.style.display = 'flex';
  loginRect = modal.getBoundingClientRect();
  var elDistanceToTop = window.pageYOffset - document.body.scrollTop + modal.getBoundingClientRect().top
  console.log(document.body.scrollTop)
  infoBox.style.top = `${elDistanceToTop}px`;
  infoBox.style.marginLeft = `${loginRect.left/2}px`;
}

window.addEventListener('resize', setInfoBoxPosition);

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    loginBackground.style.display = 'none';
    infoBox.style.display = 'none';
  }
})   
closeButton.addEventListener('click', () => {
  //modal.close();
})






