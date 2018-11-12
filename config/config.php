
<?php
//worldcatsearch config

$config = [];

$config['name'] = "NLVRD";
$config['institution'] = "57439";
$config['defaultBranch'] = "262638";

$config['datacenter'] = "sd02";
$config['wskey'] = "tA2yibd4vmeqTt7TYEmYNOzLHUWEGGF07v3dlR8YnvQni9wI0DLpBbARZtOZXpDsCFELxwV202smYFx8";
$config['secret'] = "akpDcRzATqHZakmw3b76bvJcIDrNqGKY";
$config['ppid'] ="3ad48a9e-0ee7-4eec-b303-189a8f4af886";
$config['ppid_namespace'] = "urn:oclc:platform:".$config['institution'];

$config['auth_url'] = "http://www.worldcat.org/wskey/v2/hmac/v1";
$config['auth_headers'] = ["Accept: application/json"];

//search
$config['opensearch_url'] = "http://www.worldcat.org/webservices/catalog/search/worldcat/opensearch";
$config['opensearch_params'] = [
  'wskey' => $config['wskey'],
  'q' => 'Vredespaleis'
];
$config['opensearch_headers'] = ["Accept: application/atom+xml"];

//read one OCN 
// the url must be: http://www.worldcat.org/webservices/catalog/content/{OCLCNumber}
// wkkey lite: wskey in header
$config['read_url'] = "http://www.worldcat.org/webservices/catalog/content";
$config['read_params'] = [
  'wskey' => $config['wskey']
];
$config['read_headers'] = ["Accept: application/json","wskey: ".$config['wskey']];

?>