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

    private function deleteQuery($sql)
    {

        $statement = $this->conn->prepare($sql);

        $statement->execute();

    }

    private function insertQuery($sql, $params = [])
    {
        $statement = $this->conn->prepare($sql);
        $statement->execute($params);
        return $this->conn->lastInsertId();
    }

    private function classQuery($sql, $class, $paramArray = [])
    {
        $statement = $this->conn->prepare($sql);
        $statement->execute($paramArray);
        $results = $statement->fetchAll(PDO::FETCH_CLASS, $class);

        return $results;
    }

    // ----------------------------------------------------  SET ATTRIBUTE OBJECTS ----------------------------------------------------- //

    private function setRegionFor($locationObj)
    {
        $regionId = $locationObj->region_id;
        $sql = "SELECT * from region where id=$regionId";
        $region = $this->classQuery($sql, "Region");

        $locationObj->region = $region[0];
    }

    private function setLocationsFor($connectionObj)
    {
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

    private function setConnectionFor($flightObj)
    {
        $connectionId = $flightObj->connection_id;
        $sql = "SELECT * from connection where id=$connectionId";
        $connection = $this->classQuery($sql, "Connection");
        $this->setLocationsFor($connection[0]);

        $flightObj->connection = $connection[0];

    }

    public function getAccountByCookie($cookieStr)
    {
        $sql = "SELECT * FROM account WHERE cookie = :cookie";
        $params = array("cookie" => $cookieStr);
        $result = $this->classQuery($sql, "Account", $params);

        return $result[0];
    }

    // ----------------------------------------------------  PUBLIC METHODS ----------------------------------------------------- //

    public function getAllRegionNames()
    {

        $sql = "SELECT * FROM region";
        $result = $this->classQuery($sql, 'Region');

        $names = array();
        foreach ($result as $row) {
            $names[] = $row->name;
        }
        return $names;
    }

    public function getRegionByName($nameStr)
    {
        $sql = "SELECT id, name FROM region WHERE name=:name";
        $result = $this->classQuery($sql, "Region", array('name' => $nameStr));
        return $result[0];
//        return $this->getRegions('name', $nameStr, true);
    }

    public function getAllFlights()
    {
        $sql = "SELECT * FROM flight";
        $results = $this->classQuery($sql, "Flight");
        foreach ($results as $result) {
            $this->setConnectionFor($result);
        }
        return $results;
        //return $this->getFlights();
    }

    public function getAllLocations()
    {
        $sql = "SELECT * FROM location";
        $results = $this->classQuery($sql, "Location");
        foreach ($results as $result) {
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
            . 'WHERE connection.location_id1=' . $locationId;
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
        $sql = "SELECT flight.* FROM flight
                  INNER JOIN connection c ON flight.connection_id = c.id
                  WHERE c.location_id1 = :fromId AND c.location_id2= :toId;";
        $flights = $this->classQuery($sql, "Flight", array("fromId" => $fromId, "toId" => $toId));

        foreach ($flights as $flight) {
            $this->setConnectionFor($flight);
        }

        return $flights;

    }

    public function getFlightsBetweenByDay($fromLocationObj, $toLocationObj, $dayObj)
    {
        $fromId = $fromLocationObj->id;
        $toId = $toLocationObj->id;
        $dayNum = $dayObj->position;
        $sql = "SELECT flight.* FROM flight
                  INNER JOIN connection c ON flight.connection_id = c.id
                  WHERE c.location_id1 = :fromId AND c.location_id2= :toId AND weekday(flight.departure_date_time)=:day";
        $params = array("fromId" => $fromId, "toId" => $toId, "day" => $dayNum);
        $flights = $this->classQuery($sql, "Flight", $params);

        foreach ($flights as $flight) {
            $this->setConnectionFor($flight);
        }

        return $flights;
    }

    public function getFlightsBetweenByDate($fromLocationObj, $toLocationObj, $dateStr)
    {
        $fromId = $fromLocationObj->id;
        $toId = $toLocationObj->id;
        $sql = "SELECT flight.* FROM flight
                  INNER JOIN connection c ON flight.connection_id = c.id
                  WHERE c.location_id1 = :fromId AND c.location_id2= :toId AND DATE(flight.departure_date_time)=:date";
        $params = array("fromId" => $fromId, "toId" => $toId, "date" => $dateStr);
        $flights = $this->classQuery($sql, "Flight", $params);

        foreach ($flights as $flight) {
            $this->setConnectionFor($flight);
        }

        return $flights;

    }

    public function getConnectionFromTwoLocations($location1, $location2)
    {

        $sql1 = "SELECT * FROM location WHERE location.name = '$location1'";
        $location1 = $this->classQuery($sql1, 'Location');
        foreach ($location1 as $result) {
            $this->setRegionFor($result);
        }
        $locationFromId = $location1[0]->id;

        $sql2 = "SELECT * FROM location WHERE location.name = '$location2'";
        $location2 = $this->classQuery($sql2, 'Location');
        foreach ($location2 as $result) {
            $this->setRegionFor($result);
        }
        $locationToId = $location2[0]->id;

        $sql3 = "SELECT * FROM connection WHERE
        location_id1 = '$locationFromId' and location_id2 = '$locationToId'";

        $results = $this->classQuery($sql3, 'Connection');

        foreach ($results as $result) {
            $this->setLocationsFor($result);
        }

        return $results[0];
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

    public function deleteFlightByID($id)
    {

        $sql = "DELETE FROM flight WHERE id = $id";

        $this->deleteQuery($sql);

    }

    // ----------------------------------------------------  INSERT METHODS ----------------------------------------------------- //

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

    public function deleteFlightFromBooking($flightId){

        $sql = "DELETE FROM booking_flight WHERE flight_id = $flightId";

        $this->deleteQuery($sql);
    }

    public function getPendingBookings($accObj)
    {
        $accId = $accObj->id;
        $sql = "SELECT * FROM booking WHERE account_id=:id AND state_id=1";
        $params = array("id" => $accId);
        $result = $this->classQuery($sql, "Booking", $params);

        if (count($result) <= 0) {

            return 'No results';

        } else {

            return $result[0];
        }


    }

    public function getSinglePendingBooking($accObj,$flightId)
    {
        $accId = $accObj->id;
        $sql = "SELECT * FROM booking WHERE account_id=:id AND state_id=1";
        $params = array("id" => $accId);
        $result = $this->classQuery($sql, "Booking", $params);

        return $result[0];
    }

    public function createPendingBooking($accObj)
    {
        $sql = "INSERT INTO booking(account_id, state_id) VALUES(:accId, :stateId)";
        $params = array("accId" => $accObj->id, "stateId" => 1);
        $this->insertQuery($sql, $params);

        return $this->getPendingBookings($accObj);

    }

    public function addFlightToBooking($bookObj, $flightIdentifier)
    {
        $sql = "INSERT INTO booking_flight VALUES(:bId, :fId)";
        $params = array("bId" => $bookObj->id, "fId" => $flightIdentifier);
        $this->insertQuery($sql, $params);
    }

    public function addANewFlight($data)
    {
        $locationFrom = $data[0]['value'];
        $locationTo = $data[1]['value'];
        $region = $data[2]['value'];
        $flightDuration = $data[3]['value'];
        $cost = $data[4]['value'];
        $capacity = $data[5]['value'];
        $departureDate = $data[6]['value'];

        $result = $this->getConnectionFromTwoLocations($locationFrom, $locationTo);
        $connectionId = $result->id;
        $sql = "INSERT INTO flight (connection_id, departure_date_time, capacity )
                 VALUES ($connectionId, '$departureDate', $capacity)";

        $insertId = $this->insertQuery($sql);

        return $insertId;
    }

    public function editFlight($flightId, $departureTime, $capacity)
    {
        $sql = "UPDATE flight
        SET departure_date_time = '$departureTime', capacity = $capacity 
        WHERE flight.id =$flightId ";

        $this->insertQuery($sql);

    }

    public function getFlightsByBooking($bookingObj) {
        $sql = "SELECT * from flight where id IN (SELECT flight_id from booking_flight where booking_id = :bookId)";
        $params = array("bookId" => $bookingObj->id);
        $flights = $this->classQuery($sql, "Flight", $params);

        foreach($flights as $flight) {
            $this->setConnectionFor($flight);
        }

        return $flights;
    }
}

//function setPerItem($array, $identifier, $property, $anonFunction) {
//    foreach($array as $item) {
//        $item->$property = $anonFunction($identifier);
//    }
//}

