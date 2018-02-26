<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 18/02/2018
 * Time: 21:43
 */

require_once('../database/DBWrapper.php');

class Cookie implements \JsonSerializable
{
    
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }


    private $cookie_name;
    private $cookie_value;
    private $cookie_time;
    private $cookie;

    function __construct()
    {
        $this->setCookieName();
        $this->setCookieValue();
        $this->setCookieTime();
        $this->setCookie();
    }


    function setCookieName()
    {
        $this->cookie_name = $this->generateRandomString();
    }

    function setCookieValue()
    {

        $this->cookie_value = $this->generateRandomNumber();
    }

    function setCookieTime()
    {

        $this->cookie_time = $this->generateCookieTime();
    }

    function setCookie()
    {

        $this->cookie = setcookie($this->cookie_name, $this->cookie_value, $this->cookie_time);
    }

    function __getCookie()
    {

        return $this->cookie;

    }

    function __getCookieName()
    {
        return $this->cookie_name;
    }

    function __getCookieValue()
    {

        return $this->cookie_value;
    }


    function checkIfCookieExist($cookie)
    {

        $statement = "SELECT cookie FROM account";
        $results[] = DBWrapper::select($statement);

        foreach ($results as $row => $innerArray) {
            foreach ($innerArray as $innerRow => $value) {
                if (in_array($cookie, $value)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    function generateRandomString()
    {
        $length = 5;
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function generateRandomNumber()
    {
        $randomNumber = rand(100000, 999999);
        return $randomNumber;
    }

    //10 years cookie
    function generateCookieTime()
    {
        return time() + (10 * 365 * 24 * 60 * 60);
    }



}