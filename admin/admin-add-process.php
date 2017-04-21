<? include("../header.php"); ?>

	<div class="container">

		<? include("navigation.php"); ?>
		
		<div class="jumbotron">
			<?									
				$data = array (
							"id" 			=> $_POST['id'],
							"firstname" 	=> $_POST['firstname'],
							"lastname" 		=> $_POST['lastname'],
							"emailaddress" 	=> $_POST['emailaddress'],
							"password" 		=> md5($_POST['password']),
							
				);				
				
				$transaction_data = $_POST;
				
				//if id empty then lets create new admin
				if($data['id'] == ''){
					$id = $db->insert('admin', $data);
					if($id){
						echo "admin succesfully added!";
						
						echo 	'<script>
								window.setTimeout(function(){
									// Move to a new location or you can do something else
									window.location.href = "'.WEBROOT.'/admin/admin-list.php";
								}, 3000);
							</script>';
					} else {
							echo "Sorry something wrong";
					}
				}
				
				//oh there is id there lets update the admin data
				if($data['id'] != ''){
				
					//lets not update password for temporary
					unset($data['password']);
					
					$db->where ('id', $data['id'], "=");
					$id = $db->update('admin', $data);
					if($id){
						echo "Admin succesfully edited!";
						
						echo 	'<script>
								window.setTimeout(function(){
									// Move to a new location or you can do something else
									window.location.href = "'.WEBROOT.'/admin/admin-list.php";
								}, 1500);
							</script>';
					} else {
							echo "Sorry something wrong";
					}
				}				
			?>
		</div>
		
	</div>
		
<? include("../footer.php"); ?>  