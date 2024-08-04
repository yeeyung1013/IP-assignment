<html>
    <head>
        <style>
            /* Style inputs with type="text", select elements and textareas */
            input[type=text], select, textarea, input[type=email], input[type=number] {
              width: 100%; /* Full width */
              padding: 12px; /* Some padding */ 
              border: 1px solid #ccc; /* Gray border */
              border-radius: 4px; /* Rounded borders */
              box-sizing: border-box; /* Make sure that padding and width stays in place */
              margin-top: 6px; /* Add a top margin */
              margin-bottom: 16px; /* Bottom margin */
              resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
            }

            /* Style the submit button with a specific background color etc */
            input[type=submit] {
              background-color: black;
              color: hsl(181.76, 100%, 80%);
              padding: 12px 20px;
              border: none;
              border-radius: 4px;
              cursor: pointer;
            }

            /* When moving the mouse over the submit button, add a darker green color */
            input[type=submit]:hover {
              background-color: hsl(181.76, 100%, 80%);
              color: black;
            }

            /* Add a background color and some padding around the form */
            .container {
              border-radius: 5px;
              background-color: #f2f2f2;
              padding: 20px;
              margin: 60px 60px 60px 60px;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            $(document).ready(function(){
               $('#deleteForm').submit(function(){
                   alert("Once your request to cancel or refund your ticket has been approved, a member of our staff will get in touch with you. ");
               }); 
            });
       </script>
        <meta charset="UTF-8">
        <title>Delete Booking Form</title>
    </head>
    <body style="background: black">
        <div class="container">
            <form id="deleteForm" method="POST" action="../bevent.php">

            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" placeholder="Your full name.." required>
            
            <label for="email">Email</label><br/>
            <input type="email" id="email" name="email" placeholder="Your email.." required>
            
            <label for="eventName">Event Name</label>
            <select id="eventName" name="eventName">
                <?php
                require_once ('mysqli_connect.php');
                $q = "SELECT EventName FROM villain;";
                $r = mysqli_query ($dbc, $q);// Run the query.
                $events = mysqli_fetch_all($r, MYSQLI_ASSOC);
           
                foreach ($events as $event) {
                         echo $event["EventName"];
                    echo '<option value="'.$event["EventName"].'">'.$event["EventName"].'</option>';
                }
                ?>
            </select>
            
            <label for="ticketType">Ticket Type</label>
            <select id="ticketType" name="ticketType">
              <option value="gold">Gold</option>
              <option value="silver">Silver</option>
              <option value="bronze">Bronze</option>
            </select>
            
            <label for="quantity">Ticket Quantity</label>
            <input type="number" id="quantity" name="quantity" placeholder="Ticket Quantity to be refunded.." required>

            <label for="subject">Subject</label>
            <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>

            <input type="submit" value="Submit">

          </form>
        </div>
    </body>
</html>
