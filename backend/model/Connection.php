<?php

class Connection
{

    private $id;
    private $location_id1;
    private $location_id2;
    private $flight_duration;
    private $cost;

    function __construct($id, $location_id1, $location_id2, $flight_duration, $cost)
    {

        $this->id = $id;
        $this->location_id1 = $location_id1;
        $this->location_id2 = $location_id2;
        $this->flight_duration = $flight_duration;
        $this->cost = cost;

        function __set($attribute, $value)
        {
            $this->$attribute = $value;
        }

        function __get($attribute)
        {
            return $this->$attribute;
        }

    }
}