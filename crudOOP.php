<?php
require_once "securityOOP.php";

interface CRUD
{
    static function create($array);
    static function read();
    static function update($data);
    static function delete();
}

class Db extends Safe implements CRUD
{

    static $jsonFile;

    static function create($array)
    { // converting to json string and writing json database
        return file_put_contents(self::$jsonFile, json_encode($array));
    }

    static function read()
    { // reading a file and writing it to a string, converting string to associative array:
        return json_decode(file_get_contents(self::$jsonFile) , true);
    }

    static function update($data)
    { // add information about the new user to the database
        $allData = self::read();
        array_push($allData, $data);
        self::create($allData);
    }

    static function delete()
    { // method for testing and debugging
        self::create([]);
    }

    static function show()
    { // method for testing and debugging
        return var_dump(self::read());
    }

    static function isFieldUnique($data, $field)
    { // searching for the same value of this field
        return !in_array($data[$field], array_column(self::read() , $field));
    }

    static function loginKey($data)
    { // the key is like the number of the registered user
        return $loginkey = array_search(Safe::cleardata($data['login']) , array_column(self::read() , 'login'));
    }

    static function isHash($loginkey, $data)
    { // checking for passwords with the same key as the login; login is unique, but not the password:
        return password_verify(Safe::cleardata($data['password']) , self::read() [$loginkey]['password']);
    } // it will return true if the hash of the password (password having the given key) matches the hash of the password entered by the user
    
}

