
<?php
//<!--SIASHUNFU-->
function ReviewXMLreport($filename, $redirectUrl) {
    require_once 'conn.php';
    $doc = new DOMDocument('1.0', 'UTF-8');
    $doc->formatOutput = true;
    $root = $doc->createElement('Reviews');
    $doc->appendChild($root);

    $results = mysqli_query($conn, "SELECT * FROM review_table");

    while ($row = mysqli_fetch_array($results)) {
        $review = $doc->createElement('Review');
        $root->appendChild($review);

        $review->appendChild($doc->createElement('ID', htmlspecialchars($row['id'])));
        $review->appendChild($doc->createElement('UserName', htmlspecialchars($row['user_name'])));
        $review->appendChild($doc->createElement('UserReview', htmlspecialchars($row['user_review'])));
        $review->appendChild($doc->createElement('UserRating', htmlspecialchars($row['user_rating'])));
        $review->appendChild($doc->createElement('UserImage', htmlspecialchars($row['user_image'])));
        $review->appendChild($doc->createElement('DateTime', htmlspecialchars($row['datetime'])));
        $review->appendChild($doc->createElement('Status', htmlspecialchars($row['status'])));
        $review->appendChild($doc->createElement('ArchivedAt', htmlspecialchars($row['archived_at'])));
        $review->appendChild($doc->createElement('AdminReply', htmlspecialchars($row['admin_reply'])));
        $review->appendChild($doc->createElement('ReplyDateTime', htmlspecialchars($row['reply_datetime'])));
    }

    $doc->save($filename);

    header('Location: ' . $redirectUrl);
    exit();
}

$filename = '../../assets/report/reviews.xml';
$redirectUrl = 'http://localhost/villain/view/admin/adminReview.php';
ReviewXMLreport($filename, $redirectUrl);
?>
