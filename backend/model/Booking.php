<?php
require_once("Entity.php");

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
        if (isset($this->book_id)) {
            echo "Updating existing booking\n";
        } else {

            echo "Inserting new booking\n";
        }
    }

    //TODO
    function getPassengers()
    {

    }
}


?>