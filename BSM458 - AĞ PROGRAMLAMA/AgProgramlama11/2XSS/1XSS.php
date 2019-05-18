<?php
/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 18.11.2014
 * Time: 03:11
 */

/** Defence
 *  Input Filtering :  Sanitize & Validate
 *  Output Encoding
 */

// input these messages to the textbox-
// <script>alert('xy');</script>
// <script>alert(document.cookie);</script>


	if(isset($_POST['adi']))
    {
            $input=$_POST['adi'];
            echo($input);
            //echo htmlentities($input) ;


       /*   HTML Entity Encoding (Convert < to &lt;  Convert > to &gt;)
            HTML Attribute Encoding
            URL Encoding
            JavaScript Encoding
            CSS Hex Encoding
       */

        //$input = filter_var($input, FILTER_SANITIZE_ENCODED);

        //$input = filter_var($input, FILTER_SANITIZE_STRING);
       // $input = filter_var($input, FILTER_SANITIZE_STRING);
        //echo htmlentities($input) ;
       // echo htmlspecialchars($input) ;
       // echo urlencode($input) ;

        // If you can see the text in your input box, it means the input is not filtered or encoded



        //echo $input ;
       // echo "123" ;

	}
?>
<form  method="POST" action="1XSS.php">
    First name: <input type="text" name="adi" /><br />
    <input type="submit" value="Submit" />
</form>

