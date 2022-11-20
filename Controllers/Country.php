<?php

namespace Controllers;

use Models\Region;
use System\DB;
use System\View;

class Country
{
    public static function Test()
    {
        $region = new Region();
        $countries = $region->select()->execute();
        View::Render('country', compact('countries'));
    }
}
