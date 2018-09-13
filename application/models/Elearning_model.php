<?php
class Elearning_model extends CI_Model {
	
	function __construct(){
		parent :: __construct();
		$this->load->helper(array('url','file'));
		$this->load->database();
		$this->load->library(array('session'));
	}
	
	function Video_list($cat){
$cat = urldecode($cat);
		$l_id = $this->session->userdata('client_language');
		
		if($cat != 'All'){
			$this->db->select('*');
			$category = $this->db->get_where('video_category',array('category_name'=>$cat))->result_array();
			if(count($category)>0){
				$this->db->select('vi.*,v.sort,v.v_url,v.v_id as vid,v.publish,v.is_home');
				$this->db->join('video v','v.v_id=vi.video_id');
				$this->db->order_by('v.sort','ASC');
				$result = $this->db->get_where('video_item vi',array('v.status'=>1,'v.category_id' => $category[0]['v_id'],'vi.lang_id'=>$l_id ,'vi.status'=>1))->result_array();

			}
			else{
				return false;
			}
		}
		else{
			$this->db->select('vi.*,v.sort,v.v_url,v.v_id as vid,v.publish,v.is_home');
			$this->db->join('video v','v.v_id=vi.video_id');
			$this->db->order_by('v.sort','ASC');
			$result = $this->db->get_where('video_item vi',array('v.status'=>1,'vi.lang_id'=>$l_id , 'v.publish'=>1,'vi.status'=>1))->result_array();	
		} //print_r($this->db->last_query()); die;
		return $result;
	}
	
	function Video_cat_list(){
		$this->db->select('*');
		$result = $this->db->get_where('video_category',array('status'=>1))->result_array();
		return $result;
	}
	
	function video_search_list($data){
		$l_id = $this->session->userdata('client_language');
		if($data['cat'] != 'All'){
			$this->db->select('*');
			$category = $this->db->get_where('video_category',array('category_name'=>$data['cat']))->result_array();
			
			$this->db->select('vi.*,v.sort,v.v_url,v.v_id as vid,v.publish,v.is_home');
			$this->db->join('video v','v.v_id=vi.video_id');
			$this->db->order_by('v.sort','ASC');
			$this->db->like('vi.v_title',$data['text'],'after');
			$result = $this->db->get_where('video_item vi',array('v.status'=>1,'v.category_id' => $category[0]['v_id'],'vi.lang_id'=>$l_id ,'vi.status'=>1,'v.status'=>1))->result_array();
			return $result;
		}
		else{
			$this->db->select('vi.*,v.sort,v.v_url,v.v_id as vid,v.publish,v.is_home');
			$this->db->join('video v','v.v_id=vi.video_id');
			$this->db->order_by('v.sort','ASC');
			$this->db->like('vi.v_title',$data['text'],'after');
			$result = $this->db->get_where('video_item vi',array('v.status'=>1,'vi.lang_id'=>$l_id ,'vi.status'=>1,'v.status'=>1))->result_array();
//prinr_r($this->db->last_query()); die;
			return $result;
		}
	}
	
	
	function get_videos($id){
		$l_id = $this->session->userdata('client_language');
		$this->db->select('v.*,vi.*');
		$this->db->join('video v','v.v_id=vi.video_id');
		return $videos1 = $this->db->get_where('video_item vi',array('vi.video_id'=>$id,'vi.lang_id'=>$l_id,'vi.status'=>1))->result_array();
	}
	
	function video_home_page_list($id){
		if((int)$this->session->userdata('client_language')==''){
			$language = 1;
		}else{
			$language=(int)$this->session->userdata('client_language');
		}
		$this->db->select('vi.*,v.sort,v.v_url,v.publish,v.is_home');
		$this->db->join('video v','v.v_id=vi.video_id');
		$this->db->order_by('v.sort,v.created_at,v.updated_at','ASC');
		$this->db->where_not_in('vi.video_id',$id);
		$result = $this->db->get_where('video_item vi',array('v.status'=>1,'vi.status'=>1,'vi.lang_id'=>$language))->result_array();
		//print_r($this->db->last_query()); die;
		return $result;
	}

}
