<?php
if (isset($_SESSION['step1']) && password_verify("-g32gpm32g-?edm`~,pfw", $_SESSION['step1']))
{
} // password_ is just function, not password hash
else die(" ACCESS DENIED! ERROR 404"); // basic revoking access to php db config files (login.php/registration.php) by checking if the browser was on index.php
if (isset($_SESSION['step2']) && $_SESSION['step2'] + 5 >= time())
{
}
else die(" ACCESS DENIED! ERROR 404"); // access to php db config files (login.php/registration.php) is available only to browsers where the button is pressed for 5 seconds (view script.js)
interface whatIsSafety
{
    function cleardata($text);
    function hash($data);
}

class Safe implements whatIsSafety
{
    final function cleardata($text)
    { // basic injection protection
        return htmlspecialchars((get_magic_quotes_gpc() == 1) ? (stripslashes(trim($text))) : (trim($text)));
    } // stripslashes removes character escaping \
    final function hash($data)
    {
        // hashing with a variable SALT and increased algorithm complexity - 12 (bcrypt is safer than md5):
        // password_hash() returns the algorithm, cost, and salt as parts of the hash:
        return password_hash(self::cleardata($data['password']) , PASSWORD_DEFAULT, ['cost' => 12]);
    }
}