<?php

require_once('DBconnection.php');

class DBWrapper
{

    public static function insert($sql)
    {

        global $connection;

        $connection->query($sql);

        $last_id = $connection->lastInsertId();

        return (int)$last_id;

    }

    public static function select($sql)
    {
        global $connection;

        $results = $connection->query($sql)->fetchAll();

        return $results;
    }

}