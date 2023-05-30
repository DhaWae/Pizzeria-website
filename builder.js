

var topping = document.getElementsByClassName("test")
var ingredients = document.getElementsByClassName("ingredient")
var pizza = document.getElementById("pizza")

function loadAndScrollToElement(id) {
 
  currentWindow = window;
  var a = window.open("index.html", "_blank");
  a.focus();

  a.addEventListener('load', function(){
    a.scrollToElement(`${id}`);
  }, true);

  setTimeout(() => {  currentWindow.close() }, 10);

  element = document.getElementById(`${id}`);
  element.scrollIntoView({ behavior: "smooth", block: "center", inline: "center" });
}

window.addEventListener("load", (event) => {
    console.log("page is fully loaded");
    topping = document.getElementsByClassName("test")
    pizza = document.getElementById("pizza")
    console.log(topping)

    randomizeToppingPositons();
    console.log(ingredients)

    for (let i = 0; i < ingredients.length; i++) {
        ingredients[i].addEventListener("click", function(){ 

        if(topping[i].classList.contains("invisible")) {
            topping[i].classList.remove("invisible")
        } else {
            topping[i].classList.add("invisible")
        }});
    }
    

});

function clearPizza() {
    randomizeToppingPositons();

    for (let i = 0; i < topping.length; i++) {

        topping[i].classList.add("invisible")
    }
    

}

function orderMessage() {
    alert("Pizza is on the way!")
    // Usage
    const dimension = 2; // Number of dimensions for the sequence
    const numPoints = 10; // Number of points to generate
    
    // Usage
    for (let i = 1; i <= 10; i++) {
        const randomNumber = vanDerCorputSequence(i, 3); // Generate Van der Corput sequence using base 2
        console.log(randomNumber * 100);
    }
}

function randomizeToppingPositons() {

   

    for (let i = 0; i < topping.length; i++) {
        const randomNumber = haltonSequence(i, 2)
        topping[i].style.top = `${i*6}%`
        topping[i].style.left = `${Math.floor(randomNumber * 100 -10)}%`

        if(topping[i].classList.contains("invisible")) {
            topping[i].classList.remove("invisible")
        } else {
            topping[i].classList.add("invisible")
        }
    }
    topping[0].style.top = `${-10}%`
    topping[0].style.left = `${10}%`
    topping[1].style.top = `${-4}%`
}

function haltonSequence(index, base) {
    let result = 0;
    let f = 1 / base;
    let i = index;
  
    while (i > 0) {
      result += f * (i % base);
      i = Math.floor(i / base);
      f = f / base;
    }
  
    return result;
  }

