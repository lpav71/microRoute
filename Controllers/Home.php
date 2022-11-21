<?php

namespace Controllers;
use Models\Region;
use System\View;

class Home
{
    public static function Index() {
        $region = new Region();
        $rows = $region->select()->limit(0,5)->execute();
        View::Render('home');
    }
}