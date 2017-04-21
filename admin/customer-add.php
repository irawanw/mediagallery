<? include("../header.php"); ?>
<? include("navigation.php"); ?>
	<div class="container">
		<div class="jumbotron">		
			<script>
				$(document).ready(function(){
					$('.form-signin').validate();
				})
			</script>		
			<form class="form-signin" action="customer-add-process.php" method="post">
				<h2 class="form-signin-heading">Add Customer</h2>				
				<label for="firstname" class="sr-only">Firstname</label>
				<input type="text" id="firstname" name="firstname" class="form-control" placeholder="Firstname" autofocus required>	
				<label for="lastname" class="sr-only">Lastname</label>
				<input type="text" id="lastname" name="lastname" class="form-control" placeholder="Lastname" required>	
				<label for="inputEmail" class="sr-only">Email address</label>
				<input type="email" id="inputEmail" name="emailaddress" class="form-control" placeholder="Email address" required>								
				<br>
				<button class="btn btn-theme" type="submit">Add Account</button>
			</form>		
		</div>
	</div>		
<? include("../footer.php"); ?>  