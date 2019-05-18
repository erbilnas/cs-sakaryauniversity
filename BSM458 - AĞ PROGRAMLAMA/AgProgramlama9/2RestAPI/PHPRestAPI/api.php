<?php
    
	/* 
		This is an example class script proceeding secured API
		To use this class you should keep same as query string and function name
		Ex: If the query string value rquest=delete_user Access modifiers doesn't matter but function should be
		     function delete_user(){
				 You code goes here
			 }
		Class will execute the function dynamically;
		
		usage :
		
		    $object->response(output_data, status_code);
			$object->_request	- to get santinized input 	
			
			output_data : JSON (I am using)
			status_code : Send status message for headers
			
		Add This extension for localhost checking :
			Chrome Extension : Advanced REST client Application
			URL : https://chrome.google.com/webstore/detail/hgmloofddffdnphfgcellkdfbfbjeloo
		
		I used the below table for demo purpose.
		
		CREATE TABLE IF NOT EXISTS `users` (
		  `user_id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_fullname` varchar(25) NOT NULL,
		  `user_email` varchar(50) NOT NULL,
		  `user_password` varchar(50) NOT NULL,
		  `user_status` tinyint(1) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`user_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 	*/
	
require_once("Rest.inc.php");

require_once("Ogrenci.class.php");
require_once ("OgrenciGoruntuleJSON.class.php");

	class API extends REST {
	
		private $data = array();

		
		private $db = NULL;
	
		public function __construct(){
			parent::__construct();				// Init parent contructor
			include(__DIR__.'/DatabaseConnection.php');
			$this->db=$veritabaniBaglantisi;// Initiate Database connection
		}
		

		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){


            $urlParts = parse_url($_SERVER['REQUEST_URI']);

            parse_str($urlParts['query'], $query);
            $this->data=array('param1'=> $query['id']);

            parse_str($urlParts['path'], $path);

            $func=key($path); //yol bilgisi $path ilintili dizisi içerisinde anahtar olarak bulunuyor

            $func=explode("/",$func);
            $func=end($func);

            $this->$func();
			//else
			//	$this->response('',404);				// If the method not exist with in this class, response would be "Page not found".
		}
		
		/* 
		 *	For Authentication
		 */
		
		private function login()
        {

		}
		
		private function getStudents()
        {


			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}

			$sql="SELECT \"ogrenciNo\", \"adi\", \"soyadi\" FROM \"Ogrenci\"";
			$query = $this->db->prepare($sql);
			if($query->execute()> 0)
			{
				$query->setFetchMode(PDO::FETCH_CLASS, "\cc\Ogrenci");
				$ogrenciler=$query->fetchAll();
				$jsonGoruntuleyici= new \cc\OgrenciGoruntuleJSON();
				$str='[';
				foreach($ogrenciler as $ogrenci)
					$str.=$jsonGoruntuleyici->getKisi($ogrenci).',';
				$str=$str.']';

				//echo $str;
				$this->response($str, 200);
			} else
			$this->response('',204);	// If no records "No Content" status*/
		}


        private function getStudent(){

		    //﻿curl --request GET "localhost/SecureSoftwareDevelopment/Lecture5WebService/RestfulAPI/api.php/user?id='1'"


            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }


            $id = $this->data["param1"];


            $sql="SELECT \"ogrenciNo\", \"adi\", \"soyadi\" FROM \"Ogrenci\" WHERE \"ogrenciNo\"=$id ";
            $query = $this->db->prepare($sql);
            if($query->execute()> 0)
            {
                $query->setFetchMode(PDO::FETCH_CLASS, "\cc\Ogrenci");
                $ogrenciler=$query->fetchAll();
                $jsonGoruntuleyici= new \cc\OgrenciGoruntuleJSON();

                    $str=$jsonGoruntuleyici->getKisi($ogrenciler[0]);

                $this->response($str, 200);
            } else
                $this->response('',204);	// If no records "No Content" status
        }


		
		private function deleteStudent()
        {

		}

        private function insertStudent()
        {

        }
		


	}
	
	// Initiiate Library
	
	$api = new API;
	$api->processApi();