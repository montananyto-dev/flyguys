<?php

class State extends Entity
{

    private $id;
    private $status;

    function __construct($status)
    {
        $this->status = $status;
    }

    function save() {
        if(isset($this->id)) {
            echo "Updating existing state\n";
        } else {
            $this->account->save();
            echo "Inserting new booking\n";
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