<?php
require_once("Entity.php");

class Booking extends Entity {
    private $book_id;
    private $account;
    private $state;
    private $booking_date;

    function __construct(Account $acc, $booking_date) {
        parent::__construct();
        $this->account=$acc;
        $this->booking_date=$booking_date;
    }

    function save() {
        if(isset($this->book_id)) {
            echo "Updating existing booking\n";
        } else {
            $this->account->save();
            echo "Inserting new booking\n";
        }
    }
}


?>