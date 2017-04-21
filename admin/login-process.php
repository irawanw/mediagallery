<? include("../header.php"); ?>

	<div class="container">

		<? include("navigation.php"); ?>
		
		<div class="jumbotron">
			<?			
				$db->where ('emailaddress', $_POST['emailaddress']);
				$db->where ('password', 	md5($_POST['password']));				
				$user = $db->getOne("admin");
				
				if(is_array($user)){
					$_SESSION['admin'] = $user;
					echo "Excellent!  You're logged in.";
					
					echo 	'<script>
								window.setTimeout(function(){
									// Move to a new location or you can do something else
									window.location.href = "'.WEBROOT.'/admin/customer-list.php";
								}, 3000);
							</script>';
				} else {
					echo "Dang! forget your password?";
				}
			?>
		</div>
		
	</div>
		
<? include("../footer.php"); ?>  