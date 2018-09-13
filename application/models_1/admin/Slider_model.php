<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		$this->load->database();
	}
	
	function slider_create($data){
		$val['sid'] = $data['sid'];
		$val['alt_tag'] = $data['alt_tag'];
		$val['sort'] = $data['slider_order'];
		$val['created_at'] = $data['created_at'];
		$val['created_by'] = $data['created_by'];

		//slider_item table data
		$val2['lang_id'] = $this->session->userdata('language');
		$val2['alt_tag'] = $data['alt_tag'];
		$val2['slider_image'] = $data['slider_image'];
		$val2['created_at'] = $data['created_at'];
		$val2['created_by'] = $data['created_by'];		
		
		$this->db->trans_begin();
		$this->db->insert('slider',$val);
		$val2['slider_id'] = $this->db->insert_id();
		$this->db->insert('slider_item',$val2);
		//print_r($this->db->last_query()); die;
		$ect['e_id'] = 24;
		$ect['e_primary_id'] = $val2['slider_id'];
		$ect['created_at'] = $data['created_at'];
		$ect['created_by'] = $data['created_by'];
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 24;
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
	
	function slider_list(){
		$this->db->select('si.*,s.sort,s.publish');
		$this->db->join('slider_item si','si.slider_id=s.sid');
		$this->db->order_by('s.sort,s.created_at');
		$result=$this->db->get_where('slider s',array('s.status'=>1,'si.status'=>1))->result_array();
		return $result;
	}
	
	function slider_list_client(){
		$this->db->select('si.*,s.sort,s.publish');
		$this->db->join('slider_item si','si.slider_id = s.sid');
		$this->db->order_by('s.sort,s.created_at');
		$result=$this->db->get_where('slider s',array('s.status'=>1,'s.publish'=>1,'si.status'=>1))->result_array();
		return $result;
	}
	
	function slider_update($data){
		$this->db->trans_begin();
		
		$this->db->select('slider_id');
		$result = $this->db->get_where('slider_item',array('s_id'=>$data['sid'],'lang_id'=>(int)$this->session->userdata('language'),'status'=>1))->result_array();
		
		$this->db->select('s_id');
		$result1 = $this->db->get_where('slider_item',array('slider_id'=>$result[0]['slider_id'],'lang_id'=>(int)$this->session->userdata('language'),'status'=>1))->result_array();
		
		if(count($result) > 0){
			$this->db->where(array('sid'=>$result[0]['slider_id']));
			if(isset($data['slider_image'])){
				$this->db->update('slider',array(
						'alt_tag' => $data['alt_tag'],
						'sort' => $data['slider_order'],
						'updated_at' => $data['created_at'],
						'updated_by' => $data['created_by']
				));
			}
			else{
				$this->db->update('slider',array(
						'alt_tag' => $data['alt_tag'],
						'sort' => $data['slider_order'],
						'updated_at' => $data['created_at'],
						'updated_by' => $data['created_by']
				));
			}
				
			if(isset($data['slider_image'])){
				$this->db->where(array('s_id'=>$result1[0]['s_id']));
				$this->db->update('slider_item',array(
						'alt_tag' => $data['alt_tag'],
						'slider_image' => $data['slider_image'],
						'updated_at' => $data['created_at'],
						'updated_by' => $data['created_by']
				));
			}
			else{ 
				$this->db->where(array('s_id'=>$result1[0]['s_id']));
				$this->db->update('slider_item',array(
						'alt_tag' => $data['alt_tag'],
						'updated_at' => $data['created_at'],
						'updated_by' => $data['created_by']
				));
			}
	
		}
// 		else{
// 			//subabmin update
// 			$this->db->select('event_id');
// 			$result = $this->db->get_where('event_item',array('id'=>$data['event_id'],'lang_id'=>1,'status'=>1))->result_array();
				
// 			$this->db->insert('event_item',array(
// 					'event_id' => $result[0]['event_id'],
// 					'lang_id' => $this->session->userdata('language'),
// 					'title' => $data['event_title'],
// 					'event_content' => $data['event_desc'],
// 					'created_at' => $data['created_at'],
// 					'created_by' => $data['created_by']
// 			));
// 		}
	//////////////////////////////////////////////////
		$this->db->select('slider_id');
		$activity = $this->db->get_where('slider_item',array('s_id'=>$data['sid']))->result_array();
	//////////////////////////////////////////////////////////////////////////////////	
		$ect['e_id'] = 25;
		$ect['e_primary_id'] = $activity[0]['slider_id'];
		$ect['created_at'] = $data['created_at'];
		$ect['created_by'] = $data['created_by'];
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 25;
		$logg['activity_id'] = $this->db->insert_id();
		$logg['created_at'] = $data['created_at'];
		$logg['user_id'] = $data['created_by'];
		$this->db->insert('logg',$logg);
		////////////////////////////////////
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}	
	}
	
	function slider_publish($data){
		$result = $this->db->get_where('slider_item',array('s_id'=>$data['s_id'],'status'=>1))->result_array();
		
		$this->db->where('sid',(int)$result[0]['slider_id']);
		$this->db->update('slider',array('publish'=>$data['status']));
		////////////////////ACTIVITY INSERT//////////////////
		$this->db->select('slider_id');
		$activity = $this->db->get_where('slider_item',array('s_id'=>$data['s_id']))->result_array();
		$ect['e_id'] = 26;
		$ect['e_primary_id'] = $activity[0]['slider_id'];
		$ect['created_at'] = date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 26;
		$logg['created_at'] = date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		return true;
	}
	
	function slider_delete($data){
		$result = $this->db->get_where('slider_item',array('s_id'=>$data['s_id'],'status'=>1))->result_array();
		
		$this->db->where('sid',(int)$result[0]['slider_id']);
		$this->db->update('slider',array('status'=>0));
		////////////////////ACTIVITY INSERT////////////////////////
		$this->db->select('slider_id');
		$activity = $this->db->get_where('slider_item',array('s_id'=>$data['s_id']))->result_array();
		
		$ect['e_id'] = 27;
		$ect['e_primary_id'] = $activity[0]['slider_id'];
		$ect['created_at'] = date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 27;
		$logg['created_at'] = date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		return true;
	}
	
	
	function slider_create_subadmin($data){
		$this->db->select('slider_id');
		$result = $this->db->get_where('slider_item',array('s_id'=>$data['s_id']))->result_array();
		//print_r($this->db->last_query()); die;
		$this->db->select('*');
		$result1 = $this->db->get_where('slider_item',array('slider_id'=>$result[0]['slider_id'],'lang_id'=>$this->session->userdata('language'),'status'=>1))->result_array();
		
		if(count($result1) > 0){
			// update
			if((isset($data['slider_image']))){
				$this->db->where('s_id',$result1[0]['s_id']);
				$this->db->update('slider_item',array(
						'alt_tag' => $data['slider_tag_popup'],
						'updated_at' =>date('y-m-d h:i:s'),
						'slider_image' => $data['slider_image'],
						'updated_by' =>$this->session->userdata('user_id')
				));
			}
			else{
				$this->db->where('s_id',$result1[0]['s_id']);
				$this->db->update('slider_item',array(
						'alt_tag' => $data['slider_tag_popup'],
						'updated_at' =>date('y-m-d h:i:s'),
						'updated_by' =>$this->session->userdata('user_id')
				));
			}
			return true;	
		}
		else{
			//create
			if((isset($data['slider_image']))){
				$val['lang_id'] = (int)$this->session->userdata('language');
				$val['slider_id'] = (int)$result[0]['slider_id'];
				$val['alt_tag'] = $data['slider_tag_popup'];
				$val['slider_image'] = $data['slider_image'];
				$val['created_at'] = date('y-m-d h:i:s');
				$val['created_by'] = $this->session->userdata('user_id');
			}
			else{
				$val['lang_id'] = (int)$this->session->userdata('language');
				$val['slider_id'] = (int)$result[0]['slider_id'];
				$val['alt_tag'] = $data['slider_tag_popup'];
				$val['created_at'] = date('y-m-d h:i:s');
				$val['created_by'] = $this->session->userdata('user_id');
			}
			$this->db->insert('slider_item',$val);
			return true;
		}
	}
	
}