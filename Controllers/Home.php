<?php

namespace Controllers;
use System\View;

class Home
{
    public static function Index() {
        View::Render('home');
    }
}