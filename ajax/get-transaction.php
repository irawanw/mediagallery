<?
	include("../includes/connections.php");
	include("../includes/functions.php");
	include("../includes/classes/transaction.class.php");
	include("../admin/session.php");
	
	$_GET = $_POST;
	
	//column definition
	$column = array(
					0	=> 'datecreation',
					1	=> 'customerid',
					2	=> 'transid',
					3	=> 'firstname'
				);
	
	$params['offset'] 	= $_GET['start'];
	$params['count']	= $_GET['length'];	

	$params['orderby']	= $column[$_GET['order'][0]['column']];
	$params['orderdir']	= $_GET['order'][0]['dir'];
	$params['searchdata'] = $_GET['search']['value'];
	
	$transaction 	= new Transaction;
	$res			= $transaction->get($params);
	
	//array intialization 
	$data['draws']			 = '';
	$data['recordsFiltered'] = 0;
	$data['recordsTotal'] 	 = 0;
	$data['data']			 = '';
	
	if(is_array($res)){						
		$i = 0;
		foreach($res as $row){
			$customerdata[$i][] 		= $row['datecreation'];
			$customerdata[$i][] 		= '<a target="_blank" href="upload.php?id='.$row['customerid'].'">'.$row['customerid'].'</a>';
			$customerdata[$i][] 		= $row['transid'];
			$customerdata[$i][] 		= $row['firstname'];
			$customerdata[$i][] 		= $row['lastname'];
			$customerdata[$i][] 		= $row['emailaddress'];			
			$customerdata[$i][] 		= $row['address'].', '.$row['city'].', '.$row['state'].' '.$row['zipcode'];
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
