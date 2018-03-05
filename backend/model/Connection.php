<?php
require_once( __DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');

require_once( __DIR__ . "/Flight.php");

class Connection extends Entity implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    private $id;
    private $fromLocation;
    private $toLocation;
    private $flight_duration;
    private $cost;

    function __construct(Location $fromLocation, Location $toLocation, $flight_duration, $cost)
    {
        $this->fromLocation = $fromLocation;
        $this->toLocation = $toLocation;
        $this->flight_duration = $flight_duration;
        $this->cost = $cost;

    }

    public static function getConnection(Location $from, Location $to) {
        $fromId = $from->getId();
        $toId = $to->getId();
        $selectSQL = "SELECT * FROM connection "
                    . "WHERE location_id1=$fromId AND location_id2=$toId;";
        
        $results = DBWrapper::select($selectSQL);

        
        $row = $results[0];

        
        $toReturn = new Connection($from, $to, $row['flight_duration'], $row['cost']);
        
        $toReturn->setId($row['id']);

        return $toReturn;
    }

    function getToLocation() {
        return $this->toLocation;
    }

    function getFromLocation() {
        return $this->fromLocation;
    }

    function getFlights() {
        $selectSQL = "SELECT * FROM flight WHERE connection_id=$this->id;";

        $results = DBWrapper::select($selectSQL);

        $flights = array();
        foreach($results as $row) {
            $flight = new Flight($this, $row['departure_date_time'], $row['capacity']);
            $flight->setId($row['id']);
            array_push($flights, $flight);

        }

        return $flights;
    }

    function save() {
        if(isset($this->id)) {
            echo "Updating existing Connection\n";
        } else {
            $this->location1->save();
            $this->location2->save();
            echo "Inserting new Connection\n";
        }
    }

    function setId($newId) {
        $this->id = $newId;
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