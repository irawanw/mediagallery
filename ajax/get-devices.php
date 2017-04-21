<?
	include("../includes/connections.php");
	include("../includes/functions.php");
	include("../includes/classes/customer.class.php");
	include("../session.php");
	
	$params['offset'] 	= $_GET['start'];
	$params['count']	= $_GET['length'];	

	$customer 	= new Customer;
	$res		= $customer->getdevices($_SESSION['user']['id']);
	
	//array intialization 
	$data['draws']			 = '';
	$data['recordsFiltered'] = 0;
	$data['recordsTotal'] 	 = 0;
	$data['data']			 = '';
	
	//echo "<pre>";
	//print_r($_SESSION['user']['id']);
	//echo "</pre>";
	
	if(is_array($res)){
		$i = 0;
		foreach($res as $row){
			$customerdata[$i][] 		= $i+1;
			$customerdata[$i][] 		= $row['mac_address'];
			$customerdata[$i][] 		= $row['datecreation'];
			//$customerdata[$i][] 		= '<a href="/wifi/admin/customer-edit.php?id='.$row['id'].'" class="edit" id="record-'.$row['id'].'">Edit</a> <a class="delete" id="record-'.$row['id'].'">Delete</a>';
			$customerdata[$i][] 		= '<a class="delete" id="record-'.$row['id'].'">Delete</a>';
			$i++;
		}
	}
	
	//forming array data set
	$data['draws']			 = $_GET['draw'];
	$data['data']			 = $customerdata;
	$data['recordsFiltered'] = $db->totalCount;
	$data['recordsTotal'] 	 = $db->totalCount;	
	
	echo json_encode($data);
?>