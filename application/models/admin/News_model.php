<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {
	function __construct(){
		parent :: __construct();
		$this->load->database();
	}
	
	function news_create($data){
		$val['news_contect'] = $data['news_contect'];
		$val['created_at'] = $data['created_at'];
		$val['created_by'] = $data['user_id'];
		$val['sort'] = $data['sort'];
		
		$this->db->trans_begin();
		
			$this->db->insert('news',$val);   //// insert news
			
			$val2['news_id'] = $this->db->insert_id();
			$val2['lang_id'] = 1;
			$val2['news_contect'] = $data['news_contect'];
			$val2['created_at'] = $data['created_at'];
			$val2['created_by'] = $data['user_id'];
			
			$this->db->insert('news_item',$val2);  //// insert news language table
			$news_id = $this->db->insert_id();
			$this->db->select('*');
			$result = $this->db->get_where('news_item',array('id'=>$this->db->insert_id()))->result_array();
			
			///-----------activity insert----------//
			$ect['e_id'] = 12;
			$ect['e_primary_id'] = $news_id;
			$ect['created_at'] = $data['created_at'];
			$ect['created_by'] = $data['user_id'];
			$this->db->insert('activity_tab',$ect);
			///-----------logg insert----------//
			$logg['event_id'] = 12;
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
	
	function news_update($data){
		$group = $this->session->userdata('group_name');
		if($group != 'admin' && $group != 'developer'){
			/// language admin section
			$this->db->select('news_id');
			$result = $this->db->get_where('news_item',array('id' => $data['news_id'],'status' => 1))->result_array();
			
			$news = array();
			if(count($result)>0){
				$this->db->select('*');
				$news = $this->db->get_where('news_item',array('lang_id'=>$data['lang_id'],'news_id' => $result[0]['news_id'],'status' => 1))->result_array();
			}
			
			if(count($news) > 0){
				$this->db->where('id',$news[0]['id']);
				$this->db->update('news_item',array(
					'news_contect' => $data['news_contect'],
					'updated_at' =>  $data['created_at'],
					'updated_by' => $data['user_id']
				));
			}
			else {
				$this->db->insert('news_item',array(
					'news_id' => $result[0]['news_id'],
					'lang_id' => $data['lang_id'],
					'news_contect' => $data['news_contect'],
					'created_at' =>  $data['created_at'],
					'created_by' => $data['user_id']
				));
			}
			return true;
		}
		else{
			/// admin section
			$this->db->trans_begin();
				$this->db->where('id',$data['news_id']);
				$this->db->update('news_item',array(
					'news_contect' => $data['news_contect'],
					'updated_at' => $data['created_at'],
					'updated_by' => $data['user_id']
				));
				
				$this->db->query("update news set updated_at = '".$data['created_at']."',updated_by=".$data['user_id'].",sort=".$data['sort']." where id = (select news_id from news_item where id=".$data['news_id'].")");
				
				$ect['e_id'] = 13;
				$ect['e_primary_id'] = $data['news_id'];
				$ect['created_at'] = $data['created_at'];
				$ect['created_by'] = $data['user_id'];
				$this->db->insert('activity_tab',$ect);
				///-----------logg insert----------//
				$logg['event_id'] = 13;
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
	
	function news_list(){
		$this->db->select('ni.*,n.sort,n.publish');
		$this->db->join('news_item ni','ni.news_id = n.id','left');
		$this->db->join('languages l','l.l_id = ni.lang_id','left');
		$this->db->order_by('n.sort,n.created_at,n.updated_at','ASC');
		$result = $this->db->get_where('news n',array('n.status' => 1,'ni.status'=>1))->result_array();
			return $result;
	}
	function news_list_dashboard(){
		$this->db->select('ni.*,n.sort,n.publish');
		$this->db->join('news_item ni','ni.news_id = n.id','left');
		$this->db->join('languages l','l.l_id = ni.lang_id','left');
		$this->db->order_by('n.sort,n.created_at,n.updated_at','ASC');
		$this->db->limit(5,1);
		$result = $this->db->get_where('news n',array('n.status' => 1,'ni.lang_id'=>$this->session->userdata('language'),'ni.status'=>1))->result_array();
			return $result;
	}
	
	function get_news_content($data){
		$this->db->select('ni.*,n.sort');
		$this->db->join('news n','n.id = ni.news_id');
		$result = $this->db->get_where('news_item ni',array('ni.news_id'=>$data['news_id'],'ni.lang_id'=>$data['lang_id'],'ni.status'=>1))->result_array();
		
		if(count($result)>0){
			
		}else{
			$this->db->select('ni.*,n.sort');
			$this->db->join('news n','n.id = ni.news_id');
			$result = $this->db->get_where('news_item ni',array('ni.news_id'=>$data['news_id'],'ni.lang_id'=>1,'ni.status'=>1))->result_array();
		}
		return $result;
	}
	
	function news_publish($data){
		$this->db->where('id',$data['n_id']);
		$this->db->update('news',array('publish'=>$data['status']));
		
		$ect['e_id'] = 14;
		$ect['e_primary_id'] = $data['n_id'];
		$ect['created_at'] = date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 14;
		$logg['created_at'] = date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		
		
		return true;
	}
	
	function news_delete($data){
		$this->db->where('id',$data['n_id']);
		$this->db->update('news',array('status'=>0));
		
		$ect['e_id'] = 15;
		$ect['e_primary_id'] = $data['n_id'];
		$ect['created_at'] = date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 15;
		$logg['created_at'] = date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		
		return true;
	}
}
?>