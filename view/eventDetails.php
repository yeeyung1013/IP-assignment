<?php
 $pageTitle = "Events Details";

include 'source/header.php';
include 'source/mysqli_connect.php';
include '../assets/api/QRCode.php';

if (isset($_GET['id'])) {
  $eventId = trim($_GET['id']);

  $selectCommand = "SELECT * FROM villain WHERE EventID = '$eventId'";
  $result = mysqli_query($dbc, $selectCommand);

  if ($result->num_rows == 1) {
    $villain = mysqli_fetch_object($result);

    $eventId = htmlspecialchars($villain->EventID);
    $eventName = htmlspecialchars($villain->EventName);
    $description = htmlspecialchars($villain->Description);
    $startDate = htmlspecialchars($villain->StartDate);
    $seat = htmlspecialchars($villain->Seat);
    $location = htmlspecialchars($villain->location);
  }
}
?>
<style>
    .ticket-details {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
    }

    .ticket-details th, .ticket-details td {
        padding: 15px;
        border-bottom: 1px solid #ddd;
    }

    .ticket-category {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .ticket-category small {
        display: block;
        color: #777;
    }

    .ticket-price .old-price {
        text-decoration: line-through;
        color: red;
        margin-right: 5px;
    }

    .ticket-price .current-price {
        font-size: 20px;
        color: #e91e63;
        font-weight: bold;
    }

    .ticket-price .promo {
        font-size: 12px;
        color: #555;
    }

    .select-quantity {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-right: 10px; /* Spacing between select and button */
        font-size: 1em;
        width: 100px; /* Set a fixed width */
        cursor: pointer; /* Pointer on hover */
    }

    .pay-button {
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
    }

    .pay-button:hover {
        background-color: #218838;
    }

    .review-button {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
        text-align: center;
    }

    .review-button:hover {
        background-color: #0056b3;
    }
</style>
<main>
  <article>
  <section id="hero" style="background: url('../assets/images/event/<?= htmlspecialchars($eventId) ?>/hero-banner.png') no-repeat; background-size: cover; background-position: top center; margin-top: 90px; padding: var(--section-padding) 0; height: 100vh; max-height: 1000px; display: flex; justify-content: center; align-items: center; text-align: center;">

            <div class="container">

          <p class="hero-subtitle"><?php global $eventName; echo $eventName;?></p>

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

       <!-- 
          - #About us
        -->
      <div class="section-wrapper">

        <section class="about" id="about">
          <div class="container">

            <figure class="about-banner">

              <img src="../assets/images/event/<?= $eventId ?>/about-img.jpg" alt="about-img" class="about-img">

            </figure>

            <div class="about-content">

              <p class="about-subtitle">About section</p>

              <h2 class="about-title" style="font-size:33px">
               <?php global $eventName; echo $eventName; ?><strong> Strategy</strong> Sharing
              </h2>


              <p class="about-text">
                Get familiar with top international Esport team strategies and also get to know what a day in a life as a Esport coach looks like!
              </p>
            </div>

          </div>
        </section>

        <!-- 
          - #Description
        -->
        <section class="description" id="description">
        <div class="container">
        <h2 class="h2 section-title">Description</h2>
        <div style="background-color: #333; padding: 20px; width: 100%; min-height: 200px; box-sizing: border-box;">
            <p class="about-subtitle">Location</p>
            <h2 class="about-title" style="font-size:33px; color:whitesmoke;">
                <?= htmlspecialchars($location); ?>
            </h2>
            <div id="map" style="height: 400px; width: 100%;"></div>

            <script>
                function initMap() {
                    var geocoder = new google.maps.Geocoder();
                    var address = "<?php echo htmlspecialchars($location); ?>";
                    var map, bounds;

                    map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 10, 
                        center: { lat: 0, lng: 0 }
                    });

                    bounds = new google.maps.LatLngBounds();

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var userLocation = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };
                            var userIcon = {
                                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png" 
                            };

                            var userMarker = new google.maps.Marker({
                                position: userLocation,
                                map: map,
                                icon: userIcon,
                                title: 'Your Current Location'
                            });

                            bounds.extend(userLocation);

                            google.maps.event.addListener(userMarker, 'click', function() {
                                var googleMapsUrl = `https://www.google.com/maps?q=${userLocation.lat},${userLocation.lng}`;
                                window.open(googleMapsUrl, '_blank');
                            });

                            map.fitBounds(bounds);

                        }, function(error) {
                            console.error('Error getting location: ', error.message);
                        });
                    } else {
                        console.error("Geolocation is not supported by this browser.");
                    }

                    geocoder.geocode({ 'address': address }, function(results, status) {
                        if (status === 'OK') {
                            var eventLocation = results[0].geometry.location;

                            var eventMarker = new google.maps.Marker({
                                position: eventLocation,
                                map: map,
                                title: address
                            });

                            bounds.extend(eventLocation);

                            google.maps.event.addListener(eventMarker, 'click', function() {
                                var googleMapsUrl = `https://www.google.com/maps?q=${eventLocation.lat()},${eventLocation.lng()}`;
                                window.open(googleMapsUrl, '_blank');
                            });

                            map.fitBounds(bounds);

                        } else {
                            console.error('Geocode was not successful for the following reason: ' + status);
                        }
                    });
                }
            </script>
            <script async defer 
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmlikrs0EID8G22T7l2kqCgxZl7YvGQGs&callback=initMap">
            </script>

                    <p class="about-text">
                        <?= htmlspecialchars($description); ?>
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
                  <img src="../assets/images/event/<?= $eventId ?>/gallery-img-1.jpg" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/event/<?= $eventId ?>/gallery-img-2.jpg" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/event/<?= $eventId ?>/gallery-img-3.jpg" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/event/<?= $eventId ?>/gallery-img-4.jpg" alt="Gallery image">
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
                    <img src="../assets/images/event/<?= $eventId ?>/speaker-member-1.png" alt="Speaker image">
                  </figure>

                  <ion-icon name="link-outline"></ion-icon>
                </a>
              </li>

              <li>
                <a href="#" class="speaker-member">
                  <figure>
                    <img src="../assets/images/event/<?= $eventId ?>/speaker-member-2.png" alt="Speaker image">
                  </figure>

                  <ion-icon name="link-outline"></ion-icon>
                </a>
              </li>

              <li>
                <a href="#" class="speaker-member">
                  <figure>
                    <img src="../assets/images/event/<?= $eventId ?>/speaker-member-3.png" alt="Speaker image">
                  </figure>

                  <ion-icon name="link-outline"></ion-icon>
                </a>
              </li>
            </ul>
          </div>
        </section>

        <!-- 
          - #TICKETS
        -->
        <?php
            if (isset($_GET['id'])) {
                $eventId = trim($_GET['id']);

                $scheduleQuery = "SELECT schedule_id, startDate, endDate FROM schedule WHERE EventID = '$eventId'";
                $scheduleResult = mysqli_query($dbc, $scheduleQuery);

                if ($scheduleResult && mysqli_num_rows($scheduleResult) == 1) {
                    $schedule = mysqli_fetch_object($scheduleResult);
                    $scheduleId = $schedule->schedule_id;
                    $startDate = new DateTime($schedule->startDate);
                    $endDate = new DateTime($schedule->endDate);
                    $currentDate = new DateTime();

                    if ($currentDate < $startDate) {
                        $timeDiff = $startDate->getTimestamp() - $currentDate->getTimestamp();
                        $message = "Event will start in: <span id='countdown'></span>";
                        $countdown = true;
                    } elseif ($currentDate > $endDate) {
                        $message = "The event has ended.";
                        $countdown = false;
                    } else {
                        $message = "";
                        $countdown = false;

                        $ticketQuery = "SELECT * FROM ticket WHERE schedule_id = '$scheduleId'";
                        $ticketResult = mysqli_query($dbc, $ticketQuery);
                    }
                } else {
                    $message = "Event schedule not found.";
                    $countdown = false;
                }
            } else {
                $message = "No event ID provided.";
                $countdown = false;
            }
            ?>

            <section class="tickets" id="tickets">
                <div class="container">
                    <h2 class="h2 section-title">Tickets</h2>

                        <?php if ($message): ?>
                        <div class="message" style="font-size: 20px; font-weight: bold; text-align: center; margin: 20px 0;">
                        <?php echo $message; ?>
                        </div>
                    <?php endif; ?>

