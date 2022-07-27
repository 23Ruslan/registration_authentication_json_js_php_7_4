<?php
session_start(); // create PHPSESSID cookies on the client side
//echo date('h:i:s')."\n";sleep(5);echo date('h:i:s')."\n"; // testing that the button is blocked for the duration of the server response
require_once "crudOOP.php"; // securityOOP.php is also included in crudOOP.php
$myDb = new Db('php://input');
$data = $myDb->read();
$myDb = new Db('database.json');
$alldata = $myDb->read();
$data['login'] = $myDb->cleardata($data['login']);
$data['password'] = $myDb->hash($data);
if (!$myDb->isFieldUnique($data, 'login'))
{ // searching for the same login
    $loginmsg = 'this login is already used, use another one';
}
elseif (!$myDb->isFieldUnique($data, 'email'))
{ // searching for the same email
    $emailmsg = 'this email is already used, use another one';
}
else
{
    $myDb->update($data);
}
$myDb = new Db('php://output');
$myDb->create(["loginmsg" => $loginmsg ?? '', "emailmsg" => $emailmsg ?? '']); // send result to browser