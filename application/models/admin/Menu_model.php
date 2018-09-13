<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {
	
	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->library(array('session','ion_auth','form_validation','MY_form_validation'));
	}
	
	function get_all_parents_menu($p_id){
		$this->db->select('*');
		$this->db->order_by('sort');
		$result = $this->db->get_Where('menu',array('p_id'=>$p_id,'status'=>1))->result_array();
		return $result;
	}
	
	function menu_list(){
		$this->db->select('m.id,m.title,m.p_id,m.external_link,mi.m_id, mi.menu_name, mi.lang_id,l.l_name,m.cms_url');
		$this->db->join('menu_item mi','mi.menu_id = m.id','left');
		$this->db->join('languages l','l.l_id = mi.lang_id','left');
		$this->db->order_by('m.sort','ASC');
		$result = $this->db->get_where('menu m',array('m.status' => 1,'mi.status'=>1))->result_array();
		return $result;
	}
	
	function menu_content($data){
		$this->db->select('m.id,mi.m_id,mi.menu_name,m.sort,m.p_id,m.external_link,m.cms_url,m.page_id');
		$this->db->join('menu m','m.id = mi.menu_id');
		$result = $this->db->get_where('menu_item mi',array('mi.lang_id'=>$data['lang_id'],'mi.menu_id'=>$data['m_id'],'mi.status'=>1))->result_array();
		//print_r($this->db->last_query()); die;
		if(!$result){
			$this->db->select('m.id,m.id as menu_id,m.title as menu_name,m.sort,m.p_id,m.external_link,m.cms_url');
			$result = $this->db->get_where('menu m',array('m.id'=>$data['m_id']))->result_array();
			//print_r($result); die;
		}
		return $result;
	}
	
	function menu_create($data){
		$this->db->trans_begin();
			$this->db->insert('menu',$data);
			
			$m_id = $this->db->insert_id();
		
			$value['lang_id'] = $this->session->userdata('language');
			$value['menu_id'] = $m_id;
			$value['menu_name'] = $data['title'];
			$value['created_at'] = $data['created_at'];
			$value['created_by'] = $data['created_by'];
			$value['ip'] = $data['ip'];
			
			$this->db->insert('menu_item',$value);
			///-----------activity insert----------//
			$ect['e_id'] = 32;
			$ect['e_primary_id'] = $m_id;
			$ect['created_at'] = $data['created_at'];
			$ect['created_by'] = $data['created_by'];
			$this->db->insert('activity_tab',$ect);
			///-----------logg insert----------//
			$logg['event_id'] = 32;
			$logg['created_at'] = $data['created_at'];
			$logg['user_id'] = $data['created_by'];
			$logg['activity_id'] = $this->db->insert_id();
			$this->db->insert('logg',$logg);
			
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}
		else {
			$this->db->trans_commit();
			
			$data['menus'] = $this->menu_list();
			$json = json_encode($data['menus']);
			$file = FCPATH . '/software_files/Menu.txt';
			file_put_contents ($file, $json);
			return true;
		}
	}
	
	function menu_update($data){
		$this->db->trans_begin();
		$result = $this->db->get_where('menu_item',array('menu_id'=>$data['menu_id'],'lang_id'=>(int)$this->session->userdata('language'),'status'=>1))->result_array();
		
		if(count($result) > 0){
			if($this->ion_auth->is_admin()){ //print_r($this->input->post()); die;
				$this->db->where('id',$data['menu_id']);
				$this->db->update('menu',array(
						//'menu_slug' => $data['menu_slug'],
						'title' => $data['title'],
						'p_id' => $data['p_id'],
						'sort' => $data['sort'],
						'external_link' => $data['external_link'],
						'cms_url' => $data['cms_url'],
						'ip' => $data['ip'],
						'page_id' => $data['page_id'],
						'updated_at' => $data['created_at'],
						'updated_by' => $data['created_by'],
				));
			}
			else{
				$this->db->where('id',$data['menu_id']);
				$this->db->update('menu',array(
						//'menu_slug' => $data['menu_slug'],
						//'title' => $data['title'],
						'p_id' => $data['p_id'],
						//'sort' => $data['sort'],
						'external_link' => $data['external_link'],
						'cms_url' => $data['cms_url'],
						'ip' => $data['ip'],
						'page_id' => $data['page_id'],
						'updated_at' => $data['created_at'],
						'updated_by' => $data['created_by'],
				));
			}
			
			$this->db->where(array('menu_id' => $data['menu_id'],'lang_id'=>(int)$this->session->userdata('language'),'status'=>1));
			$this->db->update('menu_item',array(
					'menu_name' => $data['title'],
					'ip' => $data['ip'],
					'updated_at' => $data['created_at'],
					'updated_by' => $data['created_by'] 
			));
		}
		else{
			$this->db->insert('menu_item',array(
					'lang_id' => $this->session->userdata('language'),
					'menu_id' => $data['menu_id'],
					'menu_name' => $data['title'],
					'created_at' => $data['created_at'],
					'created_by' => $data['created_by'],
			));
		}
		
		///////////////////////Inseert Activity////////////////////////
		$ect['e_id'] = 33;
		$ect['e_primary_id'] = $data['menu_id'];
		$ect['created_at'] = $data['created_at'];
		$ect['created_by'] = $data['created_by'];
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 33;
		$logg['created_at'] = $data['created_at'];
		$logg['user_id'] = $data['created_by'];
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}
		else {
			$this->db->trans_commit();
			$data['menus'] = $this->menu_list();
			$json = json_encode($data['menus']);
			$file = FCPATH . '/software_files/Menu.txt';
			file_put_contents ($file, $json);
			return true;
		}
	}
	
	function menu_delete($data){
		if(isset($data['lang_id'])){
			$this->db->where(array('menu_id'=>$data['m_id'],'lang_id'=>$data['lang_id']));
			$this->db->update('menu_item',array('status'=>0));
		}
		else{
			$this->db->where('id',$data['m_id']);
			$this->db->update('menu',array('status'=>0));
		}
		/////////acvity_tab////////////////////////
		$ect['e_id'] = 35;
		$ect['e_primary_id'] = $data['m_id'];
		$ect['created_at'] = date('y-m-d h:i');
		$ect['created_by'] = $this->session->userdata('user_id');
		$this->db->insert('activity_tab',$ect);
		///-----------logg insert----------//
		$logg['event_id'] = 35;
		$logg['created_at'] = date('y-m-d h:i');
		$logg['user_id'] = $this->session->userdata('user_id');
		$logg['activity_id'] = $this->db->insert_id();
		$this->db->insert('logg',$logg);
		
		return true;
	}
}
?>