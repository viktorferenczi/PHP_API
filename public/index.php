<?php
// Serve as our front controller and process the requests
require "../bootstrap.php";
use Src\Controller\ContactController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /contacts
// everything else results in a 404 Not Found
if ($uri[1] !== 'contacts') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// the contact id is, of course, optional and must be a number:
$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and user ID to the ContactController and process the HTTP request:
$controller = new ContactController($dbConnection, $requestMethod, $userId);
$controller->processRequest();