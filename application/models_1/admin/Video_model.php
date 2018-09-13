<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		$this->load->database();
	}

	function video_create($data){
		//video table data
		$val['v_title'] = $data['v_title'];
		$val['sort']=$data['v_order'];
		$val['v_url'] = $data['v_url'];
		$val['created_at'] = $data['created_at'];
		$val['created_by'] = $data['created_by'];
		$val['category_id'] = $data['category_id'];
		$this->db->trans_begin();
		$this->db->insert('video',$val);

		//video_item table data
		$val2['video_id'] = $this->db->insert_id();
		$val2['lang_id'] = $this->session->userdata('language');
		$val2['v_title'] = $data['v_title'];
		$val2['v_content'] = $data['v_desc'];
		$val2['created_at'] = $data['created_at'];
		$val2['created_by'] = $data['created_by'];

		$this->db->insert('video_item',$val2);
		///-----------activity insert----------//
		$ect['e_id'] = 28;
		$ect['e_primary_id'] = $val2['video_id'];
		$ect['created_at'] = $data['created_at'];
		$ect['created_by'] = $data['created_by'];
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 28;
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


	function Video_list(){
		$this->db->select('vi.*,v.sort,v.v_url,v.publish,v.is_home');
		$this->db->join('video v','v.v_id=vi.video_id');
		$this->db->order_by('v.sort','ASC');
		$result = $this->db->get_where('video_item vi',array('v.status'=>1, 'vi.status'=>1))->result_array();	
		return $result;
	}

	function video_home_page_list(){
		if((int)$this->session->userdata('client_language')==''){
			$language = 1;
		}else{
			$language=(int)$this->session->userdata('client_language');
		}
		$this->db->select('vi.*,v.sort,v.v_url,v.publish,v.is_home');
		$this->db->join('video v','v.v_id=vi.video_id');
		$this->db->order_by('v.sort,v.created_at,v.updated_at','ASC');
		$result = $this->db->get_where('video_item vi',array('v.status'=>1,'v.is_home' => 1,'vi.status'=>1,'vi.lang_id'=>$language))->result_array();
		
		return $result;
	}

	function video_publish($data){
		$this->db->where('v_id',$data['v_id']);
		$this->db->update('video',array('publish'=>$data['status']));
		//////////////Activity Insert////////////////////
		$this->db->select('video_id');
		$activity = $this->db->get_where('video_item',array('v_id'=>$data['v_id']))->result_array();
	  
		$ect['e_id'] = 30;
		$ect['e_primary_id'] = $activity[0]['video_id'];
		$ect['created_at'] = date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 30;
		$logg['created_at'] = date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		return true;
	}

	function video_is_home($data){
		$this->db->where('v_id',$data['v_id']);
		$this->db->update('video',array('is_home'=>$data['status1']));

		return true;
	}

	function video_delete($data){
		$this->db->where('v_id',$data['v_id']);
		$this->db->update('video',array('status'=>0));
		///////////////////////Activity Insert/////////////////
		$this->db->select('video_id');
		$activity = $this->db->get_where('video_item',array('v_id'=>$data['v_id']))->result_array();
		$ect['e_id'] = 31;
		$ect['e_primary_id'] = $activity[0]['video_id'];
		$ect['created_at'] = date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 31;
		$logg['created_at'] = date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		return true;
	}
	function get_video_data($data){
		$this->db->select('vi.*,v.v_url,v.sort,v.category_id');
		$this->db->join('video v','v.v_id = vi.video_id');
		$result = $this->db->get_where('video_item vi',array('vi.video_id'=>$data['v_id'],'vi.lang_id'=>$data['lang_id'],'vi.status'=>1))->result_array();

		if(count($result) > 0){

		}else{
			$this->db->select('vi.*,v.sort');
			$this->db->join('video v','v.v_id = vi.video_id');
			$result = $this->db->get_where('video_item vi',array('vi.video_id'=>$data['v_id'],'vi.lang_id'=>1,'vi.status'=>1))->result_array();
		}
		return $result;
	}

	function video_update($data){
	  
		$group = $this->session->userdata('group_name');
		if($group != 'admin' && $group != 'developer'){
			/// language admin section
			$this->db->select('video_id');
			$result = $this->db->get_where('video_item',array('v_id' => $data['v_id'],'status' => 1))->result_array();

			if(count($result)>0){
				$this->db->select('*');
				$video = $this->db->get_where('video_item',array('lang_id'=>$data['lang_id'],'video_id' => $result[0]['video_id'],'status' => 1))->result_array();
			}

			if(count($video) > 0){
				$this->db->where('v_id',$video[0]['v_id']);
				$this->db->update('video_item',array(
						'v_content' => $data['v_content'],
						'updated_at' =>  $data['updated_at'],
						'updated_by' => $data['updated_by'],
						'v_title' => $data['v_title']
				));
			}
			else {
				$this->db->insert('video_item',array(
						'video_id' => $result[0]['video_id'],
						'lang_id' => $data['lang_id'],
						'v_content' => $data['v_content'],
						'created_at' =>  $data['updated_at'],
						'created_by' => $data['updated_by'],
						'v_title' => $data['v_title']
				));
			}
			return true;
		}
		else{
		$this->db->trans_begin();
		$l_id =	$this->session->userdata('language');
			$this->db->select('v_id');
		$id = 	$this->db->get_where('video_item',array('video_id'=>$data['v_id'],'lang_id'=>$l_id,'status'=>1))->result_array();
				//print_r($this->db->last_query()); die;	
			$this->db->where('v_id',$id[0]['v_id']);
			$this->db->update('video_item',array(
					'v_content' => $data['v_content'],
					'v_title' => $data['v_title'],
					'updated_at' => $data['updated_at'],
					'updated_by' => $data['updated_by']
			));

			$this->db->query("update video set updated_at = '".$data['updated_at']."',v_url='".$data['v_url']."',category_id='".$data['category_id']."',updated_by='".$data['updated_by']."',sort='".$data['sort']."',v_title='".$data['v_title']."'
				where v_id = (select video_id from video_item where v_id=".$data['v_id'].")");
				//print_r($this->db->last_query()); die;
			///-----------activity insert----------//
			$this->db->select('video_id');
			$activity = $this->db->get_where('video_item',array('v_id'=>$data['v_id']))->result_array();

			$ect['e_id'] = 29;
			$ect['e_primary_id'] = $activity[0]['video_id'];
			$ect['created_at'] = $data['updated_at'];
			$ect['created_by'] = $data['updated_by'];
			$this->db->insert('activity_tab',$ect);
			///-----------logg insert----------//
			$logg['event_id'] = 29;
			$logg['created_at'] = $data['updated_at'];
			$logg['user_id'] = $data['updated_by'];
			$logg['activity_id'] = $this->db->insert_id();
			$this->db->insert('logg',$logg);
				
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}
			else {
				$this->db->trans_commit();
				return true;
			}
		}
	}

	function get_p_cat_list(){
		return $result = $this->db->get_where('video_category',array('status'=>1,'p_id'=>0))->result_array();
	}
	function get_cat_list(){
		$this->db->select('e1.* ,e2.category_name as p_name');
		$this->db->join('video_category e2','e2.v_id=e1.p_id' ,'left');
		$result = $this->db->get_where('video_category e1',array('e1.status' => 1))->result_array();
		return $result;
	}

	function category_create($data){
		$this->db->insert('video_category',array(
				'category_name' => $data['category_name'],
				'p_id' => $data['p_id'],
				'created_at' => $data['created_at'],
				'created_by' => $data['created_by'],
				'ip' => $data['ip']
		));
		return true;
	}
	function category_update($data){
		$this->db->where('v_id',$data['cat_id']);
		$this->db->update('video_category',array(
				'category_name' => $data['category_name'],
				'p_id' => $data['p_id'],
				'updated_at' =>$data['updated_at'],
				'updated_by' =>$data['updated_by'],
				'ip' =>$data['ip'],
		));
		return true;
	}

	function category_list(){
		$this->db->select('*');
		$result = $this->db->get_where('video_category',array('status' => 1))->result_array();
		return $result;
	}

	function category_detail($data){
		$this->db->select('*');
		return $result = $this->db->get_where('video_category',array('v_id'=>$data['v_id'],'status'=>1))->result_array();
	}
}
