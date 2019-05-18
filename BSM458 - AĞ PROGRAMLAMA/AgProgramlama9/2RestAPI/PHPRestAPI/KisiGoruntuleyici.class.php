<?php
/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 15.03.2016
 * Time: 11:20
 */

namespace cc;

require_once (__DIR__.'/Kisi.class.php');


abstract class KisiGoruntuleyici
{
    protected $kisiler = array();     // Çocuk sınıfların doğrudan erişebilmesi  için	protected


    public function setKisiler(\cc\Kisi $kisi)
    {
        $this -> kisiler[] = $kisi;
    }

    abstract public function getKisiler(); // soyut fonksiyonların gerçekleme kısmı bulunmaz
    abstract public function getKisi($kisi);
}