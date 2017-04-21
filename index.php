<? 
	include("header.php"); 
	
	//for unifi auth
	if(isset($_GET['id'])){
		$_SESSION['id'] = $_GET['id'];          		//user's mac address
		$_SESSION['ap'] = $_GET['ap'];          		//AP mac
		$_SESSION['ssid'] = $_GET['ssid'];      		//ssid the user is on (POST 2.3.2)
		$_SESSION['time'] = $_GET['t'];         		//time the user attempted a request of the portal
		$_SESSION['refURL'] = $_GET['url'];     		//url the user attempted to reach
		$_SESSION['loggingin'] = "ch1ch4go skyd1v3!"; //key to use to check if the user used this form or not
	}
?>

<? include("navigation.php"); ?>	
		
				<? if(is_logged()){ ?>	
				
					<h1>Retrieve your images / video here</h1>
								
					<h2 class="subtitle">Hello, <?=$_SESSION['user']['lastname']?></h2>
					<p><a class="btn btn-theme" href="<?=$_SESSION['refURL'];?>" role="button">Continue Browsing</a></p>						
				
				<? } else { ?>
				
					<h1>Retrieve your images / video here</h1>
					<form class="form-signin" action="login-process.php" method="post">
						<h2 class="subtitle">Please fill your email address</h2>
						<label for="inputEmail" class="sr-only">Email address</label>
						<input type="email" id="inputEmail" name="emailaddress" class="form-control" placeholder="Email address" required autofocus>						
						<button class="btn btn-theme" type="submit">Submit</button>
					</form>	
				
				<? } ?>						
	
<? include("footer.php"); ?>    