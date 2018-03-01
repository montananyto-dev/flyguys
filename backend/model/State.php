<?php
require_once( __DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');

class State extends Entity
{

    private $state_id;
    private $status;

    function __construct($status)
    {
        $this->status = $status;
    }

    function getId() { return $this->state_id; }
    function getStatus() { return $this->status; }

    function setId($newId) {
        $this->state_id=$newId;
    }

    function setStatus($newStatus) {
        $this->modified=true;
        $this->status=$newStatus;
    }

    function save() {
        if (isset($this->state_id) && $this->modified) {
            $updateSQL = "UPDATE state "
                . "SET status = '$this->status'"
                . "WHERE id=$this->state_id";
            DBWrapper::insert($updateSQL);
        } else {
            $insertSQL = "INSERT INTO "
                . "state(status)"
                . "VALUES('$this->status');";

            $this->state_id = DBWrapper::insert($insertSQL);
        }
    }

    public static function getByStatus($searchStatus) {
        $selectSQL = "SELECT * FROM state"
            . " WHERE status='$searchStatus'";
        $results = DBWrapper::select($selectSQL);

        $result =  $results[0];

        $toReturn = new State($result['status']);
        $toReturn->setId((int)$result['id']);

        return $toReturn;
    }



}