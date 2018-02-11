<?php
require_once("Entity.php");
require_once('../database/DBWrapper.php');

class Account extends Entity
{

    private static $count;

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

    function setId($newId) {
        $this->acc_id=$newId;
    }

    function setEmail($newEmail) {
        $this->modified = true;
        $this->email=$newEmail;
    }

    function setPassword($newPassword) {
        $options = [
            'cost' => 12,
        ];
        $this->password= password_hash($newPassword, PASSWORD_BCRYPT, $options);
    }

    function save()
    {
        if (isset($this->acc_id) && $this->modified) {
            $updateSQL = "UPDATE account "
                        . "SET email = '$this->email', password='$this->password' "
                        . "WHERE id=$this->acc_id";
            DBWrapper::insert($updateSQL);
        } else {
            $insetSQL = "INSERT INTO "
                        . "account(email, password, cookie, salt)"
                        . "VALUES('$this->email', '$this->password', '$this->cookie', 'dsfsdf');";

            $this->acc_id = DBWrapper::insert($insetSQL);
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

}
