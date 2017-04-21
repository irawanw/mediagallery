<?
	include("../includes/connections.php");
	include("../includes/functions.php");
	include("../includes/classes/admin.class.php");
	include("../admin/session.php");
	
	$params['offset'] 	= $_GET['start'];
	$params['count']	= $_GET['length'];	

	$customer 	= new Admin;
	$res		= $customer->get($params);
	
	//array intialization 
	$data['draws']			 = '';
	$data['recordsFiltered'] = 0;
	$data['recordsTotal'] 	 = 0;
	$data['data']			 = '';
	
	//echo "<pre>";
	//print_r($res);
	//echo "</pre>";
	
	if(is_array($res)){
		$i = 0;
		foreach($res as $row){
			$customerdata[$i][] 		= $row['firstname'].' '.$row['lastname'];
			$customerdata[$i][] 		= $row['emailaddress'];
			$customerdata[$i][] 		= '<a href="/wifi/admin/admin-edit.php?id='.$row['id'].'" class="edit" id="record-'.$row['id'].'">Edit</a> <a class="delete" id="record-'.$row['id'].'">Delete</a>';
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