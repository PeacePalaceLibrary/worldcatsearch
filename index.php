<?php

require './config/config.php';

function WC_opensearch_request($config) {
	$curl = curl_init();
	
	curl_setopt($curl, CURLOPT_URL, $config['opensearch_url'].'?'.http_build_query($config['opensearch_params']));
	
	curl_setopt($curl, CURLOPT_HTTPHEADER, $config['opensearch_headers']);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$result = curl_exec($curl);
	$error_number = curl_errno($curl);
	//echo $error_number;
	if ($error_number) {
		$result = "Error: ".$error_number.": ".curl_error($curl)."\n".$result;
	}
	curl_close($curl);
	return $result;
}

function WC_read_request($config,$ocn) {
  
  $read_url = $config['read_url'].'/'.$ocn;
	if (count($config['read_params'])>0) {
	  $read_url = $read_url.'?'.http_build_query($config['read_params']);
	}
  echo $read_url;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $read_url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $config['read_headers']);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
	/*
	curl_setopt($curl, CURLOPT_VERBOSE, true);
	$verbose = fopen('stderr.txt', 'w+');
	*/

	$result = curl_exec($curl);
	//echo 'Result: '.$result;
	$error_number = curl_errno($curl);
  //echo "Error: ".$error_number." - ".curl_error($curl);
	
	if ($error_number) {
		$result = "Error: ".$error_number.": ".curl_error($curl)."\n".$result;
	}
	curl_close($curl);
	$result = json_decode($result,TRUE);
	return $result;
}


?>

<html>
	<head>
	   
	</head>
	<body>
		<p>Config:
			<pre><?php echo json_encode($config, JSON_PRETTY_PRINT);?></pre>
		</p>
    <?php $result = WC_read_request($config,"920681646"); ?>
		<p>Read ocn: 496689980 
			<pre><?php echo json_encode($result, JSON_PRETTY_PRINT);?></pre>
		</p>
 		<p>Result:
			<pre><?php $result = WC_opensearch_request($config);echo $result;?></pre>
		</p>
	</body>
	
</html>