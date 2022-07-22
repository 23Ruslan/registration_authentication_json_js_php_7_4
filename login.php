<?php 
set_error_handler('err_handler');
function err_handler($errno, $errmsg, $filename, $linenum) {
$date = date('Y-m-d H:i:s (T)');
$f = fopen('errors.txt', 'a');
if (!empty($f)) {
$filename  =str_replace($_SERVER['DOCUMENT_ROOT'],'',$filename);
$err  = "$errmsg = $filename = $linenum\r\n";
fwrite($f, $err);
fclose($f);
}
}
require_once "cleardata.php";
//echo date('h:i:s')."\n";sleep(5);echo date('h:i:s')."\n"; // testing that the button is blocked for the duration of the server response
// reading a file and writing it to a string, converting string to associative array:
$alldata = json_decode( file_get_contents('database.json'), true ); 
$data = json_decode( file_get_contents('php://input'), true );
if (! is_int( $loginkey = array_search( cleardata($data['login']), array_column($alldata, 'login') )) ) { // =, not ==
    $loginmsg='this login is not registered'; // checking for passwords with the same key as the login; login is unique, but not the password:
} elseif ( password_verify( cleardata($data['password']), $alldata[$loginkey]['password']) ) { // checking if the password matches the hash
    session_start(); // creating PHPSESSID cookies on the client side
    $_SESSION['name'] = $alldata[$loginkey]['name'];    
} else {
    $passwordmsg='wrong password';
}
// converting to json string and writing json output:
file_put_contents('php://output', json_encode(["loginmsg"=>$loginmsg ?? '', "passwordmsg"=>$passwordmsg ?? '']));