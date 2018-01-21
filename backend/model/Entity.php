<?php 
abstract class Entity {
    function __constructor() {
        $DB = new DBConnection();
    }

    abstract function save();
}