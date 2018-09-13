<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mandi_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->model(array('admin/Language_model','admin/Users_model'));
		$this->load->library(array('session'));
		if(!$this->session->userdata('client_language')){
			$newdata = array(
					'client_language'  => '1',
					'lang_folder' => 'english'
			);
			$this->session->set_userdata($newdata);
		}
		//////////////temp/////////////////////////
		if($this->session->userdata('client_language') == 1)
			$this->lang->load('client_lang', 'english');
			else
				$this->lang->load('client_lang', 'hindi');
	}
	
	function index(){
		$this->db->select('*');
		$result = $this->db->get_where('states',array('status'=>1))->result_array();
		
		$result2 = $this->db->query("select m.mandi_id,m.mandi_name,m.address,m.contact,t1.* from mandis m join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s join district d on d.state_id = s.state_id) as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code limit 10")->result_array();
		$reult_count = $this->db->query("select count(*) as total from mandis m join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s join district d on d.state_id = s.state_id) as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'data2'=>$result2,'count'=>$reult_count,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function district($id){
		$this->db->select('*');
		$result = $this->db->get_where('district',array('state_id'=>$id,'status'=>1))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function manids($district,$state_id){
		$result = $this->db->query("SELECT * FROM mandis where district_name = '".$district."' AND state_code = (select state_code from states where state_id = ".$state_id.")")->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function commodity($mandi_id){
		$this->db->select('*');
		$result = $this->db->get_where('commodity',array('mandi_id'=>$mandi_id,'status'=>1))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function mandi_list(){
		$mandi_states = $this->input->post('mandi_states');
		$mandi_district = $this->input->post('mandi_district');
		$mandi_mandi = $this->input->post('mandi_mandi');
		$mandi_commodity = $this->input->post('mandi_commodity');
		
		$commodity_input = $this->input->post('co_name');
		if($commodity_input != ''){
		    $this->AllCommodity();
		}else{
		$page = $this->input->post('page');
		if($page != 0){
			$page = ($page-1) * 10;
		}
		
		$result = array();
		$reult_count = array();
		if($mandi_states != 0 && $mandi_district != 0 && $mandi_mandi != 0 && $mandi_commodity != 0){			
			$result = $this->db->query("select m.mandi_id,m.mandi_name,m.address,m.contact,t1.* from mandis m 
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s 
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states." AND d.district_id = ".$mandi_district.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code AND m.mandi_id = ".$mandi_mandi." limit ".$page.", 10")->result_array();
			
			$reult_count = $this->db->query("select count(*) as total from mandis m 
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s 
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states." AND d.district_id = ".$mandi_district.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code AND m.mandi_id = ".$mandi_mandi." limit ".$page.", 10")->result_array();
		}
		else if($mandi_states != 0 && $mandi_district == 0 && $mandi_mandi == 0 && $mandi_commodity == 0){
			$result = $this->db->query("select m.mandi_id,m.mandi_name,m.address,m.contact,t1.* from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code limit ".$page.", 10")->result_array();
			
			$reult_count = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		}
		
		else if($mandi_states != 0 && $mandi_district != 0 && $mandi_mandi == 0 && $mandi_commodity == 0){
			$result = $this->db->query("select m.mandi_id,m.mandi_name,m.address,m.contact,t1.* from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states." AND d.district_id = ".$mandi_district.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code limit ".$page.", 10")->result_array();
			
			$reult_count = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states." AND d.district_id = ".$mandi_district.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();	
		}
		
		else if($mandi_states != 0 && $mandi_district != 0 && $mandi_mandi != 0 && $mandi_commodity == 0){
			$result = $this->db->query("select m.mandi_id,m.mandi_name,m.address,m.contact,t1.* from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states." AND d.district_id = ".$mandi_district.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code AND m.mandi_id = ".$mandi_mandi." limit ".$page.", 10")->result_array();
			
			$reult_count = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states." AND d.district_id = ".$mandi_district.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code AND m.mandi_id = ".$mandi_mandi)->result_array();
			
		}
		
		else if($mandi_states == 0 && $mandi_district == 0 && $mandi_mandi == 0 && $mandi_commodity == 0){
			$result = $this->db->query("select m.mandi_id,m.mandi_name,m.address,m.contact,t1.* from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id) as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code limit ".$page.", 10")->result_array();
			
			$reult_count = $this->db->query("select count(*) as total from mandis m join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s join district d on d.state_id = s.state_id) as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		}

		if(count($result)>0){
			echo json_encode(array('data2'=>$result,'count'=>$reult_count,'page'=>$this->input->post('page'),'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
}//end of else condition...
	
	function commodity_list(){
		$mandi_id = $this->input->post('mandi_id');
		$this->db->select('*');
		$result = $this->db->get_where('commodity',array('mandi_id'=>$mandi_id,'status'=>1))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
		
	}
	
	public function AllCommodity(){
	    $commodity = $this->input->post('co_name');
	    
	    $page = $this->input->post('page');
	    if($page != 0){
	        $page = ($page-1) * 10;
	    }
	    //------------total count of records-----------------------------------------------
	    $this->db->select('co.c_id as id, co.commodity_name as commodity_name,ma.mandi_id as mandi_id, ma.mandi_name as mandi_name, ma.address as address, ma.contact as contact, ma.district_name as district_name, st.state_name as state_name, st.state_id as state_id');
	    $this->db->from('commodity co');
	    $this->db->join('mandis ma','ma.mandi_id=co.mandi_id','inner');
	    $this->db->join('states st','st.state_code=ma.state_code','inner');
	    $this->db->like('co.commodity_name', $commodity);
	    $this->db->where('co.status', 1);
	    $result_count = $this->db->get()->result_array();
	     
	    //----------pagination query------------------------------------------------------
	    $this->db->select('co.c_id as id, co.commodity_name as commodity_name,ma.mandi_id as mandi_id, ma.mandi_name as mandi_name, ma.address as address, ma.contact as contact, ma.district_name as district_name, st.state_name as state_name, st.state_id as state_id');
	    $this->db->from('commodity co');
	    $this->db->limit('10', $page);
	    $this->db->join('mandis ma','ma.mandi_id=co.mandi_id','inner');
	    $this->db->join('states st','st.state_code=ma.state_code','inner');	   
	    $this->db->like('co.commodity_name', $commodity);
	    $this->db->where('co.status', 1);
	    $result = $this->db->get()->result_array();
   
	    $count[0]['total'] = count($result_count);
	    if(count($result) > 0 ){
	        echo json_encode(array('data2'=>$result,'count'=>$count,'page'=>$this->input->post('page'),'status'=>200));
	    }else{
	        echo json_encode(array('status'=>500));
	    }
	}
	
	
}
