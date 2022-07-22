<?php 
//echo date('h:i:s')."\n";sleep(5);echo date('h:i:s')."\n"; // testing that the button is blocked for the duration of the server response
// reading a file and writing it to a string, converting string to associative array:
$alldata = json_decode( file_get_contents('database.json'), true ); 
$data = json_decode( file_get_contents('php://input'), true );
require_once "cleardata.php";
$data['login'] = cleardata($data['login']);
// hashing with a variable SALT and increased algorithm complexity - 12 (bcrypt is safer than md5):
// password_hash() returns the algorithm, cost, and salt as parts of the hash:
$data['password'] = password_hash( cleardata($data['password']), PASSWORD_DEFAULT, ['cost' => 12]);
if (in_array( $data['login'], array_column($alldata, 'login'))) { // searching for the same login
    $loginmsg='this login is already used, use another one';
}
  elseif (in_array( $data['email'], array_column($alldata, 'email'))) { // searching for the same email
    $emailmsg='this email is already used, use another one';
} else {
    array_push($alldata, $data);
}
file_put_contents('database.json', json_encode($alldata)); // converting to json string and writing json database
file_put_contents('php://output',json_encode(["loginmsg"=>$loginmsg ?? '',"emailmsg"=>$emailmsg ?? '']));//converting to json string and writing json output