<?php

session_start(); // create PHPSESSID cookies on the client side
//echo date('h:i:s')."\n";sleep(5);echo date('h:i:s')."\n"; // testing that the button is blocked for the duration of the server response
require_once "crudOOP.php";
(new Safe())->accessControl(); // at first we check if it is safe to open access to this db config php file

$myDb = new Db("php://input");
$data = $myDb->read();
$myDb->setSource("database.json");
$alldata = $myDb->read();
$data["login"] = $myDb->cleardata($data["login"]);
$data["password"] = $myDb->hash($data);

if (!$myDb->isFieldUnique($data, "login")) {
    // searching for the same login
    $loginMessage = "this login is already used, use another one";
} elseif (!$myDb->isFieldUnique($data, "email")) {
    // searching for the same email
    $emailMessage = "this email is already used, use another one";
} else {
    $myDb->update($data);
}

$myDb->setSource("php://output");
$myDb->create([
    "loginMessage" => $loginMessage ?? "",
    "emailMessage" => $emailMessage ?? "",
]); // send result to browser