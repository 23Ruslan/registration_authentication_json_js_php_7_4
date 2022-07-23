<?php
if (isset($_SESSION['step1']) && password_verify("-g32gpm32g-?edm`~,pfw", $_SESSION['step1']))
{
} // password_ is just function, not password hash
else die(" ACCESS DENIED! ERROR 404"); // basic revoking access to php db config files (login.php/registration.php) by checking if the browser was on index.php
if (isset($_SESSION['step2']) && $_SESSION['step2'] + 3 >= time())
{
}
else die(" ACCESS DENIED! ERROR 404"); // access to php db config files (login.php/registration.php) is available only to browsers where the button is pressed for 3 seconds (view script.js)
interface whatIsSafety
{
    static function cleardata($text);
    static function hash($data);
}

class Safe implements whatIsSafety
{
    static function cleardata($text)
    { // basic injection protection
        return htmlspecialchars((get_magic_quotes_gpc() == 1) ? (stripslashes(trim($text))) : (trim($text)));
    } // stripslashes removes character escaping \
    static function hash($data)
    {
        // hashing with a variable SALT and increased algorithm complexity - 12 (bcrypt is safer than md5):
        // password_hash() returns the algorithm, cost, and salt as parts of the hash:
        return password_hash(self::cleardata($data['password']) , PASSWORD_DEFAULT, ['cost' => 12]);
    }
}