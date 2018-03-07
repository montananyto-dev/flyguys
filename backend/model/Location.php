<?php
require_once(__DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');
require_once(__DIR__ . "/Connection.php");
require_once(__DIR__ . "/Region.php");

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

    function getRegion() {
        return $this->region;
    }

    function getConnections() {
        $selectSQL = "SELECT * FROM connection WHERE location_id1=$this->id;";

        $results = DBWrapper::select($selectSQL);

        $connections = array();
        foreach($results as $row) {
            $tempConnection = new Connection($this,
                                            Location::getById($row['location_id2']),
                                            $row['flight_duration'],
                                            $row['cost']);
            $tempConnection->setId($row['id']);
            array_push($connections, $tempConnection);
        }

        return $connections;
    }

    public static function getById($id) {

        $selectSQL = "SELECT * FROM location"
                    . " WHERE id=$id;";
        $results = DBWrapper::select($selectSQL);

        $row = $results[0];

        $location = new Location(Region::getById($row['region_id']), $row['name'], $row['code'], $row['timezone'], $row['offset'], $row['creation_date']);
        $location->setId($id);

        return $location;

    }

    public static function getByName($name) {

        $selectSQL = "SELECT * FROM location WHERE name='$name';";
        $results = DBWrapper::select($selectSQL);

        $row = $results[0];

        $location = new Location(Region::getById($row['region_id']), $row['name'], $row['code'], $row['timezone'], $row['offset'], $row['creation_date']);
        $location->setId($row['id']);

        return $location;

    }

    function getId() {
        return $this->id;
    }
}