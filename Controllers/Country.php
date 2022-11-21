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
//        $region->update()->values(['name'=>'sssss'])->where(['id'=>'44'])->execute();
//        $region->delete()->where(['id'=>'44'])->execute();
        $rows = $region->select(['region.id AS region_id', 'region.name AS region_name', 'locality.name AS locality_name'])
            ->join('locality', 'region.id', 'locality.region_id')
            ->limit(0,10)
            ->getObject();
        $row = $region->select()->where(['id'=>'34'])->get();
        View::Render('country', compact('countries'));
    }
}
