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
			$this->db->select('ei.*,e.sort,e.event_image,e.id as eid,e.publish,e.is_home,e.event_category');
			$this->db->join('events e','e.id = ei.event_id');
			$this->db->order_by('e.sort','ASC');
			if($cat != 'All'){
				$result = $this->db->get_where('event_item ei',array('e.status'=>1,'e.event_category' => $cat,'ei.lang_id'=>$l_id,'e.publish'=>1,'ei.status'=>1))->result_array();
//print_r($this->db->last_query()); die;
			}
			else{	
				$result = $this->db->get_where('event_item ei',array('e.status'=>1,'ei.lang_id'=>$l_id,'e.publish'=>1 ,'ei.status'=>1))->result_array();
			}
		return $result;
	}
	
	function event_cat_list(){
		$this->db->select('DISTINCT(event_category)');
		$result = $this->db->get_where('events',array())->result_array();
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
	function event_gallery_content($data){
		$l_id = $this->session->userdata('client_language');
		
		$this->db->select('count(*) as total');
					$this->db->join('event_item ei','ei.event_id = e.id');
					$this->db->order_by('e.sort,e.created_at','ASC');
					if($data['event_category']=='All'){
						$output['result1'] = $this->db->get_where('events e',array('e.status' => 1,'ei.lang_id'=>$l_id,'ei.status'=>1))->result_array();
					}
					else{
						$output['result1'] = $this->db->get_where('events e',array('e.status' => 1,'ei.lang_id'=>$l_id,'ei.status'=>1,'e.event_category'=>$data['event_category']))->result_array();
					}
		
		if($data['event_category'] == 'All'){
			$this->db->select('ei.*,e.sort,e.title,e.event_category,e.event_image');
			$this->db->join('event_item ei','ei.event_id = e.id');
			$this->db->order_by('e.sort,e.created_at','ASC');
			 $this->db->limit(1,$data['sequence_id']);
			$output['result'] = $this->db->get_where('events e',array('e.status' => 1,'e.publish' => 1,'ei.lang_id'=>$l_id,'ei.status'=>1))->result_array();

		}
		else{
				$this->db->select('ei.*,e.sort,e.title,e.event_category,e.event_image');
				$this->db->join('event_item ei','ei.event_id = e.id');
				$this->db->order_by('e.sort,e.created_at','ASC');
				$output['result'] = $this->db->get_where('events e',array('e.status' => 1,'ei.lang_id'=>$l_id,'ei.status'=>1,'e.publish' => 1,'e.event_category'=>$data['event_category']))->result_array();
//print_r($this->db->last_query()); die;
			
		}
		return $output;
	}
}
