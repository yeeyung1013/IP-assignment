<?php
/**
 *
 * @author Tan Chee Fung
 */
$eventName = $_GET['eventName'];
$standardTickets = $_GET['standardTickets'];
$vipTickets = $_GET['vipTickets'];
$vvipTickets = $_GET['vvipTickets'];
$superVipTickets = $_GET['superVipTickets'];
$freeTickets = $_GET['freeTickets']; 
$totalTickets = $standardTickets + $vipTickets + $vvipTickets + $superVipTickets + $freeTickets;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($eventName); ?> Ticket Distribution</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f0f4f8, #e0e7ff);
            margin: 0;
            padding: 20px;
            color: #333;
            text-align: center;
        }
        h1 {
            color: #4a4e69;
            margin-bottom: 30px;
            font-size: 2.5em;
        }
        .chart-container {
            width: 80%;
            height: 300px; /* Adjusted height */
            margin: 0 auto;
        }
        .button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #4a4e69;
            color: white;
            cursor: pointer;
            margin: 20px 5px;
            transition: background-color 0.3s, transform 0.2s;
            font-size: 1em;
        }
        .button:hover {
            background-color: #22223b;
            transform: translateY(-2px);
        }
        .no-tickets {
            font-size: 1.5em;
            color: #e63946; /* Red color for no tickets message */
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($eventName); ?> Ticket Distribution</h1>

    <?php if ($totalTickets > 0): ?>
        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
    <?php else: ?>
        <p class="no-tickets">No tickets available for this event.</p>
    <?php endif; ?>

    <div>
        <button class="button" onclick="window.history.back();">Back</button>
    </div>

    <script>
        var totalTickets = <?php echo $totalTickets; ?>;
        if (totalTickets > 0) {
            var ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Standard', 'VIP', 'VVIP', 'Super VIP', 'Free'],
                    datasets: [{
                        label: 'Ticket Distribution',
                        data: [<?php echo $standardTickets; ?>, <?php echo $vipTickets; ?>, <?php echo $vvipTickets; ?>, <?php echo $superVipTickets; ?>, <?php echo $freeTickets; ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)' // Color for free tickets
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)' // Color for free tickets
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Ticket Distribution for <?php echo htmlspecialchars($eventName); ?>'
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>