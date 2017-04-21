<? 
	include("../header.php"); 
	include("session.php");
		
	if(isset($_POST['submit'])){
		unset($data);
		$data['value'] = $_POST['paid_devices'];
		$db->where ('fieldname', 'paid_devices', "=");
		$id = $db->update('general', $data);
		
		unset($data);
		$data['value'] = $_POST['monthly_cost'];
		$db->where ('fieldname', 'monthly_cost', "=");
		$id = $db->update('general', $data);
	}
	
	$db->where ('fieldname', 'paid_devices', "=");
	$paid_devices = $db->getOne('general');
	
	$db->where ('fieldname', 'monthly_cost', "=");
	$monthly_cost = $db->getOne('general');	
?>

<? include("navigation.php"); ?>
	<div class="container">
		<div class="jumbotron">		
			<script>
				$(document).ready(function(){
					$('.form-signin').validate();
				})
			</script>
		
			<form class="form-signin" action="general-setting.php" method="post">
				<h2 class="form-signin-heading">General Setting</h2>
				
				<div class="clear"><i>Payment Setting</i></div><br>
				<label for="paid_devices" class="">Number of Allowed Devices</label>
				<input value="<?=$paid_devices['value']?>" type="text" id="paid_devices" name="paid_devices" class="form-control" placeholder="Number of Allowed Devices" autofocus required>	
				<label for="monthly_cost" class="">Monthly Cost</label>
				<input value="<?=$monthly_cost['value']?>" type="text" id="monthly_cost" name="monthly_cost" class="form-control" placeholder="Monthly Cost ($)" required>				
				
				<button class="btn btn-theme" type="submit" name="submit">Save Setting</button>
			</form>		
		</div>
	</div>
		
<? include("../footer.php"); ?>  