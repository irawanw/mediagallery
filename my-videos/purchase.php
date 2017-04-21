<? 
	include("../header.php"); 
	$customer 	= new Customer;
	$payment	= new Payment;
	
	$customerdata = $customer->getbyid(intval($_GET['id']));
		
	if(isset($_POST['firstname'])){	
		//get last id of customer table		
		$theid 		= $customer->getlastid();
		
		//preparing transaction data		
		$transdata 	= $_POST;
		
		//if there is normal gallery then charge $40 else charge $69
		$i = 0;
		//check if there is picture in normal gallery
		foreach(glob('../admin/server/php/files/'.$_GET['id'].'/*{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF,*.tif,*.TIF,*.bmp,*.BMP}', GLOB_BRACE) as $file) {
			$i++;
		}
		//check if there is video in normal gallery
		foreach(glob('../admin/server/php/files/'.$_GET['id'].'/{*.avi,*.AVI,*.flv,*.FLV,*.mkv,*.MKV,*.mp4,*.MP4,*.mov,*.MOV,*.wmv,*.WMV}', GLOB_BRACE) as $file) {	
			$i++;
		}
		if($i>0){
			$transdata['selfie'] 	= 0;
			$amount					= transAmount;
		}
		else{
			$transdata['selfie'] 	= 1;		
			$amount					= selfieAmount;
		}
		
		//echo "<pre>";
		//print_r($transdata);
		//echo "</pre>";
		
		$formurl 	= $payment->inittransaction($transdata);
	}
?>

	<div class="container" style="padding-top: 50px;">

	<? 	include("../navigation.php"); ?>
			
	<? 	
		//check customer data match or not
		$data		= $customer->getbyid(intval($_GET['id'])); 		
		if($data['emailaddress'] != $_GET['email']) { 
			echo "<br>Sorry we can't find your email address.</div>";
			exit();
		}
	?>
	
	<? 
		if($_GET['token-id'] != '') { 
			//if there is normal gallery then charge $40 else charge $69
			$i = 0;
			//check if there is picture in normal gallery
			foreach(glob('../admin/server/php/files/'.$_GET['id'].'/*{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF,*.tif,*.TIF,*.bmp,*.BMP}', GLOB_BRACE) as $file) {
				$i++;
			}
			//check if there is video in normal gallery
			foreach(glob('../admin/server/php/files/'.$_GET['id'].'/{*.avi,*.AVI,*.flv,*.FLV,*.mkv,*.MKV,*.mp4,*.MP4,*.mov,*.MOV,*.wmv,*.WMV}', GLOB_BRACE) as $file) {	
				$i++;
			}
			if($i>0){
				$amount					= transAmount;
			}
			else{
				$amount					= selfieAmount;
			}
			//if token-id exist lets execute the transaction
			$payment->executetransaction($_GET['token-id'], $amount);
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
				<form class="form-signin" action="" method="post">
					<h2 class="form-signin-heading">Purchase Gallery</h2>
					
					<div class="clear"><i>Personal Information</i></div>
					<label for="firstname" class="sr-only">Firstname</label>
					<input type="text" id="firstname" name="firstname" class="form-control" placeholder="Firstname" autofocus required>	
					<label for="lastname" class="sr-only">Lastname</label>
					<input type="text" id="lastname" name="lastname" class="form-control" placeholder="Lastname" required>	
					<label for="inputEmail" class="sr-only">Email address</label>
					<input type="email" id="inputEmail" name="emailaddress" class="form-control" placeholder="Email address" required>	
					
					<? 
					/*
					<label for="password" class="sr-only">Password</label>
					<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>	
					<label for="passwordconfirm" class="sr-only">Password Confirm</label>
					<input type="password" id="passwordconfirm" name="passwordconfirm" class="form-control" placeholder="Password Confirm" required>	
					*/ 
					?>
					
					<div class="clear"><i>Billing Information</i></div>
					<label for="address1" class="sr-only">Address</label>
					<input type="text" id="address1" name="address1" class="form-control" placeholder="Address" required>	
					<label for="city" class="sr-only">City</label>
					<input type="text" id="city" name="city" class="form-control" placeholder="City" required>	
					<label for="state" class="sr-only">State</label>
					<input type="text" id="state" name="state" class="form-control" placeholder="State" required>
					<label for="zipcode" class="sr-only">Zip</label>
					<input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="Zip" required>					
					
					<button style="width: 150px" class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Submit</button>
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
					<i><b>Amount to be paid $<?=$amount;?></b></i><br><br>
					
					<button style="width: 200px" class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Purchase Gallery</button>
				</form>
			<? } ?>
			
		<? } ?>
		
	</div>
		
<? include("../footer.php"); ?>  