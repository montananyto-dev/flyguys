<?php
require_once(__DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');

class Location extends Entity implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    private $id;
    private $region;
    private $name;
    private $code;
    private $timezone;
    private $offset;
    private $creation_date;

    function __construct(Region $region, $name, $code, $timezone, $offset, $creation_date)
    {
        $this->region = $region;
        $this->name = $name;
        $this->code = $code;
        $this->timezone = $timezone;
        $this->offset = $offset;
        $this->creation_date = $creation_date;
    }

    function save() {
        if(isset($this->id)) {
            echo "Updating existing Location\n";
        } else {
            $this->region->save();
            echo "Inserting new Location\n";
        }
    }

    function setId($id) {
        $this->id=$id;
    }

    function getName() {
        return $this->name;
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