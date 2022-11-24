<?php


namespace System;


class Configurator
{
    private static $fileConfig = '.conf';

    public static function GetDBConfiguration()
    {
        if (is_file(self::$fileConfig)) {
            $data = file(self::$fileConfig, FILE_IGNORE_NEW_LINES);
            $result = [];
            foreach ($data as $item) {
                $value = explode('=', $item);
                $value[0] = trim($value[0]);
                $value[1] = trim($value[1]);
                $result[$value[0]] = $value[1];
            }
        }
        return $result;
    }
}