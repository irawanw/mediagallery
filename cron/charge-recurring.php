<?
	include("../includes/connections.php"); 
	include("../includes/functions.php"); 
	include("../includes/classes/customer.class.php"); 
	include("../includes/classes/admin.class.php"); 
	include("../includes/classes/payment.class.php");
	
	$payment = new Payment;
	
	$recurringdata = $db->rawQuery("SELECT * FROM `customers` WHERE `next_renewal` <= NOW()");
	
	if(count($recurringdata) == 0){
		echo "No recurring payment found. Bye!";
	} else {
		echo "Processing ".count($recurringdata)." recurring payment. Please wait...<br><br>". PHP_EOL . PHP_EOL;
	
		foreach($recurringdata as $row){
			
			//ok data found lets deactive them
			unset($data);
			$data['status'] = 0;
			$db->where('id', $row['id'], "=");		
			$id = $db->update('customers', $data);
			
			//recurring payment 
			$recurring = $payment->recurringtransaction($row['vaultid']);
			if((string)$recurring->result == 1){
				echo "Transaction for - "
								.$row['firstname']." ".$row['lastname']." - "
								.$row['vaultid']." - "
								.(string)$recurring->billing->{'cc-number'}." - "
								.(string)$recurring->{'result-text'}
								."<br>".PHP_EOL;
				
				//recurring success reactive user and update the renewal date
				$data['status'] 		= 1;
				$data['next_renewal']	= date("Y-m-d H:i:s", time()+(30*24*60*60));
				$db->where('id', $row['id'], "=");		
				$id = $db->update('customers', $data);
			} else {
				echo "Transaction for - "
								.$row['firstname']." ".$row['lastname']." - "
								.$row['vaultid']." - "
								.(string)$recurring->billing->{'cc-number'}." - "
								.(string)$recurring->{'result-text'}
								."<br>".PHP_EOL;
			}
				
			//flush the result to output
			ob_flush();
			flush();
			
			//wait for a while
			sleep(1);
		}
	}
?>