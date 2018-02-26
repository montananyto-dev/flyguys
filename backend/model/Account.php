<?php
require_once("Entity.php");
require_once('../database/DBWrapper.php');

class Account extends Entity
{
    private $acc_id;
    private $email;
    private $password;
    private $cookie;

    function __construct($email, $password, $cookie)
    {
        $this->email = $email;
        $this->setPassword($password);
        $this->cookie = $cookie;
        $this->modified=false;
    }


    function getId() { return $this->acc_id; }
    function getEmail() { return $this->email; }

    function setId($newId) {
        $this->acc_id=$newId;
    }

    function setEmail($newEmail) {
        $this->modified = true;
        $this->email=$newEmail;
    }

    function setPassword($newPassword) {

        $salt ="123456789";
        $this->password = crypt($newPassword,$salt);

    }

    function save()
    {
        if(!isset($this->acc_id)) {
            $insetSQL = "INSERT INTO "
                . "account(email, password, cookie, salt)"
                . "VALUES('$this->email', '$this->password', '$this->cookie', '123456789');";

            $this->acc_id = DBWrapper::insert($insetSQL);
        }
        if($this->modified) {
            $updateSQL = "UPDATE account "
                . "SET email = '$this->email', password='$this->password' "
                . "WHERE id=$this->acc_id";
            DBWrapper::insert($updateSQL);
        }

    }

    public static function getByCookie($cookie) {
        $selectSQL = "SELECT * FROM account"
                    . " WHERE cookie='$cookie'";
        $results = DBWrapper::select($selectSQL);

        $result =  $results[0];

        $toReturn = new Account($result['email'], $result['password'], $result['cookie']);
        $toReturn->setId((int)$result['id']);

        return $toReturn;
    }

    function login($email, $password)
    {

        global $connection;

        $salt = "123456789";

        $password = CRYPT_SHA256($password,$salt);

        $statement = $connection->prepare("SELECT * FROM account 
                                                    WHERE email = :email 
                                                    and WHERE password = :password");

        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);

        $result = DBWrapper::select($statement);

        return $result;

    }

}
