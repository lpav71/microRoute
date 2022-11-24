<?php


namespace System;

use PDO;

class DB
{
    public $pdo;

    /**
     * @return mixed
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    public function Connect()
    {
        $config = json_decode(file_get_contents('config.json'), true) ;


        $user = $config["database"]["DBUSER"];
        $pass = $config["database"]["DBPASS"];
        $host = $config["database"]["DBHOST"];
        $db = $config["database"]["DBNAME"];

        $this->pdo = new PDO("mysql:dbname=$db;host=$host", $user, $pass);
    }
}