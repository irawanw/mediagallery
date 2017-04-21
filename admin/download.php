<?
include("../includes/connections.php");	
include("../includes/classes/customer.class.php");
if($_GET['id'] && $_GET['code']){
	$customer 	= new Customer;
	$customer->setstatus(intval($_GET['id']), 2);	
	foreach(glob('server/php/files/'.$_GET['id'].'/*.*') as $file) {
		if(md5(basename($file).SECRET_HASH) == $_GET['code']){
			$file_url = $file;
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
			readfile($file_url); 
		}
	}
} else {
	echo "Sorry you are not allowed to access this page.";
} ?>