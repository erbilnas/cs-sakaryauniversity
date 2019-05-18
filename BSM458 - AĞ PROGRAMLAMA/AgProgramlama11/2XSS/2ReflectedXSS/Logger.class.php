<?php
/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 20.03.2016
 * Time: 23:35
 */

//namespace cc;


class Logger
{
    /**
     * @var :oluşan nesneyi gösterir (tutar). nesne oluşturmadan önce buraya bakacağımız için
     *(nesne zaten oluşturulmuş mu diye) static olması gerekir.
     */
    public static $instance;

    protected $logFile = NULL;

    protected $timeFormat = 'd.m.Y - H:i:s';

    /**
     * The file permissions.
     */
    const FILE_CHMOD = 756;

    const INFO = '[INFO]';
    const WARNING = '[WARNING]';
    const ERROR = '[ERROR]';


    private function __construct($logfile) {
        if($this->logFile == NULL){
            $this->openLogFile($logfile);
        }
    }

    public function __destruct() {
        $this->closeLogFile();
    }

    /**
     *Nesne kopyalanmaya çalışılırsa (clone) bu fonksiyon private olduğu için hata verecek ve engellenecektir
     */
    private function __clone() {}

    //used static function so that, this can be called from other classes

    /**
     * @return Veritabani
     */
    public static function getInstance($logFile){

        if( !(self::$instance instanceof self) ){

            self::$instance = new self($logFile);

        }
        return self::$instance;
    }


    public function log($message, $messageType = Logger::WARNING) {
        if($this->logFile == NULL){
            throw new Exception('Logfile is not opened.');
        }

        if(!is_string($message)){
            throw new Exception('$message is not a string');
        }

        if($messageType != Logger::INFO &&
            $messageType != Logger::WARNING &&
            $messageType != Logger::ERROR
        ){
            throw new Exception('Wrong $messagetype given.');
        }

        $str= array('Zaman' => $this->getTime(),'mesajTuru' => $messageType, 'mesaj' => $message);

        $this->writeToLogFile(json_encode($str));
    }

    private function writeToLogFile($message) {
        flock($this->logFile, LOCK_EX);
        fwrite($this->logFile, $message.PHP_EOL);
        flock($this->logFile, LOCK_UN);
    }

    /**
     * Returns the current timestamp.
     *
     * @return string with the current date
     */
    private function getTime() {
        return date($this->timeFormat);
    }

    /**
     * Closes the current log file.
     */
    protected function closeLogFile() {
        if($this->logFile != NULL) {
            fclose($this->logFile);
            $this->logFile = NULL;
        }
    }


    public function openLogFile($logFile) {
        $this->closeLogFile();

        if(!is_dir(dirname($logFile))){
            if(!mkdir(dirname($logFile), Logger::FILE_CHMOD, true)){
                throw new Exception('Could not find or create directory for log file.');
            }
        }

        if(!$this->logFile = fopen($logFile, 'a+')){
            throw new Exception('Could not open file handle.');
        }
    }

}