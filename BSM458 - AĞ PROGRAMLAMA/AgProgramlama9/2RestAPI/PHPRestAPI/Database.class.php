<?php
//echo "ClassVeritabaniMysqli" ;



/**
 * Class Veritabani
 */

class Database //implements VeritabaniArayuz
{
    private $databaseConnection;

    /**
     * @var :oluşan nesneyi gösterir (tutar). nesne oluşturmadan önce buraya bakacağımız için
     *(nesne zaten oluşturulmuş mu diye) static olması gerekir.
     */
    public static $instance;
    /**
     * @return mysqli
     */
    public function getDatabaseConnection()
    {
        return $this ->databaseConnection;
    }

    /**
     *Dışarıda nesne oluşturulamasın diye private ya da protected yapılır.
     * getInstance fonksiyonu nesne oluşturabilir.
     */
    private function __construct()
    {
        require_once(__DIR__.'/DatabaseCredentials.php');

        try
        {   //echo "$vtys:dbname=$veritabaniAdi";
            $this->databaseConnection = new PDO("$vtys:dbname=$veritabaniAdi;   host=localhost;   user=LectureUser;   password=LecturePassword");
           // $this->databaseConnection = new PDO("pgsql:dbname=OgrenciBilgiSistemi;   host=localhost;   user=LectureUser;   password=LecturePassword");

        } catch ( PDOException $e ){
           // echo "deneme";
            print $e->getMessage();
        }


    }

    /**
     *Nesne kopyalanmaya çalışılırsa (clone) bu fonksiyon private olduğu için hata verecek ve engellenecektir
     */
    private function __clone() {}

    //used static function so that, this can be called from other classes

    /**
     * @return Veritabani
     */
    public static function getInstance(){

        if( !(self::$instance instanceof self) ){

            self::$instance = new self();

        }
        return self::$instance;
    }

    /**
     *
     */
    public function __destruct()
    {

       $this->databaseConnection=null;

    }

}
