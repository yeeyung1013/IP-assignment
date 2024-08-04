<?php include("../source/header.php");?>

  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section id="hero" style="background: url('/villain/assets/images/event1/hero-banner.png') no-repeat;background-size: cover;  background-position: top center;  margin-top: 90px;  padding: var(--section-padding) 0;  height: 100vh; /** Default: 100vh**/  max-height: 1000px;  display: flex;  justify-content: center;  align-items: center;  text-align: center;">
        <div class="container">

          <p class="hero-subtitle">League Of Legends</p>

          <h1 class="h1 hero-title">Esport</h1>

          <div class="btn-group">

            <button class="btn btn-primary" onclick="location.href='#tickets';">
              <span>Join now</span>

              <ion-icon name="play-circle"></ion-icon>
            </button>

            <button class="btn btn-link" onclick="location.href='#about';">Learn more</button>

          </div>

        </div>
      </section>





      <div class="section-wrapper">

        <!-- 
          - #ABOUT
        -->

        <section class="about" id="about">
          <div class="container">

            <figure class="about-banner">

              <img src="../assets/images/event1/about-img.jpg" alt="about-img" class="about-img">

            </figure>

            <div class="about-content">

              <p class="about-subtitle">About section</p>

              <h2 class="about-title">LOL <strong>Strategy</strong> Sharing </h2>

              <p class="about-text">
                Get familiar with top international LOL Esport team strategies and also get to know what a day in a life as a Esport coach looks like!
              </p>

              <p class="about-bottom-text">
                <ion-icon name="arrow-forward-circle-outline"></ion-icon>

                <span>Will familiar with LOL esport strategy and get to know a day in a life as an esport coach</span><br>
              </p>

            </div>

          </div>
        </section>

        <!-- 
          - #GALLERY
        -->
        
        <section class="gallery">
          <div class="container">

            <ul class="gallery-list has-scrollbar">

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/event1/gallery-img-1.jpg" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/event1/gallery-img-2.jpg" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/event1/gallery-img-3.jpg" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/event1/gallery-img-4.jpg" alt="Gallery image">
                </figure>
              </li>

            </ul>

          </div>
        </section>
        




        <!-- 
          - #TEAM (Speakers)
        -->

        <section class="speaker" id="speaker">
          <div class="container">

            <h2 class="h2 section-title">Our Speakers</h2>

            <ul class="speaker-list">

              <li>
                <a href="#" class="speaker-member">
                  <figure>
                    <img src="../assets/images/event1/speaker-member-1.png" alt="Speaker image">
                  </figure>

                  <ion-icon name="link-outline"></ion-icon>
                </a>
              </li>

              <li>
                <a href="#" class="speaker-member">
                  <figure>
                    <img src="../assets/images/event1/speaker-member-2.png" alt="Speaker image">
                  </figure>

                  <ion-icon name="link-outline"></ion-icon>
                </a>
              </li>

              <li>
                <a href="#" class="speaker-member">
                  <figure>
                    <img src="../assets/images/event1/speaker-member-3.png" alt="Speaker image">
                  </figure>

                  <ion-icon name="link-outline"></ion-icon>
                </a>
              </li>

              <li>
                <a href="#" class="speaker-member">
                  <figure>
                    <img src="../assets/images/event1/speaker-member-4.png" alt="Speaker image">
                  </figure>

                  <ion-icon name="link-outline"></ion-icon>
                </a>
              </li>

            </ul>
            <!--
            <button class="btn btn-primary">view all members</button>
            -->
          </div>
        </section>



       

        <!-- 
          - #TICKETS
        -->

        <section class="tickets" id="tickets">
          <div class="container">

            <h2 class="h2 section-title">tickets</h2>

            <ul class="tickets-list">
             <?php
            require_once ('../source/mysqli_connect.php');
            // SQL statement for number of seat
            $q = "SELECT EventName, bronzeSeat, silverSeat, goldSeat FROM villain WHERE EventID = 2;";
            $r = mysqli_query ($dbc, $q);// Run the query.
            $seatArr = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $bronzeSeat = $seatArr["bronzeSeat"];
            $silverSeat = $seatArr["silverSeat"];
            $goldSeat = $seatArr["goldSeat"];
            $eventName = $seatArr["EventName"];
            
            // SQL statement for price
            $q = "SELECT goldprice, silverprice, bronzeprice FROM schedule WHERE EventID = 2;";
            $k = mysqli_query ($dbc, $q); // Run the query.
            $priceArr = mysqli_fetch_array($k, MYSQLI_ASSOC);
            $bronzePrice = $priceArr["bronzeprice"];
            $silverPrice = $priceArr["silverprice"];
            $goldPrice = $priceArr["goldprice"];
            
            //Closing the statement
            mysqli_free_result($r);
            echo <<< EOT
              <li>
                <div class="tickets-card">

                  <div class="card-banner">

                    <a href="#">
                      <img src="../assets/images/silverTicket.png" alt="silverTicket">
                    </a>

                    <button class="share">
                      <ion-icon name="share-social"></ion-icon>
                    </button>

                    <div class="card-time-wrapper">
                      <ion-icon name="time-outline"></ion-icon>

                      <span>In 4 days</span>
                    </div>

                  </div>
            EOT;
            echo '
                  <div class="card-content">

                    <div class="card-title-wrapper">

                      <h3 class="h3 card-title">Silver</h3>

                      <p class="card-subtitle">e-sports</p>

                    </div>

                    <div class="card-prize">$'.$silverPrice.'</div>

                  </div>';
            echo '
                  <div class="card-actions">
                    <input type="hidden" name="event_name" id="event_name" value="LOL" >
                    <input type="hidden" name="quantity" id="quantity" value="1" >
                    <button class="btn btn-primary" onclick="confirmAddToCart(\''.$eventName.'\',\'silver\','.$silverPrice.');" name="silver_ticket" id="silver_ticket">
                      <ion-icon name="add-outline"></ion-icon>

                      <span>Add to cart</span>
                    </button>

                    <button class="btn card-btn btn-disabled">
                      <span>Left: '.$silverSeat.'
                        
                      </span>
                    </button>

                  </div>

                </div>
              </li>';
            echo <<< EOT
              <li>
                <div class="tickets-card">

                  <div class="card-banner">

                    <a href="#">
                      <img src="../assets/images/goldenTicket.png" alt="goldenTicket">
                    </a>

                    <button class="share">
                      <ion-icon name="share-social"></ion-icon>
                    </button>

                    <div class="card-time-wrapper">
                      <ion-icon name="time-outline"></ion-icon>

                      <span>In 4 days</span>
                    </div>

                  </div>
            EOT;
            echo '        
                  <div class="card-content">

                    <div class="card-title-wrapper">

                      <h3 class="h3 card-title">Gold</h3>

                      <p class="card-subtitle">e-sports</p>

                    </div>

                    <div class="card-prize">$'.$goldPrice.'</div>

                  </div>';
            echo '
                  <div class="card-actions">
                    <input type="hidden" name="event_name" id="event_name" value="LOL" >
                    <input type="hidden" name="quantity" id="quantity" value="1" >
                    <button class="btn btn-primary" onclick="confirmAddToCart(\''.$eventName.'\',\'gold\','.$goldPrice.');" name="gold_ticket" id="gold_ticket">
                      <ion-icon name="add-outline"></ion-icon>

                      <span>Add to cart</span>
                    </button>
                    <button class="btn card-btn btn-disabled">
                        <span>Left: '.$goldSeat.'
                        </span>
                    </button>

                  </div>

                </div>
              </li>';
            echo <<< EOT
              <li>
                <div class="tickets-card">

                  <div class="card-banner">

                    <a href="#">
                      <img src="../assets/images/bronzeTicket.png" alt="bronzeTicket">
                    </a>

                    <button class="share">
                      <ion-icon name="share-social"></ion-icon>
                    </button>

                    <div class="card-time-wrapper">
                      <ion-icon name="time-outline"></ion-icon>

                      <span>In 4 days</span>
                    </div>

                  </div>
            EOT;
            echo '
                  <div class="card-content">

                    <div class="card-title-wrapper">

                      <h3 class="h3 card-title">Bronze</h3>

                      <p class="card-subtitle">e-sports</p>

                    </div>

                    <div class="card-prize">$'.$bronzePrice.'</div>

                  </div>
                  
               
                  <div class="card-actions">
                    <input type="hidden" name="event_name" id="event_name" value="LOL" >
                    <input type="hidden" name="quantity" id="quantity" value="1" >
                    <button class="btn btn-primary" onclick="confirmAddToCart(\''.$eventName.'\',\'bronze\','.$bronzePrice.');" name="bronze_ticket" id="bronze_ticket">
                      <ion-icon name="add-outline"></ion-icon>
                      <span>Add to cart</span>
                    </button>
                    <button class="btn card-btn btn-disabled">
                        <span>Left: '.$bronzeSeat.'
                        </span>
                    </button>
                  </div>

                </div>
              </li>';
              ?>
            </ul>

          </div>
        </section>

<?php include("../source/footer.php");?>

  <!-- 
    - #GO TO TOP
  -->

  <a href="#top" class="btn btn-primary go-top" data-go-top>
    <ion-icon name="chevron-up-outline"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="../assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>