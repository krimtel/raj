<?php
class Enam_model extends CI_Model {
	
	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->library(array('session'));
	}
	function all_news(){
		$l_id = $this->session->userdata('client_language');
		if($l_id == ''){
			$l_id = 1;
		}
		$this->db->select('*');
		$this->db->join('news_item ni','ni.news_id = n.id');
		$this->db->order_by('n.sort,n.created_at,n.updated_at','ASC');
		$result = $this->db->get_where('news n',array('lang_id'=>$l_id,'n.status'=>1,'ni.status'=>1,'n.publish'=>1))->result_array();
		return $result;
	}
	
	function all_menus(){
		$l_id = $this->session->userdata('client_language');
		
		if($l_id == ''){
			$l_id = 1;
		}
		$this->db->select('*');
		$this->db->join('menu_item mi','mi.menu_id = m.id');
		$this->db->order_by('m.sort,m.created_at,m.updated_at','ASC');
		$result = $this->db->get_where('menu m',array('lang_id'=>$l_id,'m.status'=>1,'mi.status'=>1))->result_array();
		return $result;
	}
	
	function all_links(){
		$l_id = $this->session->userdata('client_language');
		if($l_id == ''){
			$l_id = 1;
		}
		$this->db->select('*');
		$this->db->join('quick_links_item qli','qli.link_id = ql.id');
		$this->db->order_by('ql.sort,ql.created_at,ql.updated_at','ASC');
		$result = $this->db->get_where('quick_links ql',array('lang_id'=>$l_id,'ql.status'=>1,'qli.status'=>1,'ql.publish'=>1))->result_array();
		//print_r($this->db->last_query()); die;
// 		print_r($result); die;
		return $result;
	}
}
