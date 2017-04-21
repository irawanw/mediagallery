<? 
	include("../header.php"); 
	include("session.php");
	
	$customer 	= new Customer;
	$data		= $customer->getbyid(intval($_GET['id']));

	include("navigation.php"); 
?>
	<div class="container">
		<div class="jumbotron">			
	
			<script>
				$(document).ready(function(){
					$('.form-signin').validate({});
				})
			</script>
		
			<form class="form-signin" action="customer-add-process.php" method="post">
				<h2 class="form-signin-heading">Edit Customer</h2>				
				<label for="firstname" class="sr-only">Firstname</label>
				<input value="<?=$data['firstname']?>" type="text" id="firstname" name="firstname" class="form-control" placeholder="Firstname" autofocus required>	
				<label for="lastname" class="sr-only">Lastname</label>
				<input value="<?=$data['lastname']?>" type="text" id="lastname" name="lastname" class="form-control" placeholder="Lastname" required>	
				<label for="inputEmail" class="sr-only">Email address</label>
				<input value="<?=$data['emailaddress']?>" type="email" id="inputEmail" name="emailaddress" class="form-control" placeholder="Email address" required>				
				<input value="<?=$data['id']?>" type="text" id="id" name="id" class="form-control" required style="display:none">
				<br>
				<button class="btn btn-theme" type="submit">Edit Account</button>
			</form>
		</div>
	</div>
		
<? include("../footer.php"); ?>  