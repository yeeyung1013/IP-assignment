<?php
/**
 *
 * @author Tan Chee Fung
 */
$dsn = 'mysql:host=localhost;dbname=villain;charset=utf8mb4';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $searchQuery = isset($_POST['search']) ? trim($_POST['search']) : '';

    if (isset($_POST['refresh'])) {
        $searchQuery = '';
    }

    $sql = "SELECT
                v.EventName,
                v.Seat AS TotalSeats,
                COALESCE(SUM(CASE WHEN t.category = 'Standard' THEN t.slot ELSE 0 END), 0) AS StandardTickets,
                COALESCE(SUM(CASE WHEN t.category = 'VIP' THEN t.slot ELSE 0 END), 0) AS VIPTickets,
                COALESCE(SUM(CASE WHEN t.category = 'VVIP' THEN t.slot ELSE 0 END), 0) AS VVIPTickets,
                COALESCE(SUM(CASE WHEN t.category = 'SuperVIP' THEN t.slot ELSE 0 END), 0) AS SuperVIPTickets,
                COALESCE(SUM(CASE WHEN t.category = 'Standard' THEN t.slot * t.price ELSE 0 END), 0) AS TotalStandardPrice,
                COALESCE(SUM(CASE WHEN t.category = 'VIP' THEN t.slot * t.price ELSE 0 END), 0) AS TotalVIPPrice,
                COALESCE(SUM(CASE WHEN t.category = 'VVIP' THEN t.slot * t.price ELSE 0 END), 0) AS TotalVVIPPrice,
                COALESCE(SUM(CASE WHEN t.category = 'SuperVIP' THEN t.slot * t.price ELSE 0 END), 0) AS TotalSuperVIPPrice,
                COALESCE(SUM(CASE WHEN t.category = 'Standard' THEN t.slot * t.price ELSE 0 END), 0) +
                COALESCE(SUM(CASE WHEN t.category = 'VIP' THEN t.slot * t.price ELSE 0 END), 0) +
                COALESCE(SUM(CASE WHEN t.category = 'VVIP' THEN t.slot * t.price ELSE 0 END), 0) +
                COALESCE(SUM(CASE WHEN t.category = 'SuperVIP' THEN t.slot * t.price ELSE 0 END), 0) AS TotalRevenue,
                v.Seat - COALESCE(SUM(CASE WHEN t.category = 'Standard' THEN t.slot ELSE 0 END), 0) 
                  - COALESCE(SUM(CASE WHEN t.category = 'VIP' THEN t.slot ELSE 0 END), 0)
                  - COALESCE(SUM(CASE WHEN t.category = 'VVIP' THEN t.slot ELSE 0 END), 0)
                  - COALESCE(SUM(CASE WHEN t.category = 'SuperVIP' THEN t.slot ELSE 0 END), 0) AS FreeSeats
            FROM
                villain v
            LEFT JOIN
                schedule s ON v.EventID = s.EventID
            LEFT JOIN
                ticket t ON s.schedule_id = t.schedule_id
            WHERE
                v.EventName LIKE :searchQuery
            GROUP BY
                v.EventID
            ORDER BY
                v.EventID;";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['searchQuery' => '%' . $searchQuery . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $noResults = empty($results);
    $xml = new SimpleXMLElement('<EventTicketDistribution/>');

    foreach ($results as $row) {
        $event = $xml->addChild('Event');
        $event->addChild('EventName', htmlspecialchars($row['EventName']));
        $event->addChild('TotalSeats', $row['TotalSeats']);
        $event->addChild('StandardTickets', $row['StandardTickets']);
        $event->addChild('VIPTickets', $row['VIPTickets']);
        $event->addChild('VVIPTickets', $row['VVIPTickets']);
        $event->addChild('SuperVIPTickets', $row['SuperVIPTickets']);
        $event->addChild('TotalStandardPrice', $row['TotalStandardPrice']);
        $event->addChild('TotalVIPPrice', $row['TotalVIPPrice']);
        $event->addChild('TotalVVIPPrice', $row['TotalVVIPPrice']);
        $event->addChild('TotalSuperVIPPrice', $row['TotalSuperVIPPrice']);
        $event->addChild('TotalRevenue', $row['TotalRevenue']);
        $event->addChild('FreeSeats', $row['FreeSeats']);
    }

    $xmlString = $xml->asXML();
    file_put_contents('event_ticket_distribution.xml', $xmlString);

    $xmlDoc = new DOMDocument;
    if (!$xmlDoc->load('event_ticket_distribution.xml')) {
        throw new Exception('Failed to load XML file.');
    }

    $xslDoc = new DOMDocument;
    if (!$xslDoc->load('ticketReport.xsl')) {
        throw new Exception('Failed to load XSL file.');
    }

    $proc = new XSLTProcessor;
    $proc->importStylesheet($xslDoc);
    $proc->setParameter('', 'noResults', $noResults ? 'true' : 'false');
    $proc->setParameter('', 'searchQuery', htmlspecialchars($searchQuery));
    echo $proc->transformToXML($xmlDoc);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>