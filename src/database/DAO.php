<?php
require_once(__DIR__ . '/../model/Location.php');
require_once(__DIR__ . '/../model/Flight.php');
require_once(__DIR__ . '/../model/Connection.php');
require_once(__DIR__ . '/../model/Region.php');
require_once(__DIR__ . '/../model/Account.php');

class DAO
{

    private static $instance;

    private $conn;

    private function __construct()
    {
        $serverName = "localhost";
        $username = "flyguys";
        $password = "Kingston2017!";

        try {
            $this->conn = new PDO("mysql:host=$serverName;dbname=flyguys", $username, $password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new DAO;
        }
        return static::$instance;
    }

    private function plainQuery($sql)
    {
        $statement = $this->conn->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll();

        return $results;
    }

    private function insertQuery($sql) {
        $statement = $this->conn->prepare($sql);
        $statement->execute();
        return $this->conn->lastInsertId();
    }

    private function classQuery($sql, $class) {
        $statement = $this->conn->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_CLASS, $class);

        return $results;
    }

    private function getAccounts($property = 1, $value = 1, $singleReturn = false) {
        $result = $this->classQuery("SELECT id, email, password, cookie, salt FROM account WHERE $property = '$value'", "Account");

        if ($singleReturn) {
            return $result[0];
        }

        return $result;
    }

    public function getRegions($property = 1, $value = 1, $singleReturn = false) {
        $result = $this->classQuery("SELECT id, name FROM region WHERE $property = '$value'", "Region");

        if ($singleReturn) {
            return $result[0];
        }

        return $result;
    }


    private function getLocations($property = 1, $value = 1, $singleReturn = false) {
        $result = $this->classQuery("SELECT * FROM location where $property = '$value'", "Location");

        foreach ($result as $row) {
            $region = $this->getRegions('id', $row->__get('region_id'), true);
            $row->region = $region;
        }

        if ($singleReturn) {
            return $result[0];
        }

        return $result;
    }

    private function getConnections($property = 1, $value = 1, $singleReturn = false)
    {
        $result = $this->classQuery("SELECT * FROM connection WHERE $property = '$value'", "Connection");

        foreach ($result as $row) {
            $fromLocation = $this->getLocations('id', $row->location_id1, true);
            $toLocation = $this->getLocations('id', $row->location_id2, true);

            $row->fromLocation = $fromLocation;
            $row->toLocation = $toLocation;
        }

        if ($singleReturn) {
            return $result[0];
        }

        return $result;
    }

    private function getFlights($property = 1, $value = 1, $singleReturn = false) {

        $result = $this->classQuery("SELECT * FROM flight WHERE $property = '$value'", "Flight");

        foreach ($result as $row) {
            $connection = $this->getConnections('id', $row->connection_id, true);
            $row->connection = $connection;
        }

        if ($singleReturn) {
            return $result[0];
        }

        return $result;
    }

    //Public Methods

    public function getAllLocations() {
        return $this->getLocations();
    }

    public function getLocationByName($nameStr) {
        return $this->getLocations('name', $nameStr, true);
    }

    public function getLocationsConnectedTo($locationObj) {
        $connections = $this->getConnections('location_id1', $locationObj->id);

        $toLocations = array();
        foreach ($connections as $connection) {
            array_push($toLocations, $connection->toLocation);
        }

        return $toLocations;
    }

    public function getFlightsBetween($fromLocationObj, $toLocationObj = null) {
        if($toLocationObj == null) {
            $toLocationObj = $this->getLocations();
        }

        $allFlights = $this->getFlights();

        $filteredFlights = array();
        foreach ($allFlights as $flight) {
            if ($flight->connection->fromLocation == $fromLocationObj
                && $flight->connection->toLocation == $toLocationObj) {
                array_push($filteredFlights, $flight);
            }
        }

        return $filteredFlights;
    }

    public function getAllFlightsByRegion($region)
    {
        if ($region == "Europe") {
            $sql = "SELECT flight.*,r.name FROM flight INNER JOIN connection c ON flight.connection_id = c.id
                                           INNER JOIN location l ON c.location_id1 = l.id
                                           INNER JOIN location l1 ON c.location_id2 = l1.id
                                           INNER JOIN region r ON l.region_id = r.id OR l1.region_id = r.id
                                           WHERE r.name = 'Europe'";

        } else {
            $sql = "SELECT flight.*,r.name FROM flight INNER JOIN connection c ON flight.connection_id = c.id
                                           INNER JOIN location l ON c.location_id1 = l.id
                                           INNER JOIN location l1 ON c.location_id2 = l1.id
                                           INNER JOIN region r ON l.region_id = r.id AND l1.region_id = r.id
                                           WHERE r.name = 'Domestic' ";

        }

        $flights = $this->classQuery($sql, "Flight");

        foreach ($flights as $row) {

            $connection = $this->getConnections('id', $row->connection_id, true);
            $row->connection = $connection;
        }
        return $flights;
    }


    //ADDING

    public function addAccount($cookieStr) {
        $newId = $this->insertQuery("INSERT INTO account(cookie) VALUES('$cookieStr')");
        return $newId;
    }

    public function addBooking($accountId) {
        $newId = $this->insertQuery("INSERT INTO booking(account_id) VALUES($accountId)");
        return $newId;
    }

    public function getPendingBookings($accId, $singleReturn = false) {
        $result = $this->classQuery("SELECT * FROM booking WHERE account_id=$accId AND state_id=1", "Booking");

        if($singleReturn) {
            return $result[0];
        }

        return $result;
    }
}







//function setPerItem($array, $identifier, $property, $anonFunction) {
//    foreach($array as $item) {
//        $item->$property = $anonFunction($identifier);
//    }
//}

