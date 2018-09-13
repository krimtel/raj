<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Links_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		$this->load->database();
	}
	
	function link_create($data){
		$val['link_contect'] = $data['link_contect'];
		$val['created_at'] = $data['created_at'];
		$val['created_by'] = $data['user_id'];
		$val['sort'] = $data['sort'];
		
		$this->db->trans_begin();
		
			$this->db->insert('quick_links',$val);   //// insert links
			
			$val2['link_id'] = $this->db->insert_id();
			$val2['lang_id'] = 1;
			$val2['link_contect'] = $data['link_contect'];
			$val2['created_at'] = $data['created_at'];
			$val2['created_by'] = $data['user_id'];
			$this->db->insert('quick_links_item',$val2);  //// insert link language table
			
			$this->db->select('*');
			$result = $this->db->get_where('quick_links_item',array('id'=>$this->db->insert_id()))->result_array();
			
			///-----------activity insert----------//
			$ect['e_id'] = 16;
			$ect['e_primary_id'] = $val2['link_id'];
			$ect['created_at'] = $data['created_at'];
			$ect['created_by'] = $data['user_id'];
			$this->db->insert('activity_tab',$ect);
			///-----------logg insert----------//
			$logg['event_id'] = 16;
			$logg['created_at'] = $data['created_at'];
			$logg['user_id'] = $data['user_id'];
			$logg['activity_id'] = $this->db->insert_id();
			$this->db->insert('logg',$logg);
			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else {
			$this->db->trans_commit();
			return $result;
		}
	}

	function link_update($data){
		$group = $this->session->userdata('group_name');
		
		if($group != 'admin' && $group != 'developer'){
			/// language admin section
			$this->db->select('link_id');
			$result = $this->db->get_where('quick_links_item',array('id' => $data['link_id'],'status' => 1))->result_array();
			
			$links = array();
			if(count($result)>0){
				$this->db->select('*');
				$links = $this->db->get_where('quick_links_item',array('lang_id'=>$data['lang_id'],'link_id' => $result[0]['link_id'],'status' => 1))->result_array();
			}
			
			if(count($links) > 0){
				$this->db->where('id',$links[0]['id']);
				$this->db->update('quick_links_item',array(
					'link_contect' => $data['link_contect'],
					'updated_at' =>  $data['created_at'],
					'updated_by' => $data['user_id']
				));
			}
			else {
				$this->db->insert('quick_links_item',array(
					'link_id' => $result[0]['link_id'],
					'lang_id' => $data['lang_id'],
					'link_contect' => $data['link_contect'],
					'created_at' =>  $data['created_at'],
					'created_by' => $data['user_id']
				));
			}
			return true;
		}
		else{
			/// admin section
			$this->db->trans_begin();
				$this->db->where('id',$data['link_id']);
				$this->db->update('quick_links_item',array(
					'link_contect' => $data['link_contect'],
					'updated_at' => $data['created_at'],
					'updated_by' => $data['user_id']
				));
				
				$this->db->query("update quick_links set updated_at = '".$data['created_at']."',updated_by=".$data['user_id'].",sort=".$data['sort']." where id = (select link_id from quick_links_item where id=".$data['link_id'].")");
				//---------------------//
				$this->db->select('link_id');
				$activity = $this->db->get_where('quick_links_item',array('id'=>$data['link_id']))->result_array();
				///-----------activity insert----------//
				$ect['e_id'] = 17;
				$ect['e_primary_id'] = $activity[0]['link_id'];
				$ect['created_at'] = $data['created_at'];
				$ect['created_by'] = $data['user_id'];
				$this->db->insert('activity_tab',$ect);
				///-----------logg insert----------//
				$logg['event_id'] = 17;
				$logg['created_at'] = $data['created_at'];
				$logg['user_id'] = $data['user_id'];
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
	
	function link_list(){
		$this->db->select('qli.*,ql.sort,ql.publish');
		$this->db->join('quick_links_item qli','qli.link_id = ql.id','left');
		$this->db->join('languages l','l.l_id = qli.lang_id','left');
		$this->db->order_by('ql.sort,ql.created_at,ql.updated_at','ASC');
		$result = $this->db->get_where('quick_links ql',array('ql.status' => 1,'qli.status'=>1))->result_array();
		return $result;
	}
	
	function get_link_content($data){
		$this->db->select('qli.*,ql.sort');
		$this->db->join('quick_links ql','ql.id = qli.link_id');
		$result = $this->db->get_where('quick_links_item qli',array('qli.link_id'=>$data['link_id'],'qli.lang_id'=>$data['lang_id'],'qli.status'=>1))->result_array();
		
		if(count($result)>0){
			
		}else{
			$this->db->select('qli.*,ql.sort');
			$this->db->join('quick_links ql','ql.id = qli.link_id');
			$result = $this->db->get_where('quick_links_item qli',array('qli.link_id'=>$data['link_id'],'qli.lang_id'=>1,'qli.status'=>1))->result_array();
		}
		return $result;
	}
	
	function link_publish($data){
		$this->db->where('id',$data['l_id']);
		$this->db->update('quick_links',array('publish'=>$data['status']));
		//---------------------//
		$this->db->select('link_id');
		$activity = $this->db->get_where('quick_links_item',array('id'=>$data['l_id']))->result_array();
		///-----------activity insert----------//
		
		$ect['e_id'] = 18;
		$ect['e_primary_id'] = $activity[0]['link_id'];
		$ect['created_at'] = date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 18;
		$logg['created_at'] =date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		return true;
	}
	
	function link_delete($data){
		$this->db->where('id',$data['l_id']);
		$this->db->update('quick_links',array('status'=>0));
		//---------------------//
		$this->db->select('link_id');
		$activity = $this->db->get_where('quick_links_item',array('id'=>$data['l_id']))->result_array();
		$ect['e_id'] = 19;
		$ect['e_primary_id'] = $activity[0]['link_id'];
		$ect['created_at'] = date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		
		///-----------logg insert----------//
		$logg['event_id'] = 19;
		$logg['created_at'] =date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		
		return true;
	}
}
?>