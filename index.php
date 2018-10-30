<?php

require './OCLC/Auth/WSKey.php';
require './OCLC/User.php';

//TODO functions in een apart bestand

function get_config($file_name) {
	//reads a json file with data needed for connecting to the API
	//returns FALSE if something goes wrong
	if (file_exists($file_name)) {

		$file_read = file_get_contents($file_name);
		if ($file_read === FALSE) {
			//echo "file $file_name could not be read.";
			return FALSE;
		}
		else {
			$config = json_decode ($file_read, TRUE);
			if (json_last_error() == JSON_ERROR_NONE) {
				return $config;
			}
			else {
				echo json_last_error_msg();
				return FALSE;
			}
		}
	}
	else {
		return array();
	}
}

function get_auth_header($config) {
	if (array_key_exists('wskey',$config) && array_key_exists('secret',$config)) {
		$options = array();
		if (array_key_exists('institution',$config) && array_key_exists('ppid',$config) && array_key_exists('ppid_namespace',$config)) {
			//uses OCLC provided programming to get an autorization header
			$user = new User($config['institution'], $config['ppid'], $config['ppid_namespace']);
			$options['user'] = $user;
		}
		$wskey = new WSKey($config['wskey'], $config['secret'], $options);
		$authorizationHeader = $wskey->getHMACSignature('GET', $config['url'], $options);
		//check??
		array_push($config['headers'],'Authorization: '.$authorizationHeader);
	}
	return $config;
}

function API_request($config) {
	$curl = curl_init();
	
	curl_setopt($curl, CURLOPT_URL, $config['url']);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $config['headers']);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($curl, CURLOPT_, );
	//curl_setopt($curl, CURLOPT_, );

	$result = curl_exec($curl);
	$error_number = curl_errno($curl);
	//echo $error_number;
	if ($error_number) {
		$result = "Error: ".$error_number.": ".curl_error($curl)."\n".$result;
	}
	curl_close($curl);
	return $result;
}

$config = get_config('./config/config_loopbonnen.json');
if ($config === FALSE) {
	//something went wrong, no file or a json syntax error
}
else {
	//add authorization header to the headers in config
	$config = get_auth_header($config);
	$result = API_request($config);
}
?>

<html>
	<head>
	   
	</head>
	<body>
		<p>Config:
			<pre><?php echo json_encode($config, JSON_PRETTY_PRINT);?></pre>
		</p>
		<p>Result:
			<pre><?php echo $result;?></pre>
		</p>
	</body>
	
</html>