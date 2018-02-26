<?php

class Login
{

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