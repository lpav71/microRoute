<?php

namespace Controllers;
use System\ORM;
use System\View;

class Home
{
    public static function Index() {
        $sql = ORM::Instance();
        $rows = $sql->select('region')->limit(0,5)->execute();
        View::Render('home');
    }
}