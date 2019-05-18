<?php
/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 15.03.2015
 * Time: 02:08
 */

require_once(__DIR__ . '/Database.class.php');
require_once(__DIR__ . '/DatabaseException.class.php');
// __DIR__ dosyanin bulunduğu dizin yolu döner.

	try
    {
        $veritabaniNesnesi= Database::getInstance();

    }
    catch (DBException $e)
    {
        echo $e -> hataGoruntule();
        exit(1);
    }

    $veritabaniBaglantisi=$veritabaniNesnesi->getDatabaseConnection();
    //var_dump($veritabaniBaglantisi);

