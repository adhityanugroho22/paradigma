<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jenis_aspek extends DB_QM {

	/** Private Var for datatable **/
    private $post  = array();
	private $table = "M_JENIS_ASPEK";
	private $pKey  = "ID_JENIS_ASPEK";
	private $column_order = array(NULL, 'ID_JENIS_ASPEK','JENIS_ASPEK','BOBOT'); //set column for datatable order
    private $column_search = array('JENIS_ASPEK','BOBOT'); //set column for datatable search 
    private $order = array("ID_JENIS_ASPEK" => 'ASC'); //default order

    public function __construct(){
   # 	parent::__construct();
    	$this->post = $this->input->post();
    }

	/** Fetch table **/
	public function get(){
		$this->db->from($this->table);
	}

	/** Generate Query for DataTables **/
	public function get_query(){
		$this->get();
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
	}

	/** Execute get_query and return DataTables Data **/
	public function get_list() {
		$this->get_query();

		if($this->input->post('length') != -1){
			$this->db->limit($this->input->post('length'),$this->input->post('start'));
			$query = $this->db->get();
		}else{
			$query = $this->db->get();
		}

		return $query->result();
	}

	/** Get data by id **/
	public function get_by_id($key){
		$this->db->where($this->pKey, $key);
		$this->db->order_by(key($this->order), $this->order[key($this->order)]);
		$query = $this->db->get($this->table);
		return $query->row();
	}

	/** Get where **/
	public function get_where($where){
		$this->db->where($where);
		$query = $this->db->get($this->table);
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
		$this->get();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count where **/
	public function count_where($where){
		$this->db->where($where);
		$query = $this->db->get($this->table);
		return (int) $query->num_rows();
	}

	/** Execute insert query **/
	public function insert($data) {
		$res = array();
		$this->db->set($this->pKey,"SEQ_".$this->pKey.".NEXTVAL",FALSE);
		$this->db->set($data);
		$this->db->insert($this->table);
		if ($this->db->affected_rows()==0) {
			$res['res'] = FALSE;
			$res['msg'] = $this->db->error();
		}else{
			$res['res'] = TRUE;
			$res['msg'] = '';
		}
		return $res;
	}

	/** Execute update query **/
	public function update($id,$data) {
		$this->db->where($this->pKey, $id);
		$this->db->update($this->table, $data);
		if ($this->db->affected_rows()==0) {
			$res['res'] = FALSE;
			$res['msg'] = $this->db->error();
		}else{
			$res['res'] = TRUE;
			$res['msg'] = '';
		}
		return $res;
	}

	/** Execute update where query **/
	public function update_where($where,$data) {
		$this->db->where($where);
		$this->db->update($this->table, $data);
		if ($this->db->affected_rows()==0) {
			$res['res'] = FALSE;
			$res['msg'] = $this->db->error();
		}else{
			$res['res'] = TRUE;
			$res['msg'] = '';
		}
		return $res;
	}

	/** Execute delete query by pKey **/
	public function delete($id) {
		$this->db->delete($this->table, array($this->pKey=>$id)); 
	}

	/** Execute delete query with where **/
	public function delete_where($where) {
		$res = array();
		$this->db->where($where);
		$this->db->delete($this->table);
		if ($this->db->affected_rows()==0) {
			$res['res'] = FALSE;
			$res['msg'] = $this->db->error();
		}else{
			$res['res'] = TRUE;
			$res['msg'] = '';
		}
		return $res;
	}

}
	
	/* End of file M_jenis_aspek.php */
	/* Location: ./application/models/M_jenis_aspek.php */
?>
