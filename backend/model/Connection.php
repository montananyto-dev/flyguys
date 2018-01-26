<?php

class Connection extends Entity
{

    private $id;
    private $location1;
    private $location2;
    private $flight_duration;
    private $cost;

    function __construct(Location $location1, Location $location2, $flight_duration, $cost)
    {

        $this->location1 = $location1;
        $this->location2 = $location2;
        $this->flight_duration = $flight_duration;
        $this->cost = cost;

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