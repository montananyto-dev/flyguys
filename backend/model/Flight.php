<?php
require_once( __DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');

class Flight extends Entity implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

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

    function setId($newId) {
        $this->id = $newId;
    }

    // function __set($attribute,$value){
    //     $this->$attribute = $value;
    // }
    // function __get($attribute){
    //     return $this->$attribute;
    // }

    function getConnection() {
        return $this->connection;
    }

    function save()
    {
        // TODO: Implement save() method.
    }
}