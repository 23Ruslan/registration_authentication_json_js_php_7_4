<?php
session_start(); // create PHPSESSID cookies on the client side
//echo date('h:i:s')."\n";sleep(5);echo date('h:i:s')."\n"; // testing that the button is blocked for the duration of the server response
require_once "crudOOP.php"; // securityOOP.php is also included in crudOOP.php
Db::$jsonFile = 'php://input';
$data = Db::read();
Db::$jsonFile = 'database.json';
$alldata = Db::read();
$data['login'] = Safe::cleardata($data['login']);
$data['password'] = Safe::hash($data);
if (!Db::isFieldUnique($data, 'login'))
{ // searching for the same login
    $loginmsg = 'this login is already used, use another one';
}
elseif (!Db::isFieldUnique($data, 'email'))
{ // searching for the same email
    $emailmsg = 'this email is already used, use another one';
}
else
{
    Db::update($data);
}
Db::$jsonFile = 'php://output';
Db::create(["loginmsg" => $loginmsg ?? '', "emailmsg" => $emailmsg ?? '']); // send result to browser
