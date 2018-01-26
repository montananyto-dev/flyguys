<?php

class Region extends Entity
{

    private $id;
    private $name;

    function __construct($name)
    {

        $this->name->$name;

    }

    function save() {
        if(isset($this->id)) {
            echo "Updating existing Region\n";
        } else {
            echo "Inserting new Region\n";
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