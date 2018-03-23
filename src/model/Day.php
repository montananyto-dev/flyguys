<?php

class Day
{
    private $position;

    public function __construct($dayStr)
    {
        switch (strtoupper($dayStr)) {
            case "MONDAY":
                $this->position=0;
                break;
            case "TUESDAY":
                $this->position=1;
                break;
            case "WEDNESDAY":
                $this->position=2;
                break;
            case "THURSDAY":
                $this->position=3;
                break;
            case "FRIDAY":
                $this->position=4;
                break;
            case "SATURDAY":
                $this->position=5;
                break;
            case "SUNDAY":
                $this->position=6;
                break;
            default:
                $this->position = -1;
        }
    }

    function __get($name)
    {
        return $this->$name;
    }

}
