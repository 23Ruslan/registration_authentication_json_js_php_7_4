<?php

session_start(); // create PHPSESSID cookies on the client side
//echo date('h:i:s')."\n";sleep(5);echo date('h:i:s')."\n"; // testing that the button is blocked for the duration of the server response
require_once "crudOOP.php";
(new Safe())->accessControl(); // at first we check if it is safe to open access to this db config php file

$myDb = new Db("php://input");
$data = $myDb->read();
$myDb->setSource("database.json");
$alldata = $myDb->read();
$loginkey = $myDb->loginKey($data);

if (!is_int($loginkey)) {
    // php function array_search will return the key number if an element is found, and FALSE if it doesn't find it
    $loginMessage = "this login is not registered";
} elseif ($myDb->isHash($loginkey, $data)) {
    $_SESSION["name"] = $alldata[$loginkey]["name"];
} else {
    $passwordMessage = "wrong password";
}

$myDb->setSource("php://output");
$myDb->create([
    "loginMessage" => $loginMessage ?? "",
    "passwordMessage" => $passwordMessage ?? "",
]); // send result to browser