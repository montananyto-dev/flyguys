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


    public static function getAll() {

        $selectSQL = "SELECT * FROM region";
        $results = DBWrapper::select($selectSQL);

        $allRegions = array();

        foreach($results as $result) {
            $region = new Region($result['name']);
            $region->setId($result['id']);
            array_push($allRegions, $region);
        }

        return $allRegions;
    }

    function getLocations() {
        $selectSQL = "SELECT * FROM location"
            . " WHERE region_id='$this->region_id'";
        $results = DBWrapper::select($selectSQL);

        $locations = array();

        foreach($results as $row) {
            $location = new Location($this, $row['name'], $row['code'], $row['timezone'], $row['offset'], $row['creation_date']);
            $location->setId($row['id']);
            array_push($locations, $location);
        }

        return $locations;
    }

    public static function getById($id) {
        $selectSQL = "SELECT name FROM region"
            . " WHERE id=$id";
        $results = DBWrapper::select($selectSQL);
        $result =  $results[0];

        $region = new Region($result['name']);
        $region->setId($id);

        return $region;
    }
}