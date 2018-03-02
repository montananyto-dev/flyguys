<?php
require_once( __DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');

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
        $this->cost = cost;

    }

    function getToLocation() {
        return $this->toLocation;
    }

    function getFromLocation() {
        return $this->fromLocation;
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

    function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    function __get($attribute)
    {
        return $this->$attribute;
    }
}