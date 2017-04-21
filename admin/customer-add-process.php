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
							"datecreation"	=> date('Y-m-d H:i:s')
				);				
				
				$transaction_data = $_POST;
				
				//if id empty then lets create new customer
				if($data['id'] == ''){
					$id = $db->insert('customers', $data);
					if($id){
						echo "Customer succesfully added!";
						
						echo 	'<script>
								window.setTimeout(function(){
									// Move to a new location or you can do something else
									window.location.href = "'.WEBROOT.'/admin/customer-list.php";
								}, 3000);
							</script>';
					} else {
							echo "Sorry something wrong";
					}
				}
				
				//oh there is id there lets update the customer data
				if($data['id'] != ''){					
					//remove datecration from updating
					unset($data['datecreation']);
					
					$db->where ('id', $data['id'], "=");
					$id = $db->update('customers', $data);
					if($id){
						echo "Customer succesfully edited!";						
						redirect('admin/customer-list.php');
					} else {
							echo "Sorry something wrong";
					}
				}				
			?>
		</div>
		
	</div>
		
<? include("../footer.php"); ?>  