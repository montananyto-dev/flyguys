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
        if (!isset($instance)) {
            static::$instance = new DAO;
        }
        return static::$instance;
    }


    private function deleteQuery($sql){

        $statement = $this->conn->prepare($sql);

        $statement->execute();

    }



    private function insertQuery($sql)
    {
        $statement = $this->conn->prepare($sql);
        $statement->execute();
        return $this->conn->lastInsertId();
    }

    private function classQuery($sql, $class, $paramArray = [])
    {
        $statement = $this->conn->prepare($sql);
        $statement->execute($paramArray);
        $results = $statement->fetchAll(PDO::FETCH_CLASS, $class);

        return $results;
    }

    // SET ATTRIBUTE OBJECTS

    private function setRegionFor($locationObj) {
        $regionId = $locationObj->region_id;
        $sql = "SELECT * from region where id=$regionId";
        $region = $this->classQuery($sql, "Region");

        $locationObj->region = $region[0];
    }

    private function setLocationsFor($connectionObj) {
        $fromLocationId = $connectionObj->location_id1;
        $toLocationId = $connectionObj->location_id2;

        $sql = "SELECT * from location where id=$fromLocationId";
        $fromLocation = $this->classQuery($sql, "Location");
        $this->setRegionFor($fromLocation[0]);

        $sql = "SELECT * from location where id=$toLocationId";
        $toLocation = $this->classQuery($sql, "Location");
        $this->setRegionFor($toLocation[0]);

        $connectionObj->fromLocation = $fromLocation[0];
        $connectionObj->toLocation = $toLocation[0];
    }

    private function setConnectionFor($flightObj) {
        $connectionId = $flightObj->connection_id;
        $sql = "SELECT * from connection where id=$connectionId";
        $connection = $this->classQuery($sql, "Connection");
        $this->setLocationsFor($connection[0]);

        $flightObj->connection = $connection[0];

    }

    private function getAccounts($property = 1, $value = 1, $singleReturn = false)
    {
        $result = $this->classQuery("SELECT id, email, password, cookie, salt FROM account WHERE $property = '$value'", "Account");

        if ($singleReturn) {
            return $result[0];
        }

        return $result;
    }


    //Public Methods

    public function getRegionByName($nameStr) {
        $sql = "SELECT id, name from Region where name=:name";
        $result = $this->classQuery($sql, "Region", array('name' => $nameStr));
        return $result[0];
//        return $this->getRegions('name', $nameStr, true);
    }

    public function getAllFlights() {
        $sql = "SELECT * FROM flight";
        $results = $this->classQuery($sql, "Flight");
        foreach($results as $result) {
            $this->setConnectionFor($result);
        }
        return $results;
        //return $this->getFlights();
    }

    public function getAllLocations()
    {
        $sql = "SELECT * FROM location";
        $results = $this->classQuery($sql, "Location");
        foreach($results as $result) {
            $this->setRegionFor($result);
        }
        return $results;
        //return $this->getLocations();
    }

    public function getLocationByName($nameStr)
    {
        $sql = "select * from location where name='$nameStr'";
        $result = $this->classQuery($sql, "Location");
        return $result[0];
        //return $this->getLocations('name', $nameStr, true);
    }

    public function getLocationsConnectedTo($locationObj)
    {
        $locationId = $locationObj->id;
        $sql = 'SELECT l2.* FROM connection '
                . 'INNER JOIN location l ON connection.location_id1 = l.id '
                . 'INNER JOIN location l2 ON connection.location_id2 = l2.id '
                . 'where connection.location_id1=' . $locationId;
        $results = $this->classQuery($sql, "Location");

        foreach ($results as $result) {
            $this->setRegionFor($result);
        }

        return $results;
    }

    public function getFlightsBetween($fromLocationObj, $toLocationObj)
    {
        $fromId = $fromLocationObj->id;
        $toId = $toLocationObj->id;
        $sql = "select flight.* from flight
                  INNER JOIN connection c ON flight.connection_id = c.id
                  WHERE c.location_id1 = :fromId AND c.location_id2= :toId;";
        $flights = $this->classQuery($sql, "Flight", array("fromId" => $fromId, "toId" => $toId));

        foreach($flights as $flight) {
            $this->setConnectionFor($flight);
        }

        return $flights;

    }

    public function getFlightsBetweenByDay($fromLocationObj, $toLocationObj, $dayObj) {
        $fromId = $fromLocationObj->id;
        $toId = $toLocationObj->id;
        $dayNum = $dayObj->position;
        $sql = "select flight.* from flight
                  INNER JOIN connection c ON flight.connection_id = c.id
                  WHERE c.location_id1 = :fromId AND c.location_id2= :toId AND weekday(flight.departure_date_time)=:day";
        $params = array("fromId" => $fromId, "toId" => $toId, "day" => $dayNum);
        $flights = $this->classQuery($sql, "Flight", $params);

        foreach($flights as $flight) {
            $this->setConnectionFor($flight);
        }

        return $flights;
    }

    public function getFlightsBetweenByDate($fromLocationObj, $toLocationObj, $dateStr) {
        $fromId = $fromLocationObj->id;
        $toId = $toLocationObj->id;
        $sql = "select flight.* from flight
                  INNER JOIN connection c ON flight.connection_id = c.id
                  WHERE c.location_id1 = :fromId AND c.location_id2= :toId AND DATE(flight.departure_date_time)=:date";
        $params = array("fromId" => $fromId, "toId" => $toId, "date" => $dateStr);
        $flights = $this->classQuery($sql, "Flight", $params);

        foreach($flights as $flight) {
            $this->setConnectionFor($flight);
        }

        return $flights;

    }

    public function getAllFlightsByRegion($region)
    {
        if ($region->name == "Europe") {
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

        foreach ($flights as $flight) {

            $this->setConnectionFor($flight);
        }
        return $flights;
    }

    public function deleteFlightByID($id){

        $sql = "DELETE FROM flight WHERE id = $id";

        $this->deleteQuery($sql);

    }

    //ADDING

    public function addAccount($cookieStr)
    {
        $newId = $this->insertQuery("INSERT INTO account(cookie) VALUES('$cookieStr')");
        return $newId;
    }

    public function addBooking($accountId)
    {
        $newId = $this->insertQuery("INSERT INTO booking(account_id) VALUES($accountId)");
        return $newId;
    }

    public function getPendingBookings($accId, $singleReturn = false)
    {
        $result = $this->classQuery("SELECT * FROM booking WHERE account_id=$accId AND state_id=1", "Booking");

        if ($singleReturn) {
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

