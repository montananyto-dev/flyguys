<?php

class State
{

    private $id;
    private $status;

    function __construct($id, $status)
    {
        $this->id = $id;
        $this->status = $status;
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