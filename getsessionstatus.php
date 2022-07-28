<?php
session_start(); // create PHPSESSID cookies on the client side
require_once "crudOOP.php";
$myDb = new Db('php://input');
$data = $myDb->read();

if ($data['accessStatus'] === 'makingAccessToDbConfigPHPFile') // to open access
    $_SESSION["step2"] = "-k72gpm31g+?edm`8,pfw"; // 
if ($data['accessStatus'] === 'closingAccessToDbConfigPHPFile') // to close access
    unset($_SESSION["step2"]);
if ($data['accessStatus'] === 'logout')
    if (isset($_SESSION["name"]) && !empty($_SESSION["name"]))
        unset($_SESSION["name"]);
$myDb->setSource('php://output');
if (isset($_SESSION["name"]) && !empty($_SESSION["name"])) // the session status checking when the user navigates between the pages of the website
    $myDb->create(["message" => $_SESSION["name"]] ); // send result to browser
else $myDb->create(["message" => "no_session"] ); // send result to browser