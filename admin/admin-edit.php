<? 
	include("../header.php"); 
	include("session.php");
	
	$customer 	= new Admin;
	$data		= $customer->getbyid(intval($_GET['id']));
?>

<? include("navigation.php"); ?>
	<div class="container">
		<div class="jumbotron">			
			<script>
				$(document).ready(function(){
					$('.form-signin').validate();
					$('#cc_exp').datepicker({
						changeMonth: true,
						changeYear: true,
						showButtonPanel: true,
						dateFormat: 'mm/y',
						onClose: function(dateText, inst) { 
							var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
							var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
							$(this).datepicker('setDate', new Date(year, month, 1));
						}
					});
				})
			</script>
			<style>
				.ui-datepicker-calendar {
					display: none;
				}
			</style>
		
			<form class="form-signin" action="admin-add-process.php" method="post">
				<h2 class="form-signin-heading">Edit Admin</h2>
				
				<div class="clear"><i>Personal Information</i></div>
				<label for="firstname" class="sr-only">Firstname</label>
				<input value="<?=$data['firstname']?>" type="text" id="firstname" name="firstname" class="form-control" placeholder="Firstname" autofocus required>	
				<label for="lastname" class="sr-only">Lastname</label>
				<input value="<?=$data['lastname']?>" type="text" id="lastname" name="lastname" class="form-control" placeholder="Lastname" required>	
				<label for="inputEmail" class="sr-only">Email address</label>
				<input value="<?=$data['emailaddress']?>" type="email" id="inputEmail" name="emailaddress" class="form-control" placeholder="Email address" required>	
				
				<label for="password" class="sr-only">Password</label>
				<input value="" type="password" id="password" name="password" class="form-control" placeholder="Password">	
				<label for="passwordconfirm" class="sr-only">Password Confirm</label>
				<input value="" type="password" id="passwordconfirm" name="passwordconfirm" class="form-control" placeholder="Password Confirm">	
				<input value="<?=$data['id']?>" type="text" id="id" name="id" class="form-control" required style="display:none">
				
				<button class="btn btn-theme" type="submit">Edit Account</button>
			</form>		
		</div>
	</div>
		
<? include("../footer.php"); ?>  