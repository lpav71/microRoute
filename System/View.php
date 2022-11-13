<?php


namespace System;

use Views\Layout;
class View
{
    public static function Render(string $view, $vars = null, $css=[], $js=[]) {
        $title = $_SERVER["QUERY_STRING"];
        if ($title == '') $title = 'home/index';
        Layout::Header($title, $css);
        isset($vars) ? (extract($vars)) : null;
        include "Views/" . $view . '.php';
        Layout::Footer($js);
    }
}