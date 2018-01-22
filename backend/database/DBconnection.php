<?php

Class DBConnection
{

    protected $_config;
    private $connection;

    public function __construct(array $config)
    {
        $this->_config = $config;
        $this->getPDOConnection();
    }

    public function __destruct()
    {
        $this->connection = NULL;
    }

    private function getPDOConnection()
    {

        if ($this->connection == NULL) {

            $dsn = "" . $this->_config['driver'] . ":host=" . $this->_config['host'] . ";dbname=" . $this->_config['dbname'];
            try {
                $this-> connection= new PDO($dsn, $this->_config['username'], $this->_config['password']);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                echo "Connected successfully";

            } catch (PDOException $e) {

                echo "Connection failed: " . $e->getMessage();
            }
        }
    }
}


