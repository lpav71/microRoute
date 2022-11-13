<?php

namespace Controllers;

use System\DB;
use System\View;

class Country
{
    public static function Test()
    {
        $db = DB::Connect();
        $query = 'SELECT * FROM region';
        $stmt = $db->query($query);
        $countries = $stmt->fetchAll();
        View::Render('country', compact('countries'));
    }
}
