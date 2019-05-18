<?php
/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 15.03.2016
 * Time: 11:24
 */

namespace cc;

require_once (__DIR__.'/Ogrenci.class.php');
require_once (__DIR__.'/KisiGoruntuleyici.class.php');


class OgrenciGoruntuleJSON extends \cc\KisiGoruntuleyici
{
    public function getKisiler()
    {

        foreach ($this->kisiler as $ogrenci)
        {
            $str[]= array('ogrenciNo' => $ogrenci->getOgrenciNo(),'adi' => $ogrenci->getAdi(), 'soyadi' => $ogrenci->getSoyadi());
            return json_encode($str);
            //print_r($urun);
        }

        print json_encode($str);
    }

    public function getKisi($ogr)
    {
        $arr = array('ogrenciNo' => $ogr->getOgrenciNo(),'adi' => $ogr->getAdi(), 'soyadi' => $ogr->getSoyadi());
        return json_encode($arr);


    }

}