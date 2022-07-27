<?php
session_start(); // create PHPSESSID cookies on the client side
//echo date('h:i:s')."\n";sleep(5);echo date('h:i:s')."\n"; // testing that the button is blocked for the duration of the server response
require_once "crudOOP.php"; // securityOOP.php is also included in crudOOP.php
$myDb = new Db('php://input');
$data = $myDb->read();
$myDb = new Db('database.json');
$alldata = $myDb->read();
$loginkey = $myDb->loginKey($data);
if (!is_int($loginkey))
 // php function array_search will return the key number if an element is found, and FALSE if it doesn't find it
    $loginmsg = 'this login is not registered';
elseif ($myDb->isHash($loginkey, $data))
    $_SESSION['name'] = $alldata[$loginkey]['name'];
else
    $passwordmsg = 'wrong password';
$myDb = new Db('php://output');
$myDb->create(["loginmsg" => $loginmsg ?? '', "passwordmsg" => $passwordmsg ?? '']); // send result to browser

