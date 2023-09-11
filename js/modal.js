// modal.js
const modal = document.getElementById('myModal');
const closeModal = document.querySelector('.close');

// Function to open the modal
function openModal() {
  modal.style.display = 'block';
}

// Function to close the modal
function closeModalFunc() {
  modal.style.display = 'none';
}

// Event listener for modal close button
closeModal.addEventListener('click', closeModalFunc);

// Event listener to open the modal
// You can trigger this function from any element on your pages (e.g., a button)
// Example: document.querySelector('#openModalButton').addEventListener('click', openModal);
