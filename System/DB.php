<?php


namespace System;

use PDO;
class DB
{
    public $pdo;

    public function Connect() {
        $data = Configurator::GetDBConfiguration();

        $user = $data['DBUSER'];
        $pass = $data['DBPASS'];
        $host = $data['DBHOST'];
        $db   = $data['DBNAME'];
        
        $this->pdo = new PDO("mysql:dbname=$db;host=$host", $user, $pass);
    }
}