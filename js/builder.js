var topping = document.getElementsByClassName("topping-on-pizza")
var ingredients = document.getElementsByClassName("ingredient")
var pizza = document.getElementById("pizza")

window.addEventListener("load", (event) => {
    topping = document.getElementsByClassName("topping-on-pizza")
    pizza = document.getElementById("pizza")
    console.log(topping)

    setToppingPositons();

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
    for (let i = 0; i < topping.length; i++) {
        topping[i].classList.add("invisible")
    }
}

function orderMessage() {
    alert("Pizza is on the way!")
}

function setToppingPositons() {

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

    // Some manual styling to make spread even better
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