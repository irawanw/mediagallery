<? 
	include("../includes/connections.php");
	include("../includes/functions.php");
	include("../includes/classes/admin.class.php");
	include("../admin/session.php");
	
	$db->where('id', intval($_POST['id']));
	if($db->delete('admin')){
		echo "1";
	} else {
		echo "0";
	}
?>  