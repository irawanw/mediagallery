<?
	include("../includes/connections.php");
	include("../includes/functions.php");
	include("../includes/classes/customer.class.php");
	include("../admin/session.php");
	
	$_GET = $_POST;
	
	//column definition
	$column = array(
					0	=> 'firstname',
					1	=> 'lastname',
					2	=> 'emailaddress',
					3	=> 'datecreation'
				);
	
	$params['offset'] 	= $_GET['start'];
	$params['count']	= $_GET['length'];	

	$params['orderby']	= $column[$_GET['order'][0]['column']];
	$params['orderdir']	= $_GET['order'][0]['dir'];
	$params['searchdata'] = $_GET['search']['value'];
	
	$customer 	= new Customer;
	$res		= $customer->get($params);
	
	//array intialization 
	$data['draws']			 = '';
	$data['recordsFiltered'] = 0;
	$data['recordsTotal'] 	 = 0;
	$data['data']			 = '';
	
	if(is_array($res)){
		
		$status = array( 
							0 => 'Not Uploaded',
							1 => 'Uploaded',
							2 => 'Downloaded',
						);
		
		$i = 0;
		foreach($res as $row){
			$customerdata[$i][] 		= $row['firstname'];
			$customerdata[$i][] 		= $row['lastname'];
			$customerdata[$i][] 		= $row['emailaddress'];
			$customerdata[$i][] 		= $row['datecreation'];
			$customerdata[$i][] 		= '<a href="upload.php?id='.$row['id'].'">Upload</a>';
			$customerdata[$i][] 		= $status[$row['status']];
			$customerdata[$i][] 		= '<a href="'.WEBROOT.'/admin/customer-edit.php?id='.$row['id'].'" class="edit" id="record-'.$row['id'].'">Edit</a> 
											|	<a style="cursor: pointer" class="delete" id="record-'.$row['id'].'">X</a>
											|	<a onclick="return confirm(\'Are you sure you want to send the files to the customer?\')" 
													href="javascript:sendmail('.$row['id'].')">Send E-mail</a>';
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