<?php if ($countdown): ?>
                        <script>

                            var countDownDate = new Date(<?php echo json_encode($startDate->format('Y-m-d H:i:s')); ?>).getTime();
                            var countdownElement = document.getElementById("countdown");

                            var x = setInterval(function () {
                                var now = new Date().getTime();
                                var distance = countDownDate - now;

                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                countdownElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                                if (distance < 0) {
                                    clearInterval(x);
                                    countdownElement.innerHTML = "Event is starting now!";
                                }
                            }, 1000);
                        </script>
<?php elseif (isset($ticketResult) && mysqli_num_rows($ticketResult) > 0): ?>
                        <table class="ticket-details">
                            <thead>
                                <tr>
                                    <th style="color: white;">Ticket ID</th>
                                    <th style="color: white;">Category</th>
                                    <th style="color: white;">Price</th>
                                    <th style="color: white;">Image</th>
                                    <th style="color: white;">Slot</th>
                                    <th style="color: white;">Buy</th>
                                </tr>
                            </thead>
                            <tbody>
                            <form action="../SecurePractice/accessControl.php?action=pay" method="POST">
                                        <?php while ($ticket = mysqli_fetch_assoc($ticketResult)): ?>
                                    <tr>
                                        <td><?php $qrcode = new QRCode();
                                            $qrcode->generateQRCode($ticket['ticket_id']);
                                            ?></td>
                                        <td>
                                            <div class="ticket-category">
                                                <strong><?= htmlspecialchars($ticket['category']); ?></strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="ticket-price">

                                                <span class="current-price">MYR <?= htmlspecialchars($ticket['price']); ?></span>
                                            </div>
                                        </td>
                                        <td>

                                            <img src="http://localhost/villain/assets/images/<?= htmlspecialchars($ticket['image']); ?>" alt="Ticket Image" style="width: 50px; height: 50px;">
                                        </td>
                                        <td><?php $remainingSlots = $ticket['slot'] - $ticket['slot_sold']; ?><?= htmlspecialchars($remainingSlots); ?></td>
                                        <td>
                                            <select name="selected_option[<?= $ticket['ticket_id']; ?>]" id="quantity_<?= $ticket['ticket_id']; ?>" class="select-quantity" required>
                                                <option value="0">0</option>
                                                <?php
                                                $maxSelectable = min($remainingSlots, 5);
                                                for ($i = 1; $i <= $maxSelectable; $i++):
                                                    ?>
                                                    <option value="<?= $i; ?>"><?= $i; ?></option>
        <?php endfor; ?>
                                            </select>
                                        </td>
                                    </tr>
    <?php endwhile; ?>
                                <tr>
                                    <td colspan="4">
                                        <button type="submit" class="pay-button">Pay</button>
                                    </td>
                                </tr>
                            </form>
                            </tbody>
                        </table>
            <?php endif; ?>
                </div>
            </section>

<?php include("source/footer.php");?>

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