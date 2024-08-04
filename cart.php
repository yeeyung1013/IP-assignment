<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- 
            - favicon link
          -->
  <link rel="shortcut icon" href="/villain/assets/images/logo.png" type="image/png">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/cart.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&family=Poppins:wght@400;500;700&display=swap"
    rel="stylesheet">
    </head>
    <body id="top" onload="printItem()">
        <header class="header">

        <!-- 
          - overlay
        -->
        <div class="overlay" data-overlay></div>

        <div class="container">

          <a href="index.php" class="logo">
            <img src="./assets/images/logo.png" style="width: 115px; height: 115px;" alt="VILLAIN logo">
          </a>

          <button class="nav-open-btn" data-nav-open-btn>
            <ion-icon name="menu-outline"></ion-icon>
          </button>

          <nav class="navbar" data-nav>

            <ul class="navbar-list">

              <li>
                  <a href="#" class="navbar-link" onclick="document.location = '/villain/index.php'">Back</a>
              </li>
              
            </ul>

            <ul class="nav-social-list">

              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-twitter"></ion-icon>
                </a>
              </li>

              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-instagram"></ion-icon>
                </a>
              </li>

              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-github"></ion-icon>
                </a>
              </li>

              <li>
                <a href="#" class="social-link">
                  <ion-icon name="logo-youtube"></ion-icon>
                </a>
              </li>
            </ul>
          </nav>
        </div>

        </header>
        <div class="cart-adjust">
        <div class="cart-row">
          <div class="cart-col-75">
            <div class="cart-container">
                <div class="cart-row">
                  <div class="cart-col-50">
                    <h3>Billing Address</h3>
                    <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                    <input type="text" id="fname" name="firstname" placeholder="John M. Doe" required>
                    <label for="email"><i class="fa fa-envelope"></i> Email</label>
                    <input type="text" id="email" name="email" placeholder="john@example.com" required>
                    <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                    <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" required>
                    <label for="city"><i class="fa fa-institution"></i> City</label>
                    <input type="text" id="city" name="city" placeholder="New York" required>

                    <div class="cart-row">
                      <div class="cart-col-50">
                        <label class="cart-label" for="state">State</label>
                        <input type="text" id="state" name="state" placeholder="NY" required>
                      </div>
                      <div class="cart-col-50">
                        <label class="cart-label" for="zip">Zip</label>
                        <input type="text" id="zip" name="zip" placeholder="10001" required>
                      </div>
                    </div>
                  </div>

                  <div class="cart-col-50">
                    <h3>Payment</h3>
                    <label for="fname">Accepted Cards</label>
                    <div class="cart-icon-container">
                      <i class="fa fa-cc-visa" style="color:navy;"></i>
                      <i class="fa fa-cc-amex" style="color:blue;"></i>
                      <i class="fa fa-cc-mastercard" style="color:red;"></i>
                      <i class="fa fa-cc-discover" style="color:orange;"></i>
                    </div>
                    <label class="cart-label" for="cname">Name on Card</label>
                    <input type="text" id="cname" name="cardname" placeholder="John More Doe" required>
                    <label class="cart-label" for="ccnum">Credit card number</label>
                    <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" required>
                    <label class="cart-label" for="expmonth">Exp Month</label>
                    <input type="text" id="expmonth" name="expmonth" placeholder="September" required>
                    <div class="cart-row">
                      <div class="cart-col-50">
                        <label class="cart-label" for="expyear">Exp Year</label>
                        <input type="text" id="expyear" name="expyear" placeholder="2018" required>
                      </div>
                      <div class="cart-col-50">
                        <label class="cart-label" for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="352" required>
                      </div>
                    </div>
                  </div>

                </div>
                <label class="cart-label">
                  <input type="checkbox" checked="checked" name="sameadr" style="all:revert;"> Shipping address same as billing
                </label>
                <input type="submit" onclick="document.checkout.submit()" value="Continue to checkout" data-rel="back" class="cart-btn">
            </div>
          </div>
          <div class="cart-col-25">
                <div class="cart-container">
                    <form action="source/payment.php" method='POST' name="checkout">
                    <h4 id="cart-items">Cart <span class="cart-price" style="color:black"><i class="fa fa-shopping-cart"></i> <b id="cartTotalItems"></b></span><br><br></h4>
                    <br>
                    <hr class="cart-hr">
                    <p>Total <span class="cart-price" style="color:black"><b id="cartTotalPrice">$0</b></span></p>
                    </form>
                </div>
          </div>
        </div>
        </div>
    </body>
</html>
<script>
                  function printItem(){
                      // Get items from localStorage
                      var itemListString = localStorage.getItem('shopping-cart');
                      var itemList = JSON.parse(itemListString);
                      var cartTotalPrice = 0;
                      var ticketType = "";
                      
                      // Print cart total items
                      document.getElementById('cartTotalItems').innerHTML = itemList.length;
                      
                      // Print each item to cart
                      for(let i=0; i< itemList.length; i++) {
                          let itemJson = JSON.parse(itemList[i]);
                          ticketType = itemJson['tType'];
                          
                          document.getElementById("cart-items").innerHTML += "<p id='item"+i+"' name='items[]' style='margin-top: 4px; margin-bottom: 4px;'>"+itemJson['eventName']+" - "+ticketType+"<button style='float: right;' class='cart-del-btn' onclick='delItem(\"item"+i+"\");'>x</button><span class='cart-price'>$"+itemJson['price']+"&nbsp</span></p>";   
                          document.getElementById("cart-items").innerHTML += "<input type='hidden' name='items[]' value='"+itemJson['eventName']+"|"+ticketType+"'/><input type='hidden' name='prices[]' value='"+itemJson['price']+"'/>";
                          cartTotalPrice += itemJson['price'];
                      }
                      
                      // Print cart total price
                      document.getElementById("cartTotalPrice").innerHTML = "$"+cartTotalPrice;
                  }
                  
                  function delItem(id){
                      // Get items from localStorage
                      var itemListString = localStorage.getItem('shopping-cart');
                      var itemList = JSON.parse(itemListString);
                  
                      var elem = document.getElementById(id);
                      elem.parentNode.removeChild(elem);
                      
                      var cartArray = new Array();
                      for(let i=0; i< itemList.length; i++){
                          if(i != parseInt(id.replace("item",""))){
                              cartArray.push(itemList[i])
                          }
                      }
                      var cartJSON = JSON.stringify(cartArray);
                      console.log(cartJSON);
                      localStorage.setItem('shopping-cart', cartJSON);
                      
                      // Reload to refresh cart total items & localStorage
                      document.location.reload(true);
                  }
</script>