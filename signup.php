<? 
	include("header.php"); 
	$customer 	= new Customer;
	$payment	= new Payment;
	
	if(isset($_POST['firstname'])){	
		//get last id of customer table		
		$theid 		= $customer->getlastid();
		
		//preparing transaction data
		$transdata 	= $_POST;
		$formurl 	= $payment->inittransaction($transdata);
	}
?>

	<div class="container">

	<? include("navigation.php"); ?>
			
	<? 
		if($_GET['token-id'] != '') { 
			//if token-id exist lets execute the transaction
			$payment->executetransaction($_GET['token-id']);
		}
		
		//if token-id not exitst then draw a form
		else {
		?>
			<script>
				$(document).ready(function(){
					$('.form-signin').validate({
						rules: {
							password: "required",
							passwordconfirm: {
								equalTo: "#password"
							}
						}
					});
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
				
			<? if($formurl == ''){ ?>
				<form class="form-signin" action="signup.php" method="post">
					<h2 class="form-signin-heading">Please sign up</h2>
					
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
					
					<div class="clear"><i>Address Information</i></div>
					<label for="address1" class="sr-only">Address</label>
					<input type="text" id="address1" name="address1" class="form-control" placeholder="Address" required>	
					<label for="city" class="sr-only">City</label>
					<input type="text" id="city" name="city" class="form-control" placeholder="City" required>	
					<label for="state" class="sr-only">State</label>
					<input type="text" id="state" name="state" class="form-control" placeholder="State" required>
					<label for="zipcode" class="sr-only">Zip</label>
					<input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="Zip" required>
					
					<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign Up</button>
				</form>
			
			<? } else { ?>
				<form class="form-signin" action="<?=$formurl?>" method="post">			
					<h2 class="form-signin-heading">Please enter your credit card information</h2>
					
					<div class="clear"><i>Credit Card Information</i></div>
					<label for="cc_number" class="sr-only">CC Number</label>
					<input type="text" id="cc_number" name="billing-cc-number" class="form-control" placeholder="Credit Card Number" required>	
					<label for="cc_exp" class="sr-only">Exp Date</label>
					<input type="text" id="cc_exp" name="billing-cc-exp" class="form-control" placeholder="Exp Date" required>	
					<label for="cvv" class="sr-only">CVV</label>
					<input type="text" id="cvv" name="billing-cvv" class="form-control" placeholder="CVV" required>	
					
					<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Register</button>
				</form>
			<? } ?>
			
		<? } ?>
		
	</div>
		
<? include("footer.php"); ?>  