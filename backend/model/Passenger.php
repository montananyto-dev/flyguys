<?php


class Passenger {

    private $id;
    private $passportId;
    private $identityCard;
    private $countryCode;
    private $fname;
    private $lname;
    private $mname;
    private $dob;

    function __construct($id,$passportId,$identityCard,$countryCode,$fname,$lname,$mname,$dob){

        $this->id = $id;
        $this->passportId = $passportId;
        $this->identityCard = $identityCard;
        $this->countryCode = $countryCode;
        $this->fname = $fname;
        $this->lname = $lname;
        $this-> mname = $mname;
        $this-> dob = $dob;

        function __get($attribute){
          return  $this->$attribute;
        }

        function __set($attribute, $value){
            $this->$attribute = $value;

        }




}






}