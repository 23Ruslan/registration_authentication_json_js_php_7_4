<?php
session_start(); // create PHPSESSID cookies on the client side
if(isset($_SESSION["name"]) && !empty($_SESSION["name"]))
    unset($_SESSION["name"]);
file_put_contents('php://output', json_encode(["msg"=> "no_session"]));