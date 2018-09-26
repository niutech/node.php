<?php


/**
 * Node.php v0.4
 * (c) 2016 Jerzy Głowacki
 * MIT License
 */

error_reporting(0);
set_time_limit(120);

define("NODE_DIR", "node");
define("NODE_PORT", 49999);

function node_serve($path = "") {

	if(!file_exists(NODE_DIR)) {
        
        header('HTTP/1.0 404 Not Found');
        exit;
        
	}
	
	$node_pid = intval(file_get_contents("nodepid"));
	if($node_pid === 0) {
        
        header('HTTP/1.0 503 Service Unavailable');
        echo "Server down, help me!\n";
        exit;
        
	}
	
	$curl = curl_init("http://127.0.0.1:" . NODE_PORT . "/$path");
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
    $headers = array();
    foreach(getallheaders() as $key => $value) {
        $headers[] = $key . ": " . $value;
    }
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $_SERVER["REQUEST_METHOD"]);
    
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($_POST));
        
    }
    
 	$resp = curl_exec($curl);
 	
	if($resp === false) {
	
		header('HTTP/1.0 404 Not Found');
        exit;
        
	} else {
	
		list($head, $body) = explode("\r\n\r\n", $resp, 2);
		$headarr = explode("\n", $head);
		foreach($headarr as $headval) {
			header($headval);
		}
		echo $body;
		
	}
	
	curl_close($curl);
}

function node_dispatch() {
	isset($_GET['path']) ? node_serve($_GET['path']) : node_serve();
}

node_dispatch();
