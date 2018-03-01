<?php
require_once( __DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');
require_once( __DIR__ . "/Location.php");


class Region extends Entity
{

    private $region_id;
    private $name;


    function __construct($name)
    {
        $this->name=$name;
        $this->modified=false;
    }

    function setId($newId) {
        $this->region_id=$newId;
    }

    function setName($newName) {
        $this->modified=true;
        $this->name=$newName;
    }

    function save() {
        if (isset($this->region_id) && $this->modified) {
            $updateSQL = "UPDATE region "
                . "SET name = '$this->name' "
                . "WHERE id=$this->region_id";
            DBWrapper::insert($updateSQL);
        } else {
            $insetSQL = "INSERT INTO "
                . "region(name)"
                . "VALUES('$this->name');";

            $this->region_id = DBWrapper::insert($insetSQL);
        }
    }

    function getByName($searchName) {
        $selectSQL = "SELECT * FROM region"
            . " WHERE name='$searchName'";
        $results = DBWrapper::select($selectSQL);

        $result =  $results[0];

        $toReturn = new Region($result['name']);
        $toReturn->setId((int)$result['id']);

        return $toReturn;
    }
}