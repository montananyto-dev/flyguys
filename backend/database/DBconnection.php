<?php


try {
    $connection = new PDO('mysql:localhost;port=3306;dbname=flyguys', 'root', '');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Connection success';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}