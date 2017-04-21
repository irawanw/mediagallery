<?
class Customer{
    function __construct(){
         global $db;
		 global $unifi;
		 $this->unifi = $unifi;
         $this->db = $db;
    }		
	
	function insert($param){
		$id = $this->db->insert('customers', $param);
		return $id;
	}
	
	function edit($param){
		$this->db->where ('id', $param['id']);
		$id = $this->db->update('customers', $param);
	}	
	
	function login($param){
		$this->db->where ('emailaddress', $param['emailaddress']);
		$this->db->where ('password', $param['password']);
		$this->db->where ('status', 1);
		$user = $this->db->getOne("customers");		
		
		if(is_array($user)){
			$_SESSION['user'] = $user;			
			
			//check wheter the device already on record
			$this->db->where ('mac_address', $_SESSION['id'], "=");
			$dev = $this->db->getOne('devices');			
			
			//echo "<pre>";
			//print_r($_SESSION);
			//print_r($dev);
			//echo "</pre>";
			
			//device on the record			
			if($dev['customers_id'] != ''){
				echo "Congratulation you've logged in!";
				$auth = $this->unifi->authorize_guest($_SESSION['id'], 60*24*30);
				redirect("");
				
			//new devices
			} else {				
				//count devices that already on the list
				$countdev = $this->db->rawQuery('SELECT COUNT(*) as numdev FROM `devices` WHERE `customers_id` = '.$_SESSION['user']['id']);
				
				if($countdev[0]['numdev'] >= $user['paid_devices']){
					echo 	"Sorry your device number already reach maximum.<br>
							Please contact administrator for upgrading your services.";
					return;
					
				//seats available
				} else {
					//record devices on table
					$devid = $this->add_devices($_SESSION['id']);				
					
					//unifi auth for 30 day
					$auth = $this->unifi->authorize_guest($_SESSION['id'], 60*24*30);
					redirect("");
				}
			}
			
		} else {
			echo "Sorry you're not allowed to access the services.";
		}
	}

	//get all customer function
	function get($params = ''){	
		if(is_array($params)){
			$offset = $params['offset'];
			$count 	= $params['count'];
		} else {
			$offset = 0;
			$count	= 25;
		}
		
		if($params['searchdata']){
			$this->db->where ('firstname', '%'.$params['searchdata'].'%', "LIKE");
			$this->db->orWhere ('lastname', '%'.$params['searchdata'].'%', "LIKE");
			$this->db->orWhere ('emailaddress', '%'.$params['searchdata'].'%', "LIKE");
		}		
		
		if($params['orderby']){
			$this->db->orderBy($params['orderby'], $params['orderdir']);
		}		
		
		$res = $this->db->withTotalCount()->get('customers', Array ($offset, $count));
		return $res;
	}
	
	//get customer by id
	function getbyid($id){
		$this->db->where ('id', $id, "=");
		$res = $this->db->getOne('customers');
		return $res;
	}
	
	//get last id of the customer
	function getlastid(){
		$res = $this->db->rawQuery('SELECT MAX(id) as lastid FROM `customers`');
		return $res[0]['lastid'];
	}
	
	function add_devices($mac){				
		$this->db->where ('mac_address', $mac, "=");
		$res = $this->db->getOne('devices');
		
		//device is unknown then lets record it
		if($res['customers_id'] == ''){
			unset($devices_data);
			$devices_data['customers_id'] 	= $_SESSION['user']['id'];
			$devices_data['mac_address'] 	= $mac;
			$devices_data['datecreation']	= date("Y-m-d H:i:s");
			$id = $this->db->insert('devices', $devices_data);
		} else{
			
			
		}		
	}
	
	function getdevices($id){
		$this->db->where('customers_id', $id, "=");
		$res = $this->db->get('devices');
		return $res;
	}
	
	function setstatus($id, $status){
		$param['status'] = $status;
		$this->db->where ('id', $id);
		$id = $this->db->update('customers', $param);	
	}

	function setpaid($id, $status){
		$param['paid'] = $status;
		$this->db->where ('id', $id);
		$id = $this->db->update('customers', $param);	
	}	
	
	function setpaid_selfie($id, $status){
		$param['paid_selfie'] = $status;
		$this->db->where ('id', $id);
		$id = $this->db->update('customers', $param);	
	}		
}

?>