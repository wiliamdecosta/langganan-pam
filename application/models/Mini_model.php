<?php


class Mini_model extends CI_Model {

	function get_list($table, $where = NULL, $limit = NULL,$order = NULL){
	    if($where){
            $this->db->where($where);
        }

        if($order){
	        foreach($order as $key=>$value){
                $this->db->order_by($key, $value);
            }

        }

        if($limit){
            $this->db->limit($limit);
        }
		$query = $this->db->get($table);
		return $query;
	}
	
	function get_list_join($table,$table_join,$join_id,$join_opt = 'inner',$order = NULL){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table_join, $table.'.'.$join_id.' = '.$table_join.'.'.$join_id, $join_opt);
		$query = $this->db->get();
		return $query;
	}

    function add_data($table,$data) {
		$query = $this->db->insert($table, $data);
		return $query;
    }
	
	function update_data($table,$where,$data){
		$this->db->where($where);
		$query = $this->db->update($table, $data);
		return $query;
	}
	
	function get_by_id($table,$array){
		//$array = array('name' => $name, 'title' => $title, 'status' => $status);
		//$this->db->where($array);	
		// Produces: WHERE name = 'Joe' AND title = 'boss' AND status = 'active'
		$this->db->where($array);
		$query = $this->db->get($table);
		return $query;
	}
	
	function delete_data($table,$array){
		$this->db->where($array);
        $query = $this->db->delete($table);
        return $query;
	}

}

/* End of file Groups.php */