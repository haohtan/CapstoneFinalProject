<?php
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('40069760996-m7meg75slq4mhd9kd5hc4lklva6fq2co.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('8FECh4FJ0nQtaJmSni6eE6fX');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://cgi.luddy.indiana.edu/~team41/team-41/relocate.php');

//
$google_client->addScope('email');

$google_client->addScope('profile');

//start session on web page

?>
