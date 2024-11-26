'use strict';

/**
 * element toggle function
 */

const elemToggleFunc = function (elem) { elem.classList.toggle("active"); }



/**
 * navbar variables
 */
const navbar = document.querySelector("[data-nav]");
const overlay = document.querySelector("[data-overlay]");

const navElemArr = [overlay];

for (let i = 0; i < navElemArr.length; i++) {

  navElemArr[i].addEventListener("click", function () {
    elemToggleFunc(navbar);
    elemToggleFunc(overlay);
    elemToggleFunc(document.body);
  })
}



/**
 * go top
 */
const goTopBtn = document.querySelector("[data-go-top]");
window.addEventListener("scroll", function () {
  if (window.scrollY >= 800) {
    goTopBtn.classList.add("active");
  } else {
    goTopBtn.classList.remove("active");
  }

})

// Get the modal
var login_event = document.getElementById('login-id');
var signup_event = document.getElementById('signup-id');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target === login_event) {
    login_event.style.display = "none";
  }else if(event.target === signup_event){
    signup_event.style.display = "none";
  }
}

function signup(){
    
    document.getElementById('signup-id').style.display='block';
}

function passReset(){
    let login_event = document.getElementById('login-id');
    login_event.style.display = "none";    
    document.getElementById('passreset-id').style.display='block';
}

function confirmAddToCart(eventName, ticketType, price){
    swal({
      title: "Confirm to add to cart?",
      text: "Event: " + eventName + "\nTicket Type: " + ticketType + "\nPrice: $ " + price + "\nQuantity: 1",
      icon: "info",
      buttons: true,
      dangerMode: true,
    })
    .then((confirmAddToCart) => {
      if (confirmAddToCart) {
        swal({
          title: "Add to cart success!",
          text: "Your ticket has been added to cart!",
          icon: "success"
        });
        addToCart(ticketType, price);
      } else {
        swal({
          title: "Add to cart cancelled!",
          text: "Your ticket has not been adding to cart!",
          icon: "warning"
        });
        return;
      }
    });
}

function addToCart(ticketType, price) {
        var parent;
        switch(ticketType) {
          case "gold":
            parent = document.querySelectorAll('.card-actions')[1];
            break;
          case "silver":
            parent = document.querySelectorAll('.card-actions')[0];
            break;
          default:
            parent = document.querySelectorAll('.card-actions')[2];
        } 

	var eventName =  parent.querySelector('[name="event_name"]').value;
	var quantity =  parent.querySelector('[name="quantity"]').value;
        var tType = ticketType;
        
	var cartItem = {
		eventName: eventName,
		price: price,
		quantity: quantity,
                tType: ticketType
	};
	var cartItemJSON = JSON.stringify(cartItem);

	var cartArray = new Array();
	// If javascript shopping cart session is not empty
	if (localStorage.getItem('shopping-cart')) {
		cartArray = JSON.parse(localStorage.getItem('shopping-cart'));
	}
	cartArray.push(cartItemJSON);

	var cartJSON = JSON.stringify(cartArray);
	localStorage.setItem('shopping-cart', cartJSON);
        
        // Update cart badge
        var cartBadge = document.getElementById("cartBadge");
        cartBadge.innerHTML = "Cart<i style='font-size:12px;color: #fff;background: red;border-radius:50%;padding: 0 5px;position:relative;left:0px;top:-10px;opacity:0.9;'>"+cartArray.length+"</i>";
}

function displayCartBadge(){
    // If javascript shopping cart session is not empty
    if (localStorage.getItem('shopping-cart')) {
        var cartArray = new Array();
        cartArray = JSON.parse(localStorage.getItem('shopping-cart'));
        var cartBadge = document.getElementById("cartBadge");
        if(cartArray.length > 0){
            // Display cart badge
            cartBadge.innerHTML = "Cart<i style='font-size:12px;color: #fff;background: red;border-radius:50%;padding: 0 5px;position:relative;left:0px;top:-10px;opacity:0.9;'>"+cartArray.length+"</i>";
        }
    }
}

/*
function emptyCart() {
	if (localStorage.getItem('shopping-cart')) {
		// Clear JavaScript localStorage by index
		localStorage.removeItem('shopping-cart');
		showCartTable();
	}
}

function removeCartItem(index) {
	if (localStorage.getItem('shopping-cart')) {
		var shoppingCart = JSON.parse(localStorage.getItem('shopping-cart'));
		localStorage.removeItem(shoppingCart[index]);
		showCartTable();
	}
}
*/