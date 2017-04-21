<? include("../header.php"); ?>
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
				<h2 class="form-signin-heading">Add Admin</h2>
				
				<div class="clear"><i>Personal Information</i></div>
				<label for="firstname" class="sr-only">Firstname</label>
				<input type="text" id="firstname" name="firstname" class="form-control" placeholder="Firstname" autofocus required>	
				<label for="lastname" class="sr-only">Lastname</label>
				<input type="text" id="lastname" name="lastname" class="form-control" placeholder="Lastname" required>	
				<label for="inputEmail" class="sr-only">Email address</label>
				<input type="email" id="inputEmail" name="emailaddress" class="form-control" placeholder="Email address" required>	
				
				<label for="password" class="sr-only">Password</label>
				<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>	
				<label for="passwordconfirm" class="sr-only">Password Confirm</label>
				<input type="password" id="passwordconfirm" name="passwordconfirm" class="form-control" placeholder="Password Confirm" required>	
				
			
				<button class="btn btn-theme" type="submit">Add Account</button>
			</form>
		
		</div>
	</div>
		
<? include("../footer.php"); ?>  