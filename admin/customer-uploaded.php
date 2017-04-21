<? 
	include("../includes/connections.php");
	include("../includes/functions.php");
	include("../includes/classes/customer.class.php");
	include("../admin/session.php");
	
	$customer 	= new Customer;
	$customer->setstatus(intval($_GET['id']), 1);
	
	$data		= $customer->getbyid(intval($_GET['id']));
	
	$subject	= "Your First Jump video is ready!";
	$headers 	= "From: Skydiving" . "\r\n";
	$headers 	.= "MIME-Version: 1.0\r\n";
	$headers 	.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers 	.= 'Cc: warren@jtechgrp.com' . "\r\n";
	
	$message	=
	'Hello '.$data['firstname'].' '.$data['lastname'].', Thanks for jumping with us! We hope to see you back in the sky soon. 
		Below are your video and pictures from your jump. If you have any questions, please give us a call at 815-433-0000<br><br>
		
	<table style="border: none">';	
	
	$i = 0;
	foreach(glob('server/php/files/'.$_GET['id'].'/*.*') as $file) {
		$files[$i]['hash'] = md5(basename($file).SECRET_HASH);
		$files[$i]['file'] = basename($file);
		//echo '<img src="http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/server/php/files/'.$_GET['id'].'/thumbnail/'.$files[$i]['file'].'"><br>';
		//echo $files[$i]['hash']."<br>";
		$i++;
	}
	
	foreach($files as $row){
		$message .= '<tr>
						<td><img src="http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/server/php/files/'.$_GET['id'].'/thumbnail/'.rawurlencode($row['file']).'"><td>
						<td><a href="http://'.$_SERVER['HTTP_HOST'].WEBROOT.'/admin/download.php?id='.$_GET['id'].'&code='.$row['hash'].'">'.$row['hash'].'</a></td>
					</tr>';
	}
	$message .= '</table>';
	
	echo $message;
	
	mail($data['emailaddress'], $subject, $message, $headers);
?>	