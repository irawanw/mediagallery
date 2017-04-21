<? include("header.php"); ?>

	<div class="container">

		<? include("navigation.php"); ?>
		
		<div class="jumbotron">
			<?			
				$customer = new Customer;
				$db->where ('emailaddress', $_POST['emailaddress']);
				$user = $db->getOne("customers");		
				if($user['id'] == ''){
					echo "Sorry we can't find your email address.";
				} else {
					echo "Email address found! Please wait...";
					echo 	'<script>
						window.setTimeout(function(){
							// Move to a new location or you can do something else
							window.location.href = "'.WEBROOT.'/my-videos/?email='.$user['emailaddress'].'&id='.$user['id'].'";
						}, 1000);
					</script>';
				}
			?>
		</div>
		
	</div>
		
<? include("footer.php"); ?>  