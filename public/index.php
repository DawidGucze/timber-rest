<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

// return all records
// GET /person

// return a specific record
// GET /person/{id}

// create a new record
// POST /person

// update an existing record
// PUT /person/{id}

// delete an existing record
// DELETE /person/{id}

require "../bootstrap.php";
use Src\Controller\PersonController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of endpoints start with /person
// everything else results in a 404 Not Found
if ($uri[4] !== 'person') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// user id is optional and must be a number
$userId = null;
$userName = null;
if (isset($uri[5])) {
    $type = is_numeric($uri[5]);
    if($type){
        $userId = (int) $uri[5];
    } else {
        $userName = $uri[5];
    }
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

// process the request
$controller = new PersonController($dbConnection, $requestMethod, $userId, $userName);
$controller->processRequest();