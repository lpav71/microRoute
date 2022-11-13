<?php


namespace System;

use PDO;
class DB
{
    public static function Connect() {
        $data = Configurator::GetDBConfiguration();

        $user = $data['DBUSER'];
        $pass = $data['DBPASS'];
        $host = $data['DBHOST'];
        $db   = $data['DBNAME'];
        
        return new PDO("mysql:dbname=$db;host=$host", $user, $pass);
    }
}