<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Story_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		$this->load->database();
	}
	
	function story_list(){
		
		$this->db->select('si.*,s.story_image,s.s_id,s.sort,s.publish');
		$this->db->join('success_story_item si','si.success_id=s.s_id');
		$this->db->order_by('s.sort,s.created_at');
		$result = $this->db->get_where('success_story s',array('s.status'=>1,'si.status'=>1))->result_array();
		return $result;
	}
	
	function story_list_client(){
		$this->db->select('si.*,s.sort,s.s_id,s.story_image,s.publish');
		$this->db->join('success_story_item si','si.success_id = s.s_id');
		$this->db->order_by('s.sort,s.created_at');
		$result=$this->db->get_where('success_story s',array('s.status'=>1,'s.publish'=>1,'si.status'=>1))->result_array();
		return $result;
	}
	function get_story_content($data){
		$this->db->select('si.*,s.sort,s.s_id,s.story_image');
		$this->db->join('success_story s','s.s_id = si.success_id');
		$result = $this->db->get_where('success_story_item si',array('si.success_id'=>$data['story_id'],'si.lang_id'=>$data['lang_id'],'si.status'=>1))->result_array();
		
		if(count($result)>0){
				
		}else{
			$this->db->select('si.*,s.sort,s.s_id,s.story_image');
			$this->db->join('success_story s','s.s_id = si.success_id');
			$result = $this->db->get_where('success_story_item si',array('si.success_id'=>$data['story_id'],'si.lang_id'=>1,'si.status'=>1))->result_array();
		}
		return $result;
	}
	
        function story_create($data){
		$this->db->trans_begin();
			$val['story_image'] = $data['story_image'];
			$val['created_by'] = $data['created_by'];
			$val['created_at'] = $data['created_at'];
			$val['sort'] = $data['story_order'];
			$this->db->insert('success_story',$val);
			
			$x = $this->db->insert_id();
			$val1['success_Id'] = $x;
			$val1['title'] = $data['story_title'];
			$val1['success_content'] = $data['story_desc'];
			$val1['lang_id'] = (int)$this->session->userdata('user_id');
			$val1['created_by'] = $data['created_by'];
			$val1['created_at'] = $data['created_at'];
			$this->db->insert('success_story_item',$val1);

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}


	function story_update($data){
		
		$this->db->trans_begin();	
		$this->db->select('si_id,success_id');
		$result = $this->db->get_where('success_story_item',array('success_id'=>$data['sid'],'lang_id'=>(int)$this->session->userdata('language'),'status'=>1))->result_array();
		
		if(count($result) > 0){
			if(isset($data['slider_image'])){
				$this->db->where(array('s_id'=>$result[0]['success_id']));
				$this->db->update('success_story',array(
						'story_image' => $data['story_image'],
						'sort' => $data['story_order'],
						'updated_at' => $data['created_at'],
						'updated_by' => $data['created_by']
				));
			}
			else{
				$this->db->where(array('s_id'=>$result[0]['success_id']));
				$this->db->update('success_story',array(
						'sort' => $data['story_order'],
						'updated_at' => $data['created_at'],
						'updated_by' => $data['created_by']
				));
			}
			
			$this->db->where(array('si_id'=>$result[0]['si_id']));
			$this->db->update('success_story_item', array(
					'title' => $data['story_title'],
					'success_content' => $data['story_desc'],
					'updated_at' => $data['created_at'],
					'updated_by' => $data['created_by']
			));
		}
		else{
			$val['success_id'] = $data['sid'];
			$val['lang_id'] = (int)$this->session->userdata('language');
			$val['title'] = $data['story_title'];
			$val['success_content'] = $data['story_desc'];
			$val['created_at'] = $data['created_at'];
			$val['created_by'] = $data['created_by'];
			
			$this->db->insert('success_story_item',$val);

		}
	
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function story_publish($data){
		$result = $this->db->get_where('success_story',array('s_id'=>$data['story_id'],'status'=>1))->result_array();
		
		$this->db->where('s_id',(int)$result[0]['s_id']);
		$this->db->update('success_story',array('publish'=>$data['status']));
		return true;
	}
	
	function story_delete($data){
		$this->db->where('s_id',(int)$data['story_id']);
		$this->db->update('success_story',array('status'=>0));
		
		return true;
	}
}