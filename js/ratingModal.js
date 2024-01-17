
const showBtns = document.getElementsByClassName("rating-button");
const dialog = document.getElementById("rating-modal");
const jsCloseBtn = dialog.querySelector(".close-modal");
const commentArea = document.querySelector("#comment");
const hiddenField = document.querySelector("#rating");

console.log(showBtns);


var starCount;
for (let i = 0; i < showBtns.length; i++) {
    showBtns[i].addEventListener("click", () => {
        dialog.showModal();
        starWrapper.addEventListener('mousemove', mouseMoveHandler);
        starCount = 1;
        starContainer.style.width = starCount * 20 + '%';
        hiddenField.value = starCount;
        commentArea.value = "";
    });
}






jsCloseBtn.addEventListener("click", (e) => {
  e.preventDefault();
  dialog.close();
});

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded');
});


const starContainer = document.querySelector("#rating-stars-filled");
const starWrapper = document.querySelector(".star-wrapper-rating");
console.log(starContainer);


const mouseMoveHandler = (e) => {
    const percentage = (e.clientX - starWrapper.getBoundingClientRect().left) / starWrapper.offsetWidth * 100;
    console.log(percentage);
    const starValues = [20, 40, 60, 80, 100];
    starCount = 0;

    for (let i = 0; i < starValues.length; i++) {
        if (percentage <= starValues[i]) {
            starCount = i + 1;
            break;
        }
    }

    starContainer.style.width = starCount * 20 + '%';
    hiddenField.value = starCount;
};


starWrapper.addEventListener('mousemove', mouseMoveHandler);


starWrapper.addEventListener('click', (e) => {
    console.log('clicked');
    const percentage = (e.clientX - starWrapper.getBoundingClientRect().left) / starWrapper.offsetWidth * 100;
    const starValues = [20, 40, 60, 80, 100];
    for (let i = 0; i < starValues.length; i++) {
        if (percentage <= starValues[i]) {
            starCount = i + 1;
            break;
        }
    }

    starContainer.style.width = starCount * 20 + '%';

    // Remove the mousemove event listener using the same function reference
    starWrapper.removeEventListener('mousemove', mouseMoveHandler);
    hiddenField.value = starCount;
});

