<?php

require_once("../database/connection.php");
require_once("../database/config.php");

class Dao
{
    public function searchFlightByDeparturePoint()
    {
    }

    public function searchFlightByDestination()
    {
    }

    public function searchFlightByDate()
    {
    }

    public function searchFlightByDayOfTheWeek()
    {
    }

    public function getAllFlight()
    {

        global $connection;
        $statement = $connection->prepare("SELECT * FROM FLIGHTS");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_CLASS, "flight");
        return $results;

    }

    public function getDomesticFlight()
    {


    }

    public function getEuropeanFlight()
    {
    }

    public function addFlight()
    {
    }

    public function updateFlightDuration()
    {
    }

    public function updateFlightDepartureDateTime()
    {
    }


}


