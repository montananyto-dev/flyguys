<?php

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


    private function setCookieName()
    {
        $this->cookie_name = $this->generateRandomString();
    }

    private function setCookieValue()
    {

        $this->cookie_value = $this->generateRandomNumber();
    }

    private function setCookieTime()
    {

        $this->cookie_time = $this->generateCookieTime();
    }

    private function setCookie()
    {

        $this->cookie = setcookie($this->cookie_name, $this->cookie_value, $this->cookie_time);
    }

    public function __get($property) {
        return $this->$property;
    }


    private function generateRandomString()
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

    private function generateRandomNumber()
    {
        $randomNumber = rand(100000, 999999);
        return $randomNumber;
    }

    //10 years cookie
    private function generateCookieTime()
    {
        return time() + (10 * 365 * 24 * 60 * 60);
    }

}