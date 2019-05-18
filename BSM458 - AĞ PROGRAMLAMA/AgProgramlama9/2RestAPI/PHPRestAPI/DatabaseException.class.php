<?php
	class DBException extends Exception
	{
		public function hataGoruntule()
		{

            // loglama
            // eposta gonder...



			echo "Message: " . $this -> getMessage() . "<br />";
			//echo "File: " . $this -> getFile() . "<br />";
			//echo "Line: " . $this -> getLine();
		}

	}
