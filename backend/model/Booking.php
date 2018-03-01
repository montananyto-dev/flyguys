<?php
require_once( __DIR__ . "/Entity.php");
require_once(__DIR__ . '/../database/DBWrapper.php');

class Booking extends Entity
{
    private $book_id;
    private $account;
    private $state;
    private $booking_date;

    function __construct(Account $acc, State $state, $booking_date)
    {
        $this->account = $acc;
        $this->state = $state;
        $this->booking_date = $booking_date;
    }

    function save()
    {

        $this->account->save();
        if (isset($this->book_id) && $this->modified) {
            $updateSQL = "UPDATE booking "
                . "SET account_id = '$this->account->acc_id', state_id='$this->state->state_id', booking_date='$this->booking_date' "
                . "WHERE id=$this->acc_id";
            DBWrapper::insert($updateSQL);
        } else {
            $acc_id = $this->account->getId();
            $stat_id = $this->state->getId();
            $insetSQL = "INSERT INTO "
                . "booking(account_id, state_id, booking_date) "
                . "VALUES('$acc_id', '$stat_id', '$this->booking_date');";

            $this->book_id = DBWrapper::insert($insetSQL);
        }
    }

    //TODO
    function getPassengers()
    {

    }
}


?>