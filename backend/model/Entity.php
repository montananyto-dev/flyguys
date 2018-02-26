<?php


abstract class Entity implements \JsonSerializable
{

    protected $modified;

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    abstract function save();


}