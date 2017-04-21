<? include("../header.php"); ?>

<? include("navigation.php"); ?>
		
			<h1>Welcome!</h1>
			
			<? if(is_admin_logged()){ ?>		
				<h2 class="subtitle">Helo, <?=$_SESSION['admin']['lastname']?>!</h2>
			<? } else { ?>
				<h2 class="subtitle">To access administrator page please login using form below</h2>
				<form class="form-signin" action="login-process.php" method="post">
					<label for="inputEmail" class="sr-only">Email address</label>
					<input type="email" id="inputEmail" name="emailaddress" class="form-control" placeholder="Email address" required autofocus>
					<label for="inputPassword" class="sr-only">Password</label>
					<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
					<button class="btn btn-theme" type="submit">Sign in</button>
				</form>
				<br>
				<div style="color: white;">
					<b>Demo Admin<br>
					user : admin@demo.com<br>
					pass : 1234
					</b>
				</div>
			<? } ?>

<? include("../footer.php"); ?>    