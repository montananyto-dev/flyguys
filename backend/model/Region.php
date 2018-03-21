<?php

class Region implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    private $id;
    private $name;

    public function __set($attribute, $value)
    {
        $this->$attribute = $value;
    }

    public function __get($attribute)
    {
        return $this->$attribute;
    }


}