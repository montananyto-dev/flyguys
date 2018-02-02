<?php


class Test
{

    public static function insert($sql)

    {

        global $connection;

        $statement = $connection->query($sql);
        $statement->execute();
        $results = $statement->fetchAll();

        var_dump($results);
        return $results;

    }

}