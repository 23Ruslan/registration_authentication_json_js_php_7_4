<?php
session_start(); // create PHPSESSID cookies on the client side
$_SESSION['step2'] = time(); // access to php db config files (login.php/registration.php) is available only to browsers where the button is pressed for 2 seconds (view js file)
if (isset($_SESSION["name"]) && !empty($_SESSION["name"])) // but here is just the session status checking when the user navigates between the pages of the website
file_put_contents('php://output', json_encode(["msg" => $_SESSION["name"]]));
else file_put_contents('php://output', json_encode(["msg" => "no_session"]));