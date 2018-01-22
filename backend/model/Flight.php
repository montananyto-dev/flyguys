<?php
/**
 * Created by IntelliJ IDEA.
 * User: montananyto
 * Date: 22/01/2018
 * Time: 22:37
 */

class Flight
{
    private $id;
    private $connection_id;
    private $departure_date_time;
    private $capacity;


    function __construct($id,$connection_id,$departure_date_time,$capacity)
    {
        $this->id = $id;
        $this->connection_id = $connection_id;
        $this->departure_date_time = $departure_date_time;
        $this->capacity = $capacity;
    }

    function __set($attribute,$value){
        $this->$attribute = $value;
    }
    function __get($attribute){
        return $this->$attribute;
    }
}