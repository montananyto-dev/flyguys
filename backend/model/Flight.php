<?php
/**
 * Created by IntelliJ IDEA.
 * User: montananyto
 * Date: 22/01/2018
 * Time: 22:37
 */

class Flight extends Entity
{
    private $id;
    private $connection;
    private $departure_date_time;
    private $capacity;


    function __construct(Connection $connection,$departure_date_time,$capacity)
    {
        $this->connection = $connection;
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