<?php

include_once('environment.php');
class database
{
    private $connection;

    function __construct()
    {
        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    public function saveData($query)
    {
        try {
            return mysqli_query($this->connection, $query);
        } catch (Exception $e) {
            return $e;
        }
    }
}

