<?
class Transaction{
    function __construct(){
         global $db;
         $this->db = $db;
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
		
		$res = $this->db->withTotalCount()->get('transactions', Array ($offset, $count));
		return $res;
	}	
}

?>