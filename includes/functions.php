<?
	function is_logged(){
		if(isset($_SESSION['user']['id'])){
			return 1;
		} else {
			return 0;
		}
	}
	
	function is_admin_logged(){
		if(isset($_SESSION['admin']['id'])){
			return 1;
		} else {
			return 0;
		}
	}
	
	function redirect($url = '', $time = 2000){		
				
		if(preg_match('/http/', $url))
			$url = $url;
		else
			$url = WEBROOT.'/'.$url;
		
		echo 	'<script>
					window.setTimeout(function(){
						// Move to a new location or you can do something else
						window.location.href = "'.$url.'";
					}, '.$time.');
				</script>';
	}
	
	function sendAuthorization($id, $minutes){
		$unifiServer = "https://204.152.38.233:8443";
		$unifiUser = "admin";
		$unifiPass = "3h2rpgqzb8ds";

		// Start Curl for login
		$ch = curl_init();
		// We are posting data
		curl_setopt($ch, CURLOPT_POST, TRUE);
		// Set up cookies
		$cookie_file = "/tmp/unifi_cookie";
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
		// Allow Self Signed Certs
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		// Force SSL3 only
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		// Login to the UniFi controller
		curl_setopt($ch, CURLOPT_URL, "$unifiServer/login");
		curl_setopt($ch, CURLOPT_POSTFIELDS,
			"login=login&username=$unifiUser&password=$unifiPass");
		// send login command
		curl_exec ($ch);

		// Send user to authorize and the time allowed
		$data = json_encode(array(
			'cmd'=>'authorize-guest',
			'mac'=>$id,
			'minutes'=>$minutes));

		// Send the command to the API
		curl_setopt($ch, CURLOPT_URL, $unifiServer.'/api/cmd/stamgr');
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'json='.$data);
		$login = curl_exec($ch);

		// Logout of the UniFi Controller
		curl_setopt($ch, CURLOPT_URL, $unifiServer.'/logout');
		curl_exec ($ch);
		curl_close ($ch);
		return $login;
	}
	
	function smtpmail($address, $subject, $body){
		include("classes/phpmailer.class.php");
		include("classes/smtp.class.php");
	
		$mail             = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;
		$mail->SMTPAuth   = true;
		$mail->Host       = "mail.skydivechicago.com";
		$mail->Port       = 25;                    
		$mail->Username   = "wwwmail@skydivechicago.com";
		$mail->Password   = "iwanttoskydive";
		$mail->SetFrom('info@skydivechicago.com', 'Skydive Chicago');
		$mail->AddReplyTo("info@skydivechicago.com","Skydive Chicago");
		$mail->AddAddress($address);
		$mail->Subject    = $subject;
		$mail->MsgHTML($body);

		if(!$mail->Send()) {
			return true;
		} else {
			return false;
		}
	}
?>