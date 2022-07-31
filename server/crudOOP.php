<?php

interface whatIsSafety
{
    public static function cleardata($text);
    public function hash($data);
    public function accessControl();
}

class Safe implements whatIsSafety
{
    final public static function cleardata($text)
    {
        // basic injection protection
        return htmlspecialchars(
            get_magic_quotes_gpc() == 1
                ? stripslashes(trim($text))
                : trim($text)
        );
    } // stripslashes removes character escaping \

    final public function hash($data)
    {
        // hashing with a variable SALT and increased algorithm complexity - 12 (bcrypt is safer than md5):
        // password_hash() returns the algorithm, cost, and salt as parts of the hash:
        return password_hash(
            $this->cleardata($data["password"]),
            PASSWORD_DEFAULT,
            ["cost" => 12]
        );
    }

    final public function accessControl()
    {
        if (
            !(
                isset($_SESSION["step1"]) &&
                $_SESSION["step1"] == "-g32gpm32g-?edm`~,pfw"
            )
        ) {
            die(" ACCESS DENIED! ERROR 404");
        } // revoking access to db config php files (login.php/registration.php) by checking if the browser was on index.php
        if (
            !(
                isset($_SESSION["step2"]) &&
                $_SESSION["step2"] == "-k72gpm31g+?edm`8,pfw"
            )
        ) {
            die(" ACCESS DENIED! ERROR 404");
        } // allow access to db config php files (login.php/registration.php) only for AJAX requests (only during their execution), deny access via direct link
    }
}

interface CRUD
{
    public function create($array);
    public function read();
    public function update($data);
    public function delete();
}

interface databaseSearching
{
    public function setSource($source);
    public function isFieldUnique($data, $field);
    public function loginKey($data);
}

final class Db extends Safe implements CRUD, databaseSearching
{
    private $source; // just an address

    public function setSource($source)
    {
        if (isset($source)) {
            $this->source = $source;
        } else {
            $this->source = "";
        }
    }

    public function __construct($source)
    {
        $this->setSource($source);
    }

    public function create($array)
    {
        // converting to json string and writing json database
        return file_put_contents($this->source, json_encode($array));
    }

    public function read()
    {
        // reading a file and writing it to a string, converting string to associative array:
        return json_decode(file_get_contents($this->source), true);
    }

    public function update($data)
    {
        // add information about the new user to the database
        $allData = $this->read();
        array_push($allData, $data);
        $this->create($allData);
    }

    public function delete()
    {
        // method for testing and debugging
        $this->create([]);
    }

    public function show()
    {
        // method for testing and debugging
        return var_dump($this->read());
    }

    public function isFieldUnique($data, $field)
    {
        // searching for the same value of this field
        return !in_array($data[$field], array_column($this->read(), $field));
    }

    public function loginKey($data)
    {
        // the key is like the number of the registered user
        return $loginkey = array_search(
            self::cleardata($data["login"]),
            array_column($this->read(), "login")
        );
    }

    public function isHash($loginkey, $data)
    {
        // checking for passwords with the same key as the login; login is unique, but not the password:
        return password_verify(
            self::cleardata($data["password"]),
            $this->read()[$loginkey]["password"]
        );
    } // it will return true if the hash of the password (password having the given key) matches the hash of the password entered by the user
}
