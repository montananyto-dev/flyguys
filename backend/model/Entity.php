<?php

abstract class Entity
{

    function __construct()
    {
        print "Entity creating DB conneciton \n";
    }

    abstract function save();


}