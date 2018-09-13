<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_ctrl extends CI_Controller {

	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->library(array('session'));
		$this->load->model(array('admin/Language_model','admin/Users_model','admin/Widget_model'));
	}
	
	function language_select(){
		$l_id = $this->input->post('l_id');
		
		$this->db->select('*');
		$result = $this->db->get_where('languages',array('l_id'=>$l_id))->result_array();
		
		$session_data = array(
			'client_language' => $l_id,
			'lang_folder' => $result[0]['l_eng']
		);
		$this->session->set_userdata($session_data);
		header('content-Type: application/json');
			echo json_encode(array('msg'=>'Language slected.','status'=>200));
		die;
	}
	
	function menu_activate($url_array){
$l_id = $this->session->userdata('client_language');

		$this->db->select('id,p_id');
		$result = $this->db->get_where('menu',array('cms_url'=>$url_array))->result_array();
		
		$brea = '';
		if(count($result)>0){
			if($result[0]['p_id']){
				$this->db->select('*');
				$breadcrum2 = $this->db->get_where('menu_item',array('menu_id'=>$result[0]['id'],'lang_id'=>$l_id))->result_array();
				
				$this->db->select('*');
				$breadcrum1 = $this->db->get_where('menu_item',array('menu_id'=>$result[0]['p_id'],'lang_id'=>$l_id))->result_array();
				
				$brea = $breadcrum1[0]['menu_name'].' / '.$breadcrum2[0]['menu_name'];
			}
			else{
				$this->db->select('*');
				$breadcrum1 = $this->db->get_where('menu_item',array('menu_id'=>$result[0]['id'],'lang_id'=>$l_id))->result_array();
				$brea = $breadcrum1[0]['menu_name'];
			}
		}
		
		$this->db->select('m.id,m.p_id,mi.menu_name');
		$this->db->join('menu_item mi','mi.menu_id = m.id');
		$result = $this->db->get_where('menu m',array('m.cms_url'=>$url_array,'mi.lang_id'=>$l_id))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'bredcrum'=>$brea,'status'=>200));
		}
		else{
			$url_array = ucwords(str_replace("-"," ",$url_array));
			echo json_encode(array('bredcrum'=>$url_array,'status'=>500));
		}
	}
	
	function get_all_states(){
		$this->db->select('*');
		$result = $this->db->get_where('training_state',array('status'=>1))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function get_all_training_data(){
		$data['s_id'] = $this->input->post('s_id');
		$data['apmc_id'] = $this->input->post('apmc_id');
		$data['search']  = $this->input->post('search');
		
		if($data['search'] != '') {
			$this->db->select('ts.state_code,ts.name as state_name,ta.apmc_code,ta.name as apmc_name');
			$this->db->join('training_state ts','ts.state_code = ta.state_id');
			$this->db->like('ta.name',$data['search'],'after');
			$result = $this->db->get_where('training_apmc ta',array('ta.status'=>1))->result_array();
		}
		else { 
			$this->db->select('ts.state_code,ts.name as state_name,ta.apmc_code,ta.name as apmc_name');
			$this->db->join('training_state ts','ts.state_code = ta.state_id');
			if($data['s_id'] != 0 && $data['s_id'] != ''){
				$this->db->where('ts.state_code',$data['s_id']);		
			}
			if($data['apmc_id'] != 0 && $data['apmc_id'] != ''){
				$this->db->where('ta.apmc_code',$data['apmc_id']);
			}
			$result = $this->db->get_where('training_apmc ta',array('ta.status'=>1))->result_array();
		}
		
		$new_array = array();
		foreach($result as $r){
			$temp = $r;
			$this->db->select('*');
			$tempdata = $this->db->get_Where('training_data',array('state_id'=>$r['state_code'],'apmc_id'=>$r['apmc_code'],'status'=>1))->result_array();
			if(count($tempdata)>0){
				$temp['round'][1]['apmc_id'] = $tempdata[0]['apmc_id'];
				$temp['round'][1]['vendor'] = $tempdata[0]['vendor'];
				$temp['round'][1]['training_plan_date'] = $tempdata[0]['training_plan_date'];
				$temp['round'][1]['training_date'] = $tempdata[0]['training_date'];
				$temp['round'][1]['no_of_farmer_participated'] = $tempdata[0]['no_of_farmer_participated'];
				$temp['round'][1]['no_of_traders_participated'] = $tempdata[0]['no_of_traders_participated'];
				$temp['round'][1]['no_of_ca_participated'] = $tempdata[0]['no_of_ca_participated'];
				$temp['round'][1]['apmc_staff_participated'] = $tempdata[0]['apmc_staff_participated'];
				$temp['round'][1]['other_participants'] = $tempdata[0]['other_participants'];
				$temp['round'][1]['total_participants'] = $tempdata[0]['total_participants'];
				$temp['round'][1]['feedback_score'] = $tempdata[0]['feedback_score'];
				
				$temp['round'][2]['apmc_id'] = $tempdata[1]['apmc_id'];
				$temp['round'][2]['vendor'] = $tempdata[1]['vendor'];
				$temp['round'][2]['training_plan_date'] = $tempdata[1]['training_plan_date'];
				$temp['round'][2]['training_date'] = $tempdata[1]['training_date'];
				$temp['round'][2]['no_of_farmer_participated'] = $tempdata[1]['no_of_farmer_participated'];
				$temp['round'][2]['no_of_traders_participated'] = $tempdata[1]['no_of_traders_participated'];
				$temp['round'][2]['no_of_ca_participated'] = $tempdata[1]['no_of_ca_participated'];
				$temp['round'][2]['apmc_staff_participated'] = $tempdata[1]['apmc_staff_participated'];
				$temp['round'][2]['other_participants'] = $tempdata[1]['other_participants'];
				$temp['round'][2]['total_participants'] = $tempdata[1]['total_participants'];
				$temp['round'][2]['feedback_score'] = $tempdata[1]['feedback_score'];
			}
			$new_array[] = $temp;
		}
		
		if(count($result)>0){
			echo json_encode(array('data'=>$new_array,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function get_all_apmcs(){
		$s_id = $this->input->post('s_id');
		$this->db->select('*');
		$result = $this->db->get_where('training_apmc',array('state_id'=>$s_id))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function get_all_training_data_date(){
		$data['date1'] = $this->input->post('date1');
		$data['date2'] = $this->input->post('date2');
		$data['s_id'] = $this->input->post('state_id');
		$data['apmc_id'] = $this->input->post('apmc_id');
		$data['search_text'] = $this->input->post('search_text');
		
		if($data['search_text'] == ''){
			$this->db->select('td.*,ta.apmc_code,ts.name as state_name,ta.name as apmc_name');
			$this->db->join('training_apmc ta','ta.apmc_code = td.apmc_id');
			$this->db->join('training_state ts','ts.state_code = td.state_id');
			if($data['s_id'] != 0 && $data['s_id'] != ''){
				$this->db->where('td.state_id',$data['s_id']);
			}
			if($data['apmc_id'] != 0 && $data['apmc_id'] != ''){
				$this->db->where('td.apmc_id',$data['apmc_id']);
			}
			$result = $this->db->get_Where('training_data td',array('td.status'=>1))->result_array();
			
			if($data['date1'] != '' && $data['date2'] != ''){
				$result = $this->db->query("SELECT `td`.*, `ta`.`apmc_code`, `ts`.`name` as `state_name`, `ta`.`name` as `apmc_name` FROM `training_data` `td` JOIN `training_apmc` `ta` ON `ta`.`apmc_code` = `td`.`apmc_id` JOIN `training_state` `ts` ON `ts`.`state_code` = `td`.`state_id` WHERE CAST(`td`.`training_date` AS datetime) >= CAST('".$data['date2']."' AS datetime) AND CAST(`td`.`training_date` AS datetime) <= CAST('".$data['date2']."' AS datetime) AND `td`.`status` = 1")->result_array();
			}
		}
		else{
			$this->db->select('*');
			$this->db->join('training_apmc ta','ta.apmc_code = td.apmc_id');
			$this->db->like('ta.name',$data['search_text'],'after');
			$result = $this->db->get_Where('training_data td',array('td.status'=>1))->result_array();
		}
		//print_r($this->db->last_query()); die;
		$apmc_ids = array();
		if(count($result)>0){
			foreach($result as $r){
				$apmc_ids[] = $r['apmc_code'];
			}
		}
		$apmc_ids = array_unique($apmc_ids);
		
		$this->db->select('ts.state_code,ts.name as state_name,ta.apmc_code,ta.name as apmc_name');
		$this->db->join('training_state ts','ts.state_code = ta.state_id');
		if(count($apmc_ids)>0){
			$this->db->where_in('ta.apmc_code',$apmc_ids);
		}
		$result = $this->db->get_where('training_apmc ta',array('ta.status'=>1))->result_array();
		
		$new_array = array();
		foreach($result as $r){
			$temp = $r;
			$this->db->select('*');
			$tempdata = $this->db->get_Where('training_data',array('state_id'=>$r['state_code'],'apmc_id'=>$r['apmc_code'],'status'=>1))->result_array();
			if(count($tempdata)>0){
				$temp['round'][1]['apmc_id'] = $tempdata[0]['apmc_id'];
				$temp['round'][1]['vendor'] = $tempdata[0]['vendor'];
				$temp['round'][1]['training_plan_date'] = $tempdata[0]['training_plan_date'];
				$temp['round'][1]['training_date'] = $tempdata[0]['training_date'];
				$temp['round'][1]['no_of_farmer_participated'] = $tempdata[0]['no_of_farmer_participated'];
				$temp['round'][1]['no_of_traders_participated'] = $tempdata[0]['no_of_traders_participated'];
				$temp['round'][1]['no_of_ca_participated'] = $tempdata[0]['no_of_ca_participated'];
				$temp['round'][1]['apmc_staff_participated'] = $tempdata[0]['apmc_staff_participated'];
				$temp['round'][1]['other_participants'] = $tempdata[0]['other_participants'];
				$temp['round'][1]['total_participants'] = $tempdata[0]['total_participants'];
				$temp['round'][1]['feedback_score'] = $tempdata[0]['feedback_score'];
		
				$temp['round'][2]['apmc_id'] = $tempdata[1]['apmc_id'];
				$temp['round'][2]['vendor'] = $tempdata[1]['vendor'];
				$temp['round'][2]['training_plan_date'] = $tempdata[1]['training_plan_date'];
				$temp['round'][2]['training_date'] = $tempdata[1]['training_date'];
				$temp['round'][2]['no_of_farmer_participated'] = $tempdata[1]['no_of_farmer_participated'];
				$temp['round'][2]['no_of_traders_participated'] = $tempdata[1]['no_of_traders_participated'];
				$temp['round'][2]['no_of_ca_participated'] = $tempdata[1]['no_of_ca_participated'];
				$temp['round'][2]['apmc_staff_participated'] = $tempdata[1]['apmc_staff_participated'];
				$temp['round'][2]['other_participants'] = $tempdata[1]['other_participants'];
				$temp['round'][2]['total_participants'] = $tempdata[1]['total_participants'];
				$temp['round'][2]['feedback_score'] = $tempdata[1]['feedback_score'];
			}
			$new_array[] = $temp;
		}
		
		if(count($new_array)>0){
			echo json_encode(array('data'=>$new_array,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function commodity_parameter(){
		$data['id'] = $this->input->post('id');
		$data['language'] = $this->session->userdata('client_language');
		$this->db->select('*');
		$result = $this->db->get_Where('commodity_parameters',array('comm_id'=>$data['id'],'lang_id'=>$data['language'],'status'=>1))->result_array();
		//print_r($this->db->last_query()); die;
		//print_r($result); die;
	
		$str = html_entity_decode($result[0]['comm_desc']);
	
	
		$regex = "/\[(.*?)\]/";
		$data['output'] = $str;
		preg_match_all($regex, $str, $matches);
		for($i =0; $i < count($matches[1]); $i++){
			$result[0]['comm_desc'] = str_replace($matches[0][$i],$this->substring->image_path(),$result[0]['comm_desc']);
		}
	
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function get_district_map(){
		$data['state_id'] = $this->input->post('state_id');
		$data['language'] = $this->session->userdata('client_language');
		
		$this->db->select('s.state_name,d.*');
		$this->db->join('states s','s.state_id = d.state_id');
                $this->db->order_by('d.district_name','asc');
		$result = $this->db->get_where('district d',array('d.state_id'=>$data['state_id']))->result_array();
		
		$reult_count = $this->db->query("select count(*) as total from mandis m join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s join district d on d.state_id = s.state_id AND s.state_id = ".$result[0]['state_id'].") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
					
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'count'=>$reult_count,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}

function get_mandi_count(){
		$mandi_states = 26;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['26'] = $result[0]['total'];
		
		$mandi_states = 602;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['602'] = $result[0]['total'];
		
		$mandi_states = 43;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['43'] = $result[0]['total'];
		
		$mandi_states = 32;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['32'] = $result[0]['total'];
		
		$mandi_states = 385;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['385'] = $result[0]['total'];
		
		$mandi_states = 22;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['22'] = $result[0]['total'];
		
		$mandi_states = 296;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['296'] = $result[0]['total'];
		
		$mandi_states = 28;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['28'] = $result[0]['total'];
		
		$mandi_states = 276;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['276'] = $result[0]['total'];
		
		$mandi_states = 509;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['509'] = $result[0]['total'];
		
		$mandi_states = 384;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['384'] = $result[0]['total'];
		
		$mandi_states = 100;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['100'] = $result[0]['total'];
		
		$mandi_states = 569;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['569'] = $result[0]['total'];
		
		$mandi_states = 47;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['47'] = $result[0]['total'];
		
		$mandi_states = 20;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['20'] = $result[0]['total'];
		
		$mandi_states = 46;
		$result = $this->db->query("select count(*) as total from mandis m
					join (SELECT s.state_name,d.district_name,d.district_id,s.state_id,s.state_code FROM states s
					join district d on d.state_id = s.state_id AND s.state_id = ".$mandi_states.") as t1 on t1.district_name = m.district_name AND t1.state_code = m.state_code")->result_array();
		$dara['46'] = $result[0]['total'];
		
		echo json_encode(array('data'=>$dara,'status'=>200));
	}
	
	function commodity_search(){
		$data['string'] = $this->input->post('string');
		$data['language'] = $this->session->userdata('client_language');
		
		$this->db->select('*');
		$this->db->like('commodity_name',$data['string'],'both');
		$this->db->group_by('commodity_id');
		$result = $this->db->get_Where('commodity',array('status'=>1))->result_array();
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
}
