<?
class Admin{
    function __construct(){
         global $db;
         $this->db = $db;
    }
	
	//get all admin function
	function get($params = ''){	
		if(is_array($params)){
			$offset = $params['offset'];
			$count 	= $params['count'];
		} else {
			$offset = 0;
			$count	= 25;
		}
		$res = $this->db->withTotalCount()->get('admin', Array ($offset, $count));
		return $res;
	}
	
	//get admin by id
	function getbyid($id){
		$this->db->where ('id', $id, "=");
		$res = $this->db->getOne('admin');
		return $res;
	}
}

?>