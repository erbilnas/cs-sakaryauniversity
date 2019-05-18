<?php
/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 10.03.2016
 * Time: 17:02
 */

namespace cc;

require_once 'Kisi.class.php';

class Ogrenci extends \cc\Kisi
{
    private $ogrenciNo;

/*
    function __construct($ogrenciNo, $adi, $soyadi)
    {
        parent::__construct($adi,$soyadi);
        $this->setOgrenciNo($ogrenciNo);

    }*/

    /**
     * @return mixed
     */
    public function getOgrenciNo()
    {
        return $this->ogrenciNo;
    }

    /**
     * @param mixed $ogrenciNo
     */
    public function setOgrenciNo($ogrenciNo)
    {
        $this->ogrenciNo = $ogrenciNo;
    }

    public function __set($prop, $val) {
        $this->$prop = $val;
    }
    public function __get($prop) {
        return $this->$prop;
    }



    //  Farklı algoritmalar
    /**Strategy Pattern
     * Farklı algoritmalar farklı sınıflar içerisinde tanımlanarak zarflanıyor. İstemci kodu(bu sınıf)
     * algoritmaların gerçekleme kısımlarını bilmeden bu algoritmaları çalıştırabiliyor. Yeni bir algoritma gerekli olduğunda
     * istemci kodda değişiklik yapılmasına gerek kalmadan bu algoritmanında çalıştırılabilmesi sağlanıyor.
     *
     *
     * Buradaki yazdir fonksiyonu aynı zamanda adaptör tasarım desenidir. Kodunuzun yeni ihtiyaçlara uyum sağlamasına
     * imkan verir... xml, json, csv...
     *
     * @param $urunGoruntule
     * @return mixed
     */
    public function yazdir($kisiGoruntule) {
        return $kisiGoruntule->getKisi($this); //Çok Şekillilik


        /*if(format=="XML")
            ......
        ..........
        elseif(format=="text")
            .....
        ......
        else*/




        /* One important principle of OOP is that a class should do one thing, and it should do it well.

             With this in mind, conditional statements should be a red flag indicating that your class is trying to do too many different things. This is where polymorphism comes in.

         In our example, it is clear that there are two tasks presented: managing articles and formatting their data. In this tutorial, we will refactor our formatting code into a new set of classes and discover how easy it is use polymorphism.

         Polymorphism is an elegant way to escape from ugly conditional statements in your OOP code. It follows the principle of keeping your components separate, and is an integral part of many design patterns.

         Kod tekrar kullanımı geliştirilir. Yazıcı sınıfları başka modüller de de rahtça kullanılabilir.
         */

    }


}