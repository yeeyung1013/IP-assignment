<?php
// google_oauth.php
require_once __DIR__ . '../../../vendor/autoload.php'; // Google API client
session_start();

$client = new Google_Client();
$client->setClientId('626947002977-a39grn2osuhqtvpt9lsnt8tf4s1jdl6g.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/villain/view/source/callback.php');
$client->addScope('email');
$client->addScope('profile');

// Redirect user to Google's OAuth page
$auth_url = $client->createAuthUrl();
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
exit;
?>
