<?php 
	$filename = 'data.txt';
	$last = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
	$current = filemtime($filename);

	while( $current <= $last) {
		usleep(100000); //mikro sn kadar bekle
		clearstatcache(); // If a file is being checked several times in a script, you might want to avoid caching to get correct results. To do this, use the clearstatcache() function.
		$current = filemtime($filename); // returns the last time the file content was modified. unix timestamp (January 1 1970)
	}
	
	$response = array();
	$response['msg'] = file_get_contents($filename);
	$response['timestamp'] = $current;
	echo json_encode($response);