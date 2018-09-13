<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		$this->load->database();
		$offset = $this->config->item('offset');
	}
	
	function event_create($data){
		//event table data
		$val['event_image'] = $data['event_image'];
		$val['title'] = $data['event_title'];
		$val['event_content'] = $data['event_desc'];
		$val['sort'] = $data['event_order'];
		$val['event_category']=$data['event_category'];
		$val['created_at'] = $data['created_at'];
		$val['created_by'] = $data['created_by'];
		//event_item table data
		$val2['lang_id'] = $this->session->userdata('language');
		$val2['title'] = $data['event_title'];
		$val2['event_content'] = $data['event_desc'];
		$val2['created_at'] = $data['created_at'];
		$val2['created_by'] = $data['created_by'];
		
		$this->db->trans_begin();
		$this->db->insert('events',$val);
		$val2['event_id'] = $this->db->insert_id();
		$this->db->insert('event_item',$val2);
		
		///-----------activity insert----------//
		$ect['e_id'] = 8;
		$ect['e_primary_id'] = $val2['event_id'];
		$ect['created_at'] = $data['created_at'];
		$ect['created_by'] = $data['created_by'];
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 8;
		$logg['created_at'] = $data['created_at'];
		$logg['user_id'] = $data['created_by'];
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function event_list(){
		$l_id = $this->session->userdata('language');
		$this->db->select('ei.*,e.sort,e.event_image,e.publish,e.is_home,e.event_category');
		$this->db->join('event_item ei','ei.event_id = e.id','left');
		$this->db->join('languages l','l.l_id = ei.lang_id','left');
		$this->db->order_by('e.sort,e.created_at','ASC');
//		$this->db->limit(5);
		$result = $this->db->get_where('events e',array('e.status' => 1,'ei.lang_id'=>$l_id,'ei.status'=>1))->result_array();
		return $result;
	}
	
	function event_list_dashboard(){
		//$offset = $this->config->item('offset');
		$this->db->select('ei.*,e.sort,e.event_image,e.publish,e.is_home');
		$this->db->join('event_item ei','ei.event_id = e.id','left');
		$this->db->join('languages l','l.l_id = ei.lang_id','left');
		$this->db->order_by('e.sort,e.created_at','ASC');
		$this->db->limit(5,1);
		$result = $this->db->get_where('events e',array('e.status' => 1,'ei.status'=>1))->result_array();
		return $result;
	}
	
	function get_event_content($data){
		$this->db->select('ei.*,e.sort,e.event_category');
		$this->db->join('events e','e.id = ei.event_id');
		$result = $this->db->get_where('event_item ei',array('ei.event_id'=>$data['event_id'],'ei.lang_id'=>$data['lang_id'],'ei.status'=>1))->result_array();
	
		if(count($result)>0){
				
		}else{
			$this->db->select('ei.*,e.sort');
			$this->db->join('events e','e.id = ei.event_id');
			$result = $this->db->get_where('event_item ei',array('ei.event_id'=>$data['event_id'],'ei.lang_id'=>1,'ei.status'=>1))->result_array();
		}
		return $result;
	}
	
	function event_publish($data){
		$this->db->where('id',$data['e_id']);
		$this->db->update('events',array('publish'=>$data['status']));
		////////////////////////////////////////////////
		//$this->db->select('event_id');
		//$activity = $this->db->get_where('event_item',array('id'=>$data['e_id']))->result_array();
		///-----------activity insert----------//
		$ect['e_id'] = 10;
		$ect['e_primary_id'] = $data['e_id'];
		$ect['created_at'] = date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 10;
		$logg['activity_id'] = $this->db->insert_id();
		$logg['created_at'] =  date('y-m-d h:i');
		$logg['user_id'] =$this->session->userdata('user_id');
		$this->db->insert('logg',$logg);
		return true;
	}
	
	function is_home($data){
		$this->db->where('id',$data['e_id']);
		$this->db->update('events',array('is_home'=>$data['status1']));
		return true;
	}
	
	function event_delete($data){
		$this->db->where('id',$data['e_id']);
		$this->db->update('events',array('status'=>0));
		////////////////////////////////////
		//$this->db->select('event_id');
		//$activity = $this->db->get_where('event_item',array('id'=>$data['e_id']))->result_array();
		///-----------activity insert----------//
		$ect['e_id'] = 11;
		$ect['e_primary_id'] = $data['e_id'];
		$ect['created_at'] =date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 11;
		$logg['created_at'] =date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		
		return true;
	}
	
	function event_update($data){

		$this->db->trans_begin();		
		$this->db->select('event_id');
		$result = $this->db->get_where('event_item',array('id'=>$data['event_id'],'lang_id'=>(int)$this->session->userdata('language'),'status'=>1))->result_array();
		
		if(count($result) > 0){
			$this->db->where(array('id'=>$result[0]['event_id']));
			if(isset($data['event_image'])){
				$val['event_image'] = $data['event_image'];
				$this->db->update('events',array(
					'title' => $data['event_title'],
					'event_image' => $data['event_image'],
					'event_content' => $data['event_desc'],
					'sort' => $data['event_order'],
					'event_category'=>$data['event_category'],
					'updated_at' => $data['created_at'],
					'updated_by' => $data['created_by']
				));
			}
			else{
				$this->db->update('events',array(
					'title' => $data['event_title'],
					'event_content' => $data['event_desc'],
					'sort' => $data['event_order'],
					'event_category' => $data['event_category'],
					'updated_at' => $data['created_at'],
					'updated_by' => $data['created_by']
				));
			}
			
			
			$this->db->where(array('id'=>$data['event_id'],'lang_id'=>$this->session->userdata('language')));
			$this->db->update('event_item',array(
				'title' => $data['event_title'],
				'event_content' => $data['event_desc'],
				'updated_at' => $data['created_at'],
				'updated_by' => $data['created_by']
			));

		}	
		else{
			//subabmin update
			$this->db->select('event_id');
			$result = $this->db->get_where('event_item',array('id'=>$data['event_id'],'lang_id'=>1,'status'=>1))->result_array();
			
			$this->db->insert('event_item',array(
				'event_id' => $result[0]['event_id'],
				'lang_id' => $this->session->userdata('language'),
				'title' => $data['event_title'],
				'event_content' => $data['event_desc'],
				'created_at' => $data['created_at'],
				'created_by' => $data['created_by']
			));
		}
		//---------------------//
		$this->db->select('event_id');
		$activity = $this->db->get_where('event_item',array('id'=>$data['event_id']))->result_array();
		///-----------activity insert----------//
		$ect['e_id'] = 9;
		$ect['e_primary_id'] = $activity[0]['event_id'];
		$ect['created_at'] = $data['created_at'];
		$ect['created_by'] = $data['created_by'];
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 9;
		$logg['created_at'] = $data['created_at'];
		$logg['user_id'] = $data['created_by'];
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
		
	}
	
	function home_list_events(){
		$lang = $this->session->userdata('client_language');
		if($lang == ''){
			$lang = 1;
		}
		$this->db->select("ei.*,e.event_image,e.event_category,DATE_FORMAT(`e`.`created_at`,'%e %M, %Y') as created_at");
		$this->db->join('events e','e.id = ei.event_id');
		$this->db->order_by('e.sort,e.created_at,e.updated_at','ASC');
		$result = $this->db->get_where('event_item ei',array('ei.status' => 1,'e.status' => 1,'e.publish' => 1,'ei.lang_id' => $lang,'e.is_home' => 1))->result_array();
		//print_r($this->db->last_query()); die;
		return  $result;
		
	}
	
	function get_events_ajax($data){
		$l_id = (int)$this->session->userdata('language'); 
		
		if($data['is_home'] != 'NULL'){
			$this->db->where('e.is_home',(int)$data['is_home']);			
		}
		if($data['is_active'] != 'NULL'){
			$this->db->where('e.publish',(int)$data['is_active']);
		}
		if($data['search_text']){
			$this->db->like('ei.title',$data['search_text'],'after');
		}
		$offset = $this->config->item('offset');
		
		$this->db->select('ei.*,e.sort,e.event_image,e.publish,e.event_category,e.is_home');
		$this->db->join('event_item ei','ei.event_id = e.id','left');
		$this->db->join('languages l','l.l_id = ei.lang_id','left');
		$this->db->order_by('e.sort,e.created_at','ASC');
		$this->db->limit($offset,($offset * $data['page_count']));
		$result = $this->db->get_where('events e',array('e.status' => 1,'ei.lang_id'=>$l_id,'ei.status'=>1))->result_array();
		//print_r($this->db->last_query()); die;
		return $result;
	}
	
	function get_all_events_count(){
		$l_id = $this->session->userdata('language');
		$this->db->select('count(*) as total');
		$this->db->join('event_item ei','ei.event_id = e.id','left');
		$this->db->join('languages l','l.l_id = ei.lang_id','left');
		$this->db->order_by('e.sort,e.created_at','ASC');
		$result = $this->db->get_where('events e',array('e.status' => 1,'ei.lang_id'=>$l_id,'ei.status'=>1))->result_array();
		return $result;
	}
}
?>