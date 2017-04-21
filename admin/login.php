<? include("../header.php"); ?>	

<? include("navigation.php"); ?>

	<div class="container">
		<div class="jumbotron">	
			<form class="form-signin" action="login-process.php" method="post">
				<h2 class="form-signin-heading">Please sign in</h2>
				<label for="inputEmail" class="sr-only">Email address</label>
				<input type="email" id="inputEmail" name="emailaddress" class="form-control" placeholder="Email address" required autofocus>
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
				<!--
				<div class="checkbox">
					<label>
					<input type="checkbox" value="remember-me"> Remember me
					</label>
				</div>-->
				<button class="btn btn-theme" type="submit">Sign in</button>
			</form>
			<br>
			Demo Admin<br>
			user : admin@demo.com<br>
			pass : 1234
		</div>
	</div>		
		
<? include("../footer.php"); ?>  		