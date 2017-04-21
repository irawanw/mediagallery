<?
$test_array = array (
  '2F822Rw39fx762MaV7Yy86jXGTC7sCDy' => 'api-key',
  $_GET['token-id'] 	=> 'token-id',
);

$URL = "https://secure.nmi.com/api/v2/three-step";
$xml = new SimpleXMLElement('<complete-action/>');
array_walk_recursive($test_array, array ($xml, 'addChild'));
$xml_data = $xml->asXML();

$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_MUTE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

echo $output;
?>