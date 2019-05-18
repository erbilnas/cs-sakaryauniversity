<?php
/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 15.03.2015
 * Time: 02:08
 */

require_once(__DIR__ . '/Logger.class.php');
//require_once(__DIR__ . '/../Classes/DatabaseException.class.php');
// __DIR__ dosyanin bulunduğu dizin yolu döner.

try {
    $logger= Logger::getInstance('Log.txt');

} catch (Exception $e) {
    echo $e->hataGoruntule();
    //exit(1);
}

