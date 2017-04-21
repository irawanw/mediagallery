<?php
//error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// SQL server connection information
$sql_details = array(
	'user' => 'iwikodev_test',
	'pass' => 'irawan123@@',
	'db'   => 'iwikodev_sdc',
	'host' => 'localhost'
);
//load mySQL class
require( 'classes/MysqliDB.php' );
//initialize database connection
$db = new MysqliDb (	
						$sql_details['host'], 
						$sql_details['user'], 
						$sql_details['pass'], 
						$sql_details['db']
					);
define("WEBROOT", "/mediagallery");
define("SECRET_HASH", 'mYf1Rs@tjump!from_th3SKY');

//tnbci key
define('APIKey', 'yfKEz5a7CvpSF47k8VufwjM5NKE42A7d');
define('gatewayURL', 'https://secure.tnbcigateway.com/api/v2/three-step');
define('transAmount', 40);
define('selfieAmount', 69);
?>