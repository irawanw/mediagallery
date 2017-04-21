<? 
	include("../includes/connections.php");
	include("../includes/functions.php");
	include("../includes/classes/customer.class.php");
	include("../admin/session.php");
	
	$db->where('id', intval($_POST['id']));
	if($db->delete('customers')){
		echo "1";
	} else {
		echo "0";
	}
?>  