let switchCtn = document.querySelector("#switch-cnt");
let switchC1 = document.querySelector("#switch-c1");
let switchC2 = document.querySelector("#switch-c2");
let switchCircle = document.querySelectorAll(".switch__circle");
let switchBtn = document.querySelectorAll(".switch-btn");
let aContainer = document.querySelector("#a-container");
let bContainer = document.querySelector("#b-container");

// Change form animation logic
let changeForm = (e) => {
    if (e.target.classList.contains('switch-btn')) {
        // Prevent form submission when switching forms
        e.preventDefault();

        switchCtn.classList.add("is-gx");
        setTimeout(function(){
            switchCtn.classList.remove("is-gx");
        }, 1500);

        switchCtn.classList.toggle("is-txr");
        switchCircle[0].classList.toggle("is-txr");
        switchCircle[1].classList.toggle("is-txr");

        switchC1.classList.toggle("is-hidden");
        switchC2.classList.toggle("is-hidden");
        aContainer.classList.toggle("is-txl");
        bContainer.classList.toggle("is-txl");
        bContainer.classList.toggle("is-z200");
    }
};

// Main function to bind click events
    let mainF = () => {
    // Attach event listener only to switch buttons
    for (let i = 0; i < switchBtn.length; i++) {
        switchBtn[i].addEventListener("click", changeForm);
    }
};

// Attach main function to window load event
window.addEventListener("load", mainF);
