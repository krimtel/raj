<?php
class Event_model extends CI_Model {
	
	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->library(array('session'));
	}
	
	function event_list($cat){
		$l_id = $this->session->userdata('client_language');
			$this->db->select('ei.*,e.sort,e.event_image,e.id as eid,e.publish,e.is_home');
			$this->db->join('events e','e.id = ei.event_id');
			$this->db->order_by('e.sort','ASC');
			if($cat != 'All'){
				$result = $this->db->get_where('event_item ei',array('e.status'=>1,'e.event_category' => $cat,'ei.lang_id'=>$l_id ,'ei.status'=>1))->result_array();
			}
			else{	
				$result = $this->db->get_where('event_item ei',array('e.status'=>1,'ei.lang_id'=>$l_id ,'ei.status'=>1))->result_array();
			}
		return $result;
	}
	
	function event_cat_list(){
		$this->db->select('DISTINCT(event_category)');
		$result = $this->db->get_where('events',array('status'=>1))->result_array();
		return $result;
	}
	
	function video_search_list($data){
		$l_id = $this->session->userdata('client_language');
		$this->db->select('ei.*,e.sort,e.event_image,e.id as eid,e.publish,e.is_home');
		$this->db->join('events e','e.id = ei.event_id');
		$this->db->order_by('e.sort','ASC');
		$this->db->like('ei.title',$data['text'],'after');
		if($cat != 'All'){
			$result = $this->db->get_where('event_item ei',array('e.status'=>1,'e.event_category' => $cat,'ei.lang_id'=>$l_id ,'ei.status'=>1))->result_array();
		}
		else{
			$result = $this->db->get_where('event_item ei',array('e.status'=>1,'ei.lang_id'=>$l_id ,'ei.status'=>1))->result_array();
		}
		return $result;
	}
}
