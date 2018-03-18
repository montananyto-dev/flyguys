<?php


class DBWrapper
{

    public static function insert($sql)
    {

        global $conn;

        $conn->query($sql);

        $last_id = $conn->lastInsertId();

        return (int)$last_id;

    }

    public static function select($sql)
    {
        global $conn;

        $results = $conn->query($sql)->fetchAll();

        return $results;
    }

}