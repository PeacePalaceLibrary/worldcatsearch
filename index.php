<?php

require './config/config.php';

function API_request($config) {
	$curl = curl_init();
	
	curl_setopt($curl, CURLOPT_URL, $config['url'].$config['query']."&wskey=".$config['wskey']);
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

$result = API_request($config);

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