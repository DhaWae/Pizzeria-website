const openButton = document.querySelector('[data-open-modal]')
const closeButton = document.querySelector('[data-close-modal]')
const modal = document.querySelector('[data-modal]')

const openRegistrationButton = document.querySelector('[data-open-register-modal]')
const registrationModal = document.querySelector('[data-register-modal]')

openRegistrationButton.addEventListener('click', () => {
  registrationModal.showModal();
  modal.close();
})

openButton.addEventListener('click', () => {
  modal.showModal();
})
        
closeButton.addEventListener('click', () => {
  modal.close();
})