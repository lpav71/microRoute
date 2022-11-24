<?php

namespace Controllers;

use Models\Region;
use Models\T5_News;
use System\View;

class Country
{
    public static function Test()
    {
        $region = new Region();
//        $region->insert()->values(['name'=>'ssss'])->execute();
//        $id = $region->lastInsertId();
//        $region->update()->values(['name'=>'ssss_aaaa'])->where(['id'=>$id])->execute();
//        $region->delete()->where(['id'=>'44'])->execute();
        /*$rows = $region->select(['region.id AS region_id', 'region.name AS region_name', 'locality.name AS locality_name'])
            ->join('locality', 'region.id', 'locality.region_id')
            ->limit(0,10)
            ->getModel();*/
        //$row = $region->select()->where(['name'=>'%Ира%'], 'LIKE')->all();
        //$pdo = $region->getPdo();
        //$row = $region->select()->whereIn('name',["'Иран'", "'Ирак'"])->all();
//        $row = $region->select()->whereBetween('id', '1', '10')->all();
        $rows = $region->select()->all();
        //$row = $region->select(['COUNT(*)'])->getOne();
        View::Render('country', compact('rows'));
    }
}
