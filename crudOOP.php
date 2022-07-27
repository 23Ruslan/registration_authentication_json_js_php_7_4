<?php
require_once "securityOOP.php";

interface CRUD
{
    function create($array);
    function read();
    function update($data);
    function delete();
}

interface databaseSearching
{
    function isFieldUnique($data, $field);
    function loginKey($data);
}

final class Db extends Safe implements CRUD, databaseSearching
{

    private $jsonFile; // just an address

    function __construct($jsonFile) {
        $this->jsonFile = $jsonFile;
    }

    function create($array)
    { // converting to json string and writing json database
        return file_put_contents($this->jsonFile, json_encode($array));
    }

    function read()
    { // reading a file and writing it to a string, converting string to associative array:
        return json_decode(file_get_contents($this->jsonFile) , true);
    }

    function update($data)
    { // add information about the new user to the database
        $allData = $this->read();
        array_push($allData, $data);
        $this->create($allData);
    }

    function delete()
    { // method for testing and debugging
        $this->create([]);
    }

    function show()
    { // method for testing and debugging
        return var_dump($this->read());
    }

    function isFieldUnique($data, $field)
    { // searching for the same value of this field
        return !in_array($data[$field], array_column($this->read() , $field));
    }

    function loginKey($data)
    { // the key is like the number of the registered user
        return $loginkey = array_search(Safe::cleardata($data['login']) , array_column($this->read() , 'login'));
    }

    function isHash($loginkey, $data)
    { // checking for passwords with the same key as the login; login is unique, but not the password:
        return password_verify(Safe::cleardata($data['password']) , $this->read() [$loginkey]['password']);
    } // it will return true if the hash of the password (password having the given key) matches the hash of the password entered by the user
    
}