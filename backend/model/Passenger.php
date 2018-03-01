<?php
require_once( __DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');

class Passenger extends Entity
{

    private $id;
    private $passportNum;
    private $identityCard;
    private $countryCode;
    private $fname;
    private $lname;
    private $mname;
    private $dob;

    function __construct($passportNum, $identityCard, $countryCode, $fname, $lname, $mname, $dob)
    {
        $this->passportNum = $passportNum;
        $this->identityCard = $identityCard;
        $this->countryCode = $countryCode;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->mname = $mname;
        $this->dob = $dob;
    }

    function save() {
        if(isset($this->id)) {
            echo "Updating existing Passenger\n";
        } else {
            echo "Inserting new Passenger\n";
        }
    }

    

    function __set($attribute, $value)
    {
        $this->$attribute = $value;

    }

    function __get($attribute)
    {
        return $this->$attribute;
    }


}