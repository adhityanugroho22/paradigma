<?php

class M_Component Extends DB_QM {
	private $post  = array();
	private $table = "M_COMPONENT";
	private $pKey  = "ID_COMPONENT";
	private $column_order = array(NULL, 'URUTAN'); //set column for datatable order
    private $column_search = array('NM_COMPONENT', 'KD_COMPONENT'); //set column for datatable search 
    private $order = array("ID_COMPONENT" => 'ASC'); //default order

	public function __construct(){
		$this->post = $this->input->post();
	}

	public function datalist(){
		$this->db->order_by("a.KD_COMPONENT");
		return $this->db->get("M_COMPONENT a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_COMPONENT",$keyword);
		return $this->db->get("M_COMPONENT")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_COMPONENT")->row();
	}
	
	public function get_data_by_id($ID_COMPONENT){
		$this->db->where("ID_COMPONENT",$ID_COMPONENT);
		return $this->db->get("M_COMPONENT")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_COMPONENT !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_COMPONENT")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_COMPONENT","SEQ_ID_COMPONENT.NEXTVAL",FALSE);
		$this->db->insert("M_COMPONENT");
	}
	
	public function update($data,$ID_COMPONENT){
		$this->db->set($data);
		$this->db->where("ID_COMPONENT",$ID_COMPONENT);
		$this->db->update("M_COMPONENT");
	}
	
	public function delete($ID_COMPONENT){
		$this->db->where("ID_COMPONENT",$ID_COMPONENT);
		$this->db->delete("M_COMPONENT");
	}

	public function get_query(){
		$this->db->select('*');
		$this->db->from($this->table);
	}

	public function get_list() {
		$this->get_query();
		$i = 0;

		//Loop column search
		foreach ($this->column_search as $item) {
			if($this->post['search']['value']){
				if($i===0){ //first loop
					$this->db->group_start(); //open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, strtoupper($this->post['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($this->post['search']['value']));
				}

				if(count($this->column_search) - 1 == $i){ //last loop
                    $this->db->group_end(); //close bracket
				}
			}
			$i++;
		}

		if(isset($this->post['order'])){ //order datatable
			$this->db->order_by($this->column_order[$this->post['order']['0']['column']], $this->post['order']['0']['dir']);
		}elseif (isset($this->order)) {
			$this->db->order_by(key($this->order), $this->order[key($this->order)]);
		}

		if($this->post['length'] != -1){
			$this->db->limit($this->post['length'],$this->post['start']);
			$query = $this->db->get();
		}else{
			$query = $this->db->get();
		}

		return $query->result();
	}

	/** Count query result after filtered **/
	public function count_filtered(){
		$this->get_query();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count all result **/
	public function count_all(){
		$this->get_query();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}	

}
