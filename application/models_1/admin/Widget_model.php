<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		$this->load->database();
	}
	
	function all_widgets(){
		$this->db->select('*');
		$result = $this->db->get_where('widgets',array('status'=>1))->result_array();
		return $result;
	}
	
	function widget_create($data){
		if(isset($data['widget_id'])){
			
		}
		else{
			$this->db->trans_begin();
			$this->db->insert('widgets',array(
				'name' => $data['widget_name'],
				'created_at' => $data['created_at'],
				'created_by' => $data['created_by']
			));
			
			$id = $this->db->insert_id();
			
			$this->db->insert('widget_item',array(
				'widget_id' => $id,
				'lang_id' => $data['lang_id'],
				'w_title' => $data['widget_title'],
				'content' => $data['widget_content'],
				'created_at' => $data['created_at'],
				'created_by' => $data['created_by'],
				'ip' => $data['ip']
			));
			///-----------activity insert----------//
			$ect['e_id'] = 20;
			$ect['e_primary_id'] = $id;
			$ect['created_at'] = $data['created_at'];
			$ect['created_by'] = $data['created_by'];
			$this->db->insert('activity_tab',$ect);
			///-----------logg insert----------//
			$logg['event_id'] = 20;
			$logg['created_at'] = $data['created_at'];
			$logg['user_id'] = $data['created_by'];
			$logg['activity_id'] = $this->db->insert_id();
			$this->db->insert('logg',$logg);
			
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return array('msg'=>'something wrong.','status'=>500);
			}
			else{
				$this->db->trans_commit();
				return array('msg'=>'Widget created successfully.','status'=>200);
			}
		}
	}
	
// 	function widget_list(){
// 		$this->db->select('widget_item.id,widgets.w_id,widgets.name,widget_item.content');
// 		$this->db->join('widget_item','widget_item.widget_id=widgets.w_id');
// 		$result = $this->db->get_where('widgets',array('widgets.status'=>1,'widget_item.lang_id'=>(int)$this->session->userdata('language')))->result_array();
// 		return $result;
// 	}
	
	function widget_list(){
		$this->db->select('wi.*,w.name');
		$this->db->join('widget_item wi','wi.widget_id = w.w_id','left');
		$this->db->join('languages l','l.l_id = wi.lang_id','left');
		$this->db->order_by('w.created_at,w.updated_at','ASC');
		$result = $this->db->get_where('widgets w',array('w.status' => 1,'wi.status'=>1))->result_array();
		return $result;
	}
	
	function widget_update($data){
		$group = $this->session->userdata('group_name');
		if($group != 'admin' && $group != 'developer'){
			$this->db->select('widget_id');
			$result = $this->db->get_where('widget_item',array('id' => $data['widget_id'],'status' => 1))->result_array();
			$widget=array();
			if(count($result>0)){
				$this->db->select('*');
				$widget = $this->db->get_where('widget_item',array('lang_id'=>$data['lang_id'],'widget_id' => $result[0]['widget_id'],'status' => 1))->result_array();
			}
			
			if(count($widget) > 0){
				$this->db->where('id',$widget[0]['id']);
				$this->db->update('widget_item',array(
						'content' => $data['widget_content'],
						'updated_at' =>  $data['created_at'],
						'updated_by' => $data['created_by'],
						'ip'=>$data['ip']
				));
			}
			else {
				$this->db->insert('widget_item',array(
						'widget_id' => $result[0]['widget_id'],
						'lang_id' => $data['lang_id'],
						'content' => $data['widget_content'],
						'created_at' =>  $data['created_at'],
						'created_by' => $data['created_by'],
						'ip'=>$data['ip']
				));
			}
		}
		else {
			$this->db->select('widget_id');
			$result = $this->db->get_Where('widget_item',array('id'=>$data['widget_id'],'status'=>1))->result_array();
			
			$this->db->trans_begin();
			$this->db->where('w_id',$result[0]['widget_id']);
			$this->db->update('widgets',array(
				'name' => $data['widget_name'],
				'updated_by' => $data['created_by'],
				'updated_at' => $data['created_at']
			));

			$this->db->where(array('id'=>$data['widget_id'],'lang_id'=>(int)$this->session->userdata('language')));
			$this->db->update('widget_item',array(
				'w_title' => $data['widget_title'],
				'content' => $data['widget_content'],
				'updated_at' => $data['created_at'],
				'updated_by' => $data['created_by'],
				'ip' => $data['ip']
			));
		}
		///-----------activity insert----------//
		$this->db->select('widget_id');
		$activity = $this->db->get_where('widget_item',array('id'=>$data['widget_id']))->result_array();
		
		$ect['e_id'] = 21;
		$ect['e_primary_id'] = $activity[0]['widget_id'];
		$ect['created_at'] = $data['created_at'];
		$ect['created_by'] = $data['created_by'];
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 21;
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
	
	function widget_delete($data){
		$this->db->where('w_id',$data['w_id']);
		$this->db->update('widgets',array('status'=>0));
		$ect['e_id'] = 23;
///////////////////Activity////////////////////////////////
		$this->db->select('widget_id');
		$activity = $this->db->get_where('widget_item',array('id'=>$data['w_id']))->result_array();
		$ect['created_at'] = date('y-m-d h:i');
		$ect['e_primary_id'] = $activity[0]['widget_id'];
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 23;
		$logg['created_at'] = date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		
		return true;
	}
	
	function widget_content($data){
		$this->db->select('w.name,wi.*');
		$this->db->join('widget_item wi','wi.widget_id = w.w_id');
		$result = $this->db->get_where('widgets w',array('w.status'=>1,'wi.id'=>$data['widget_id']))->result_array();
		return $result;
	}
	
	function widget_name_check($data){
		$this->db->select('*');
		$result = $this->db->get_where('widgets',array('name'=>$data['str']))->result_array();
		return $result;
	}
	
	function home_content(){
		$l_id = $this->session->userdata('client_language');
		$this->db->select('*');
		$result = $this->db->get_where('widget_item',array('status'=>1,'widget_id'=>1,'lang_id'=>$l_id))->result_array();
		return $result;
	}
}
?>