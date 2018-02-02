<?php

require_once('DBconnection.php');

class Test
{

    public static function insert($sql)

    {

        global $connection;

        echo'test';
        var_dump($connection);
        var_dump($sql);
        $statement = $connection->query($sql);
        $statement->execute();


        $results = $statement->fetchAll();

        var_dump($results);
        return $results;

    }

}